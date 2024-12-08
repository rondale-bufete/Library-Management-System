<?php
session_start();
require "../dbcon.php";
include "links.php";

if (!isset($_SESSION['s_ID'])) {
    die("Unauthorized access. Please log in.");
}

$error_message = "";
$student_id = $_SESSION['s_ID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verify_password'])) {
    $password = $_POST['password'];

    if (empty($password)) {
        $error_message = "Please enter your current password.";
    } else {
        $query = "SELECT s_password FROM `students` WHERE s_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['s_password'])) {
            header("Location: reset_password.php");
            exit;
        } else {
            $error_message = "Incorrect password. Please try again.";
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
    <title>Verify Password</title>
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
            margin-bottom: 5px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
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
                <h2>Verify Password</h2>
                <div class="col-md-6"></div>
                <form class="form" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="input-wrapper">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Current Password" required>
                    </div>
                    <small class="error_mssg">
                        <?php echo $error_message; ?>
                    </small>
                    <div class="input-wrapper input-wrapper-submit">
                        <input type="submit" name="verify_password" class="btn btn-primary" value="Verify">
                    </div>
                    
                    
                </form>
            </div>
        </div>
    </div>
</body>

</html>
