<?php
include "header.php";
include "link.php";
require "dbcon.php";
session_start();
// Resend the OTP email using PHPMailer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if OTP resend is requested
if (isset($_POST['resend_otp'])) {
    if (isset($_SESSION['registration_data'])) {
        // Generate a new OTP
        $new_otp = rand(100000, 999999);
        $_SESSION['registration_data']['otp'] = $new_otp;
        $_SESSION['registration_data']['otp_created_at'] = time();



        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'rondale.bufete7@gmail.com';
            $mail->Password = 'wppmgxruzoeclqal';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $data = $_SESSION['registration_data'];
            $mail->setFrom('rondale.bufete7@gmail.com', 'Library Management');
            $mail->addAddress($data['s_email']);

            $mail->isHTML(true);
            $mail->Subject = 'Resend OTP - Verify Your Registration';
            $mail->Body = "
                <p>Dear {$data['s_fname']},</p>
                <p>Your new OTP code for registration is:</p>
                <h2 style='text-align: center; color: #2d89ef;'>{$new_otp}</h2>
                <p>This OTP is valid for <strong>10 minutes</strong>.</p>
                <p>If you did not request this, please contact support.</p>
                <br>
                <p>Best regards,<br>The Library Management System Team</p>
            ";

            $mail->send();
            $success_msg = "A new OTP has been sent to your email: ";
        } catch (Exception $e) {
            $error_mssg = "OTP resend failed. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $error_mssg = "No registration data found. Please register again.";
        header("Location: student_register.php");
        exit();
    }
}

if (isset($_POST['verify_otp'])) {
    $entered_otp = $_POST['otp'];

    if (isset($_SESSION['registration_data'])) {
        $stored_otp = $_SESSION['registration_data']['otp'];
        $otp_created_at = $_SESSION['registration_data']['otp_created_at'] ?? 0;

        //OTP expiration Logic
        if (time() - $otp_created_at > 600) { // 600 seconds = 10 minutes
            $error_mssg = "The OTP has expired. Please request a new one.";
        } elseif ($entered_otp == $stored_otp) {
            // OTP is correct and within the time limit
            $data = $_SESSION['registration_data'];
            $query = "INSERT INTO students (s_fname, s_lname, s_course, s_section, s_year, s_email, s_username, s_password) 
                      VALUES ('{$data['s_fname']}', '{$data['s_lname']}', '{$data['s_course']}', '{$data['s_section']}', '{$data['s_year']}', '{$data['s_email']}', '{$data['s_username']}', '{$data['s_password']}')";
            $query_run = mysqli_query($conn, $query);

            if ($query_run) {
                unset($_SESSION['registration_data']); // Clear session data
                echo
                "<script>
                        alert('Registration successful. You can now log in.');
                        window.location.href = 'student_login.php';
                      </script>";
                exit();
            } else {
                $error_mssg = "An error occurred during registration.";
            }
        } else {
            $error_mssg = "Invalid OTP. Please try again.";
        }
    } else {
        $error_mssg = "No registration data found. Please register again.";
        header("Location: student_register.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                document.querySelector("#resendForm .resend").style.display = "block";
                document.querySelector("#resendForm .rsndDiv").style.display = "block";
                document.querySelector("#resendForm .space").style.display = "block";
            }, 10000); // 10 seconds = 10000 milliseconds
        });
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url(images/background.jpg);
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }

        .container {
            backdrop-filter: blur(1px);
            background-color: rgba(0, 0, 0, 0.8);
            padding: 35px 50px 35px 50px;
            border: 0.5 solid black;
            border-radius: 10px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #f0f0f0;
            text-align: center;
        }

        p {
            color: #f0f0f0;
            text-align: center;
            font-weight: lighter;
            font-size: small;
            font-style: normal;
        }

        .email {
            font-style: italic;
            font-weight: bold;
        }

        .input-wrapper {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .input-wrapper label {
            font-size: 14px;
            color: #555555;
            padding: 0px 10px 0px 10px;
            flex-shrink: 0;
            width: 100px;
            text-align: left;
        }

        .input-wrapper input[type="text"] {
            flex-grow: 1;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            transition: all 0.3s ease;
        }

        .input-wrapper input[type="text"]:focus {
            border-color: #2d89ef;
            box-shadow: 0 0 5px rgba(45, 137, 239, 0.5);
        }

        .input-wrapper-submit {
            margin-top: 20px;
        }

        .input-wrapper-submit input[type="submit"] {
            width: 100%;
            background-color: #2d89ef;
            color: #ffffff;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .input-wrapper-submit input[type="submit"]:hover {
            background-color: #1c6dce;
        }

        small.error_mssg {
            color: red !important;
            margin-top: 5px;
            font-size: 12px;
        }

        .resend {
            background-color: rgb(1, 50, 32);
            padding: 5px 10px 5px 10px;
            color: #f0f0f0;
            cursor: pointer;
            justify-self: right;
            border: none;
            border-radius: 7px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form class="form" method="POST" action="verify_otp.php">
            <?php $data = $_SESSION['registration_data']; ?>
            <h2>Email Verification</h2>
            <?php if (isset($success_msg)) { ?>
                <p style="color: #7FFF00; font-style: italic;"><?php echo $success_msg; ?><span class="email"><?php echo $data['s_email']; ?></span></p>
            <?php } else { ?>
                <p>A verification code was sent to <span class="email"><?php echo $data['s_email']; ?></span>.</p>
            <?php } ?>
            <div class="input-wrapper">
                <label for="otp">Enter OTP:</label>
                <input type="text" name="otp" required>
            </div>
            <?php if (isset($error_mssg)) { ?>
                <p style="color: red;"><?php echo $error_mssg; ?></p>
            <?php } ?>
            <div class="input-wrapper-submit">
                <input type="submit" name="verify_otp" value="Verify">
            </div>
        </form>
        <br>

        <form class="form" method="POST" action="verify_otp.php" id="resendForm">
            <hr class="rsndDiv" style="display: none;">
            <br class="space" style="display: none;">
            <input class="resend" type="submit" name="resend_otp" value="Resend OTP" style="display: none;">
        </form>
    </div>
</body>

</html>