<?php
session_start();
require "../dbcon.php";
include "links.php";

if (!isset($_SESSION['s_ID'])) {
    die("Unauthorized access. Please log in.");
}

$error_message = "";
$confirmPass_err="";
$success_message = "";
$student_id = $_SESSION['s_ID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];


    if (empty($new_password) || empty($confirm_password)) {
        $error_message = "All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $new_password)) {
        $confirmPass_err = "Password must be at least 8 characters long, including at least 1 uppercase letter, 1 number, and 1 special character.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $query = "UPDATE `students` SET `s_password` = ? WHERE `s_ID` = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $hashed_password, $student_id);

        if ($stmt->execute()) {
            $_SESSION = array();
            session_destroy(); 
            $success_message = "Password successfully updated! You will be redirected to the login page.";
            
            echo "<script>
                    alert('$success_message');
                    window.location.href = '../student_login.php';
                  </script>";
            exit();
        } else {
            $error_message = "Failed to update password. Please try again later.";
            error_log("Error updating password: " . $stmt->error);
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <div class="container-row">
            <div class="container-col">
                <h2>Reset Password</h2>

                <form class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="input-wrapper">
                        <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter new password" required>
                    </div>

                    <small class="error_mssg">
                        <?php echo $error_message; ?>
                    </small>

                    <div class="input-wrapper">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm new password" required>
                    </div>

                    <small class="error_mssg">
                        <?php echo $confirmPass_err; ?>
                    </small>

                    <div class="input-wrapper input-wrapper-submit">
                        <input type="submit" name="reset_password" class="btn btn-primary" value="Reset Password">
                    </div>
                    
                </form>

            </div>
        </div>
    </div>
</body>

</html>
