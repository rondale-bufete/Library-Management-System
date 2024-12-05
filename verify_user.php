<?php
session_start();

if (isset($_SESSION['type_of_user'])) {
    if ($_SESSION['type_of_user'] == "admin") {
        header("Location: ./admin/dashboard.php");
    } 
    if ($_SESSION['type_of_user'] == "student") {
        header("Location: ./students/student_dashboard.php");
    }
}

?>