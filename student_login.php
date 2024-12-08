<?php
include "header.php";
include "link.php";
include "verify_user.php";
require "dbcon.php";

// Initialize variables
$usename = $studPass = "";
$error_mssg = $username_err = $studPass_err = "";
$values = true;

$ip = $_SERVER['REMOTE_ADDR'];
$login_time = time() - 40; // Adjust this based on your logic
$login_attempts = mysqli_query($conn, "SELECT COUNT(*) AS total_count, MAX(login_time) AS last_attempt FROM ip_details WHERE ip = '$ip' AND login_time > '$login_time'");
$res = mysqli_fetch_assoc($login_attempts);
$count = $res['total_count'];
$last_attempt = $res['last_attempt'];

$remaining_time = 0;
if ($count >= 3) {
    $remaining_time = 15 - (time() - $last_attempt);
    if ($remaining_time >= 0) {
        $error_mssg = "Your account has been blocked.
         Try again after <span id='countdown'>$remaining_time</span> seconds.";
    } else {
        // Reset the attempt count if 15 seconds have passed
        $delete_query = mysqli_query($conn, "DELETE FROM ip_details WHERE ip = '$ip'");
        $remaining_time = 0; // Reset remaining time
    }
} else {
    if (isset($_POST["login_student"])) {

        // Validate username input
        if (empty($_POST["login_identifier"])) {
            $values = false;
            $username_err = "Username or Email is required";
        }
        if (empty($_POST["studentPassword"])) {
            $values = false;
            $studPass_err = "Student password is required";
        }
        if ($values == true) {
            $login_identifier = test_input($_POST['login_identifier']);
            $password_inputted = test_input($_POST['studentPassword']);

            // Determine if the login input is an email or username
            if (filter_var($login_identifier, FILTER_VALIDATE_EMAIL)) {
                $sql = "SELECT * FROM students WHERE s_email=?";
            } else {
                $sql = "SELECT * FROM students WHERE s_username=?";
            }

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $login_identifier);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // Check if the user exists
            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);

                // Use password_verify to check the password
                if (password_verify($password_inputted, $row['s_password'])) {
                    $delete_query = mysqli_query($conn, "DELETE FROM ip_details WHERE ip = '$ip'");
                    // Correct username and password - set session and redirect
                    $_SESSION['s_ID'] = $row['s_ID'];
                    $_SESSION['type_of_user'] = "student";
                    header("Location: students/student_dashboard.php");
                    exit();
                } else {
                    $count++;
                    $remaining_attempts = 3 - $count;
                    if ($remaining_attempts == 0) {
                        $error_mssg = "Your account has been blocked. Try again after 15 seconds.";
                    } else {
                        $error_mssg = "Please enter valid details. $remaining_attempts attempts remaining.";
                    }
                    $login_time = time();
                    $insert_query = mysqli_query($conn, "INSERT INTO ip_details SET ip = '$ip', login_time = '$login_time'");
                }
            } else {
                $error_mssg = "Incorrect login information.";
            }

            mysqli_close($conn);
        }
    }
    // }
}

// Function to sanitize user input
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Student Log In</title>
    <style>
        body {
            overflow: hidden;
        }

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
        .forgotPassword {
            color: lightblue;
        }
        .forgotPassword:hover {
            color: #fff;
            cursor: pointer;
            text-decoration: underline;
        }
    </style>
    <script>
        // function enableSubmitButton() {
        //     document.getElementById("submitForm").disabled = false;
        // }

        function startCountdown() {
            const countdownElement = document.getElementById('countdown');
            if (countdownElement) {
                let remainingTime = parseInt(countdownElement.textContent, 10);

                const interval = setInterval(() => {

                    if (remainingTime > 0) {
                        remainingTime--;
                        countdownElement.textContent = remainingTime;
                    } else {
                        clearInterval(interval);
                        countdownElement.parentElement.textContent = "";

                    }
                }, 1000);
            }
        }

        window.onload = startCountdown;
    </script>
</head>

<body>
    <div class="container">
        <div class="container-row">
            <div class="container-col">
                <h2>Student<span class="divider"></span>Log In</h2>

                <form class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="input-wrapper">
                        <input type="text" name="login_identifier" placeholder="Username or Email" required>
                        <span class="material-symbols-rounded">person</span>
                    </div>
                    <small class="error_mssg"><?php echo $username_err; ?></small>

                    <div class="input-wrapper">
                        <input type="password" name="studentPassword" placeholder="Password" required>
                        <span class="material-symbols-rounded">lock</span>
                    </div>
                    <small class="error_mssg"><?php echo $studPass_err; ?></small>
                    <small class="error_mssg">
                        <?php echo $error_mssg; ?>
                    </small>

                    <div class="input-wrapper input-wrapper-submit">
                        <input type="submit" id="submitForm" value="Login" name="login_student" data-sitekey="6LcHn1MqAAAAAEHIjMkq5jj1L_DO8KDx1bW2Nk3v">
                    </div>

                    <div>
                        <small><a href="forgot_password.php" class="forgotPassword">Forgot your password?</a></small>
                        
                    </div>

                    <br>
                    <div>
                        <small>Don't have an Account?</small><a href="student_register.php" class="registerNow">Register Now!</a>
                    </div>

                    <div class="goBack">
                        <a href="index.php">Go Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>