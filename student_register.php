<?php
include "header.php";
include "link.php";
include "verify_user.php";
require "dbcon.php";

// PHPMailer Dependencies
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$confirmPass_err = "";
$username_err = "";
$email_err = "";

if (isset($_POST['register'])) {
    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        $secretKey = '6LcHn1MqAAAAAH7iclHUOfiHN5PnAh6PV7PF2fjO';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);

        if (!$responseData->success) {
            $error_mssg = "Please verify that you are not a robot.";
        } else {
            if (!preg_match("/^[a-zA-Z0-9._%+-]+@(my\.cspc\.edu\.ph|gmail\.com)$/", $_POST["s_email"])) {
                $email_err = "Please use Student Email: @my.cspc.edu.ph";
            } elseif (!empty($_POST["s_password"]) && !empty($_POST["s_confirmPassword"])) {
                if (!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $_POST['s_password'])) {
                    $confirmPass_err = "Password must be at least 8 characters long, including 1 uppercase letter, 1 number, and 1 special character.";
                } elseif ($_POST["s_password"] != $_POST["s_confirmPassword"]) {
                    $confirmPass_err = "Password confirmation does not match";
                } else {
                    $s_username = $_POST['s_username'];
                    $s_email = $_POST['s_email'];

                    // Check if the username or email already exists
                    $query = "SELECT * FROM students WHERE s_username='$s_username'";
                    $result = mysqli_query($conn, $query);
                    $e_query = "SELECT * FROM students WHERE s_email='$s_email'";
                    $e_result = mysqli_query($conn, $e_query);

                    if (mysqli_num_rows($result) > 0) {
                        $username_err = "Username already exists";
                    } elseif (mysqli_num_rows($e_result) > 0) {
                        $email_err = "Email already exists";
                    } else {
                        $otp = rand(100000, 999999);
                        //Store Data Temporarily
                        $_SESSION['registration_data'] = [
                            's_fname' => $_POST['s_fname'],
                            's_lname' => $_POST['s_lname'],
                            's_course' => $_POST['s_course'],
                            's_section' => $_POST['s_section'],
                            's_year' => $_POST['s_year'],
                            's_email' => $_POST['s_email'],
                            's_username' => $_POST['s_username'],
                            's_password' => password_hash($_POST['s_password'], PASSWORD_DEFAULT),
                            'otp' => $otp,
                            'otp_created_at' => time(),
                        ];

                        //PHPMailer Section
                        $mail = new PHPMailer(true);
                        try {
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'rondale.bufete7@gmail.com';
                            $mail->Password = 'wppmgxruzoeclqal';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 587;

                            $mail->setFrom('rondale.bufete7@gmail.com', 'Library Management');
                            $mail->addAddress($s_email);

                            $mail->isHTML(true);
                            $mail->Subject = 'Verify Your Registration - OTP Code';
                            $mail->Body = "
                                            <p>Dear {$_POST['s_fname']},</p>
                                            <p>Thank you for registering with <strong>University Library</strong>. To complete your registration, please verify your email address by entering the One-Time Password (OTP) provided below:</p>
                                            <h2 style='text-align: center; color: #2d89ef;'>Your Verification Code: <strong'>$otp</strong></h2>
                                            <p>This OTP is valid for <strong>10 minutes</strong>.</p>
                                            <p>If you did not attempt to register, please ignore this email or contact our support team.</p>
                                            <br>
                                            <p>Best regards,<br>
                                            The Library Management System Team</p>
                                            <p><small>This is an automated email. Please do not reply directly to this email.</small></p>
                                        ";

                            $mail->send();

                            header("Location: verify_otp.php");

                            exit();
                        } catch (Exception $e) {
                            $error_mssg = "OTP could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Registration Form</title>

    <script>
        function enableSubmitButton() {
            document.getElementById("submitForm").disabled = false;
        }
    </script>

    <style>
        small.error_mssg {
            color: red !important;
        }

        .container-row {
            height: 100vh;
            overflow: hidden;
        }

        .container-col {
            backdrop-filter: blur(1px);
            background-color: rgba(0, 0, 0, 0.8);
            padding-left: 25px;
            padding-right: 25px;
            border: 0.5 solid black;
        }

        .captcha-div {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-wrapper div {
            margin: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="container-row">
            <div class="container-col">
                <h2>Student Registration</h2>

                <form class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                    <!-- First Name input -->
                    <div class="input-wrapper">
                        <input type="text" name="s_fname" placeholder="First Name" required value="<?php echo isset($_POST['s_fname']) ? htmlspecialchars($_POST['s_fname']) : ''; ?>">
                    </div>

                    <!-- Last Name input -->
                    <div class="input-wrapper">
                        <input type="text" name="s_lname" placeholder="Last Name" required value="<?php echo isset($_POST['s_lname']) ? htmlspecialchars($_POST['s_lname']) : ''; ?>">
                    </div>

                    <!-- Course input -->
                    <div class="input-wrapper">
                        <input type="text" name="s_course" placeholder="Course" required value="<?php echo isset($_POST['s_course']) ? htmlspecialchars($_POST['s_course']) : ''; ?>">
                    </div>

                    <!-- Section input -->
                    <div class="input-wrapper">
                        <input type="text" name="s_section" placeholder="Section" required value="<?php echo isset($_POST['s_section']) ? htmlspecialchars($_POST['s_section']) : ''; ?>">
                    </div>

                    <!-- Year input -->
                    <div class="input-wrapper">
                        <input type="number" name="s_year" placeholder="Year" required value="<?php echo isset($_POST['s_year']) ? htmlspecialchars($_POST['s_year']) : ''; ?>">
                    </div>

                    <!-- Email input -->
                    <div class="input-wrapper">
                        <input type="email" name="s_email" placeholder="Student Email" required value="<?php echo isset($_POST['s_email']) ? htmlspecialchars($_POST['s_email']) : ''; ?>" pattern="[a-zA-Z0-9._%+-]+@my\.cspc\.edu\.ph" title="Email must be in the format: @my.cspc.edu.ph">
                    </div>
                    <small class="error_mssg">
                        <?php echo $email_err; ?>
                    </small>

                    <!-- Username input -->
                    <div class="input-wrapper">
                        <input type="text" name="s_username" placeholder="Username" required value="<?php echo isset($_POST['s_username']) ? htmlspecialchars($_POST['s_username']) : ''; ?>">
                    </div>
                    <small class="error_mssg">
                        <?php echo $username_err; ?>
                    </small>

                    <!-- Password input -->
                    <div class="input-wrapper">
                        <input type="password" name="s_password" placeholder="Password" required
                            pattern="(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}"
                            title="Password must contain at least 8 characters, including 1 uppercase letter, 1 number, and 1 special character.">
                    </div>
                    <small class="error_mssg">
                        <?php echo $confirmPass_err; ?>
                    </small>

                    <!-- Confirm Password input -->
                    <div class="input-wrapper">
                        <input type="password" name="s_confirmPassword" placeholder="Confirm Password" required>
                    </div>

                    <!-- Submit button -->
                    <div class="input-wrapper input-wrapper-submit">
                        <input type="submit" id="submitForm" value="register" name="register" data-sitekey="6LcHn1MqAAAAAEHIjMkq5jj1L_DO8KDx1bW2Nk3v" disabled="disabled">
                    </div>

                    <!-- Google Recaptcha-->
                    <div class="captcha-div">
                        <div class="g-recaptcha" data-sitekey="6LcHn1MqAAAAAEHIjMkq5jj1L_DO8KDx1bW2Nk3v" data-callback="enableSubmitButton"></div>
                    </div>

                    <!-- Go Back link -->
                    <div class="goBack">
                        <a href="index.php">Go Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>