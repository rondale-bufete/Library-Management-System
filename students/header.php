<?php
include "user_type_not_set.php";
require "../dbcon.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_profile'])) {
        $student_id = $_SESSION['s_ID'];
        $fname = test_input($_POST['fname']);
        $lname = test_input($_POST['lname']);
        $course = test_input($_POST['course']);
        $section = test_input($_POST['section']);
        $year = test_input($_POST['year']);
        $username = test_input($_POST['username']);
        $password = test_input($_POST['password']);

        $query = "UPDATE `students` SET`s_fname`='$fname',`s_lname`= '$lname',`s_course`='$course',`s_section`='$section',`s_year`='$year',`s_username`='$username',`s_password`='$password' WHERE s_ID = '$student_id' ";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            echo "<script>alert('Details updated successfully!');</script>";
        } else {
            echo "<script>alert('Details not updated!');</script>";
        }
    }
}

?>

<!-- top navigation bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <?php
    $student_id = $_SESSION['s_ID'];
    $query = "SELECT * FROM `students` WHERE s_ID = '$student_id' ";
    $query_run = mysqli_query($conn, $query);
    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $data) {
    ?>
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
                    aria-controls="offcanvasExample">
                    <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
                </button>
                <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold" href="#">
                    <img src="./images/library_icon.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    LIBRARY MANAGEMENT SYSTEM</a>
                <!-- dropdown -->
                <div class="dropdown">
                    <button class="btn text-light fs-5 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i style="font-style: normal; font-size: 16px;"><?= $data['s_fname']; ?></i>
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="profile.php">Edit Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../logout.php">Log out</a></li>
                    </ul>
                </div>
            </div>
    <?php
        }
    }
    ?>
</nav>
<!-- top navigation bar -->