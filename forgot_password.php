<?php
include "dbcon.php";
include "./students/links.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

$error_message = $success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST['email']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = mysqli_prepare($conn, "SELECT * FROM students WHERE s_email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {
            $token = bin2hex(random_bytes(32));
            $expires = time() + 600; // Token valid 10 mins

            $row = mysqli_fetch_assoc($result);
            $user_id = $row['s_ID'];
            mysqli_query($conn, "INSERT INTO password_resets (user_id, token, expires) VALUES ('$user_id', '$token', '$expires')");

            $reset_link = "http://localhost/GitHub/Library-Management-System/reset_password.php?token=$token";

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'rondale.bufete7@gmail.com'; 
                $mail->Password = 'wppmgxruzoeclqal'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('rondale.bufete7@gmail.com', 'Library Management System');
                $mail->addAddress($email); 
                $mail->Subject = 'Password Reset Request';
                $mail->isHTML(true);
                $mail->Body = "
                    <html>
                    <body>
                        <p>Hello,</p>
                        <p>You requested to reset your password. Please click the button below to proceed:</p>
                        <a href='$reset_link' style='display: inline-block; padding: 10px 15px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>Reset Password</a>
                        <p>If you did not request this, you can safely ignore this email.</p>
                        <p>Thank you, <br> Library Management System Team</p>
                    </body>
                    </html>
                ";
                $mail->send();
                $success_message = "A password reset link has been sent to your email.";
            } catch (Exception $e) {
                $error_message = "Mailer Error: " . $mail->ErrorInfo;
            }
        } else {
            $error_message = "This email is not registered.";
        }
    } else {
        $error_message = "Invalid email format.";
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
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
            max-width: 525px;
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
            margin-bottom: 5px;
            margin-top: 5px;
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
            margin: 0;
        }
        .input-wrapper input[type="email"] {
            flex-grow: 1;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            transition: all 0.3s ease;
            margin: 0;
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
            margin-bottom: 25px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="container-row">
            <div class="container-col">
                <h2>Forgot Password</h2>
                <?php if ($error_message) echo "<p style='color:red;'>$error_message</p>"; ?>
                <?php if ($success_message) echo "<p style='color:green;'>$success_message</p>"; ?>
                
                <form class="form" method="POST" action="">
                    <div class="input-wrapper">
                        <input type="email" name="email" id="email" placeholder="Enter your registered email." required>
                    </div>
                    <div class="input-wrapper input-wrapper-submit">
                        <input type="submit" value="Send Reset Link">  
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
