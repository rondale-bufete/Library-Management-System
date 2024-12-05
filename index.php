<?php
 include "verify_user.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="./css/styles.css">
   <style>
        body {
            overflow: hidden;
        }

        .banner {
            position: relative;
            margin-top: 48px;
            height: 100vh;
            background: url("./images/background.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #fff;
        }

        .content-wrapper {
            position: absolute;
            padding: 40px 30px 25px 30px;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(1px);
            border-radius: 10px;
            transform: translate(-50%, -50%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .form-selection>a {
            background: rgba(0, 21, 101, 1);
            padding: 10px 15px;
            width: 10rem;
            text-align: center;
            border-radius: 20px;
            color: #fff;
            margin: .8rem;
            text-transform: uppercase;
            border: 4px solid rgba(0, 21, 101, 0.8);
            transition: all 0.5s ease;
        }

        .form-selection>a:hover {
            background: rgba(0, 21, 101, 0.2);
        }
    </style>
</head>

<body>
    <nav class="header">
        <div class="navbar-col1">
            <img src="./images/library_icon.png" alt="library-Icon" style="width: 40px; height: 40px">
            <a href="" class="navbar-brand">LIBRARY MANAGEMENT SYSTEM</a>
        </div>
    </nav>
    <div class="banner">
        <div class="content-wrapper">
            <h1>WELCOME TO OUR LIBRARY</h1>
            <span>We stand behind your success</span>
            <div class="form-selection">
                <a href="admin_login.php" id="login-form">Admin</a>
                <a href="student_login.php" id="registration-form">Student</a>
            </div>
        </div>
    </div>
</body>

</html>