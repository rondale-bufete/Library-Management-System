<?php
include "header.php";
include "links.php";
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
    <title>Student Profile</title>
</head>

<body>
    <!-- offcanvas -->
    <div class="offcanvas sidebar-nav bg-dark show" tabindex="-1" id="sidebar" data-bs-scroll="true"
        data-bs-backdrop="false" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">
                    <li>
                        <div class="text-muted small fw-bold text-uppercase pt-3 px-3">Reports</div>
                    </li>
                    <li>
                        <a href="student_dashboard.php" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3 mb-1">Manages</div>
                    </li>
                    <li>
                        <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#manage">
                            <span class="me-2"><i class="bi bi-journal-code"></i></span>
                            <span>Transactions</span>
                            <span class="ms-auto">
                                <span class="right-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </span>
                        </a>
                        <div class="collapse" id="manage">
                            <ul class="navbar-nav ps-3">
                                <li>
                                    <a href="borrowBooks.php" class="nav-link px-3">
                                        <span class="me-2"><i class="bi bi-book-fill"></i></i></span>
                                        <span>Borrowed Books</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="suggest_books.php" class="nav-link px-3">
                                        <span class="me-2"><i class="bi bi-book-fill"></i></i></span>
                                        <span>Suggest Books</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="books.php" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-book-fill"></i></span>
                            <span>View Books</span>
                        </a>
                        <a href="dashboard.php" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-clock-history"></i></span>
                            <span>History</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <main class="mt-5 pt-4">
        <div class="container">
            <h1 class="h2 mb-2">Student Details</h1>
            <?php
            $student_id = $_SESSION['s_ID'];
            $query = "SELECT * FROM `students` WHERE s_ID = '$student_id' ";
            $query_run = mysqli_query($conn, $query);
            if (mysqli_num_rows($query_run) > 0) {
                foreach ($query_run as $data) {
            ?>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" name="fname" value="<?= $data['s_fname']; ?>" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="lname" value="<?= $data['s_lname']; ?>" class="form-control">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Course</label>
                            <input type="text" name="course" value="<?= $data['s_course']; ?>" class="form-control">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Section</label>
                            <input type="text" name="section" value="<?= $data['s_section']; ?>" class="form-control">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Year</label>
                            <input type="number" name="year" value="<?= $data['s_year']; ?>" class="form-control">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" value="<?= $data['s_username']; ?>" class="form-control">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Password</label>
                            <input type="Password" name="password" value="<?= $data['s_password']; ?>" class="form-control">
                        </div>

                        <div class="col-12">
                            <button type="submit" name="update_profile" class="btn btn-primary">Update Details</button>
                        </div>
                    </form>
            <?php
                }
            }
            ?>

        </div>
    </main>
    <script src="sessionTimer.js"></script>
</body>

</html>