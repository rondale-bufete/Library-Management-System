<?php
// Include database connection
include "dbcon.php";

// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer Autoloader
require 'vendor/autoload.php';

$error_message = $success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize email input
    $email = test_input($_POST['email']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if email exists in the database
        $stmt = mysqli_prepare($conn, "SELECT * FROM students WHERE s_email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {
            // Generate a secure token
            $token = bin2hex(random_bytes(32));
            $expires = time() + 3600; // Token valid for 1 hour

            // Save token to the database
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['s_ID'];
            mysqli_query($conn, "INSERT INTO password_resets (user_id, token, expires) VALUES ('$user_id', '$token', '$expires')");

            // Send reset link via email using PHPMailer
            $reset_link = "http://localhost/GitHub/Library-Management-System/reset_password.php?token=$token"; // Replace with actual domain

            $mail = new PHPMailer(true);

            try {
                // SMTP server configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Use your SMTP host
                $mail->SMTPAuth = true;
                $mail->Username = 'rondale.bufete7@gmail.com'; // Your email address
                $mail->Password = 'wppmgxruzoeclqal'; // Your email password or app-specific password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Email settings
                $mail->setFrom('rondale.bufete7@gmail.com', 'Library Management System');
                $mail->addAddress($email); // Recipient's email
                $mail->Subject = 'Password Reset Request';
                $mail->isHTML(true); // Ensure the email is sent as HTML
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

                // Send email
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

// Function to sanitize user input
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
</head>
<body>
    <h2>Forgot Password</h2>
    <?php if ($error_message) echo "<p style='color:red;'>$error_message</p>"; ?>
    <?php if ($success_message) echo "<p style='color:green;'>$success_message</p>"; ?>
    
    <form method="POST" action="">
        <label for="email">Enter your registered email:</label>
        <input type="email" name="email" id="email" required>
        <button type="submit">Send Reset Link</button>
    </form>
</body>
</html>
