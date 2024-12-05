<?php
  include "header.php";
  include "link.php";
  include "verify_user.php";
  require "dbcon.php";
  
  $admin = $password = "";
  $admin_error = $password_error = "";
  $error_mssg = "";
  $values = true;

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["login_admin"])) {
      if (empty($_POST["admin_username"])) {
        $values = false;
        $admin_error = "Admin ID is required!";
      } 
  
      if (empty($_POST["admin_password"])) {
        $values = false;
        $password_error = "Admin password is required";
      } 
  
      if ($values == true) {
        $username_inputted = test_input($_POST['admin_username']);
        $password_inputted = test_input($_POST['admin_password']);

        $query = "SELECT * FROM `admin` WHERE admin_username='$username_inputted' AND admin_password='$password_inputted' ";
        $query_run = mysqli_query($conn, $query);

        if (mysqli_num_rows($query_run) === 1) {
          $row = mysqli_fetch_assoc($query_run);
          if ($row['admin_username'] === $username_inputted && $row['admin_password'] === $password_inputted) {
            $_SESSION['admin_ID'] = $row['admin_ID'];
            $_SESSION['type_of_user'] = "admin";
            
            header("Location: admin/dashboard.php");
          } 
        } else {
          //IF THE PASSWORD/USERNAME IS INCORRECT OR THE INPUT IS NOT EXISTING IN THE TABLE
          if (!empty($_POST["admin_username"]) && !empty($_POST["admin_password"])) {
            $error_mssg = "login info incorrect";
        }
        mysqli_close($conn);
      }
      } 
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
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
      background-color: rgba(0, 0, 0, 0.5);
      padding-left: 25px;
      padding-right: 25px;
      border: 0.5 solid black;
    }
  </style>

</head>

<body>

    <div class="container">
        <div class="container-row">
            <div class="container-col">
                <h2>Admin<span class="divider"></span>Log In</h2>

                <form class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                    <div class="input-wrapper">
                        <input type="text" name="admin_username" placeholder="Admin ID">
                        <span class="material-symbols-rounded">person</span>
                    </div>
                    <small class="error_mssg">
                        <?php echo $admin_error;?>
                    </small>
                    <div class="input-wrapper">
                        <input type="password" name="admin_password" placeholder="Password">
                        <span class="material-symbols-rounded">lock</span>
                    </div>
                    <small class="error_mssg">
                        <?php echo $password_error; ?>
                        <?php echo $error_mssg; ?>
                    </small>
                    <div class="input-wrapper input-wrapper-submit">
                        <input type="submit" id="submitForm" value="Login" name="login_admin">
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