<?php
  session_start();
  if (!isset($_SESSION['type_of_user'])) {
     header("Location: ../index.php");
  } 

  if (isset($_SESSION['type_of_user'])) {
    if ($_SESSION['type_of_user'] != "student") {
        header("Location: ../admin/dashboard.php");
    }
  }
?>