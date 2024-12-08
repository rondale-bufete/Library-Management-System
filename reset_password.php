<?php
include "dbcon.php";

$error_message = $success_message = "";

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    $stmt = mysqli_prepare($conn, "SELECT user_id, expires FROM password_resets WHERE token = ?");
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $expires = $row['expires'];

        if (time() <= $expires) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $new_password = test_input($_POST['new_password']);
                $confirm_password = test_input($_POST['confirm_password']);

                if ($new_password === $confirm_password) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $user_id = $row['user_id'];

                    mysqli_query($conn, "UPDATE students SET s_password = '$hashed_password' WHERE s_ID = '$user_id'");

                    mysqli_query($conn, "DELETE FROM password_resets WHERE token = '$token'");

                    $success_message = "Your password has been reset successfully. You can now log in.";
                    echo
                        "<script>
                                alert('$success_message');
                                window.location.href = 'student_login.php';
                            </script>";
                        exit();
                } else {
                    $error_message = "Passwords do not match.";
                }
            }
        } else {
            $error_message = "This token has expired. Please request a new password reset.";
        }
    } else {
        $error_message = "Invalid token.";
    }
} else {
    $error_message = "No token provided.";
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
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <?php if ($error_message) echo "<p style='color:red;'>$error_message</p>"; ?>
    <?php if ($success_message) echo "<p style='color:green;'>$success_message</p>"; ?>
    
    <?php if (!$success_message && isset($_GET['token']) && time() <= $expires): ?>
    <form method="POST" action="">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required><br><br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required><br><br>
        <button type="submit">Reset Password</button>
    </form>
    <?php endif; ?>
</body>
</html>
