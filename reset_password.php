<?php
include "dbcon.php";
include "./students/links.php";

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
                <h2>Reset Password</h2>
                <?php if ($error_message) echo "<p style='color:red;'>$error_message</p>"; ?>
                <?php if ($success_message) echo "<p style='color:green;'>$success_message</p>"; ?>
                
                <?php if (!$success_message && isset($_GET['token']) && time() <= $expires): ?>
                <form class="form" method="POST" action="">
                    <div class="input-wrapper">
                        <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter new password" required>
                    </div>
                    <div class="input-wrapper">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm new password" required>
                    </div>
                    <div class="input-wrapper input-wrapper-submit">
                        <input type="submit" name="reset_password" class="btn btn-primary" value="Reset Password">
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>    
</body>
</html>
