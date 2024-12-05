<?php
include "header.php";
include "links.php";
require "../dbcon.php";

if (isset($_POST['delete_student'])) {
    $s_ID = mysqli_real_escape_string($conn, $_POST['delete_student']);

    $query = "DELETE FROM students WHERE s_ID='$s_ID' ";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['message'] = "Student Deleted Successfully";
    } else {
        $_SESSION['message'] = "Student Not Deleted";
    }
} else if (isset($_POST['add_a_student'])) {
    $s_fname = mysqli_real_escape_string($conn, $_POST['s_fname']);
    $s_lname = mysqli_real_escape_string($conn, $_POST['s_lname']);
    $s_course = mysqli_real_escape_string($conn, $_POST['s_course']);
    $s_section = mysqli_real_escape_string($conn, $_POST['s_section']);
    $s_year = mysqli_real_escape_string($conn, $_POST['s_year']);
    $s_username = mysqli_real_escape_string($conn, $_POST['s_username']);
    $admin_ID = $_SESSION['admin_ID'];

    $query = "INSERT INTO students (s_fname, s_lname, s_course, s_section, s_year, s_username, admin_ID) VALUES ('$s_fname', '$s_lname', '$s_course', '$s_section', '$s_year', '$s_username', '$admin_ID');";

    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
        $_SESSION['message'] = "Student Created Successfully";
    } else {
        $_SESSION['message'] = "Student Not Created";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student List</title>
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
                        <a href="dashboard.php" class="nav-link px-3">
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
                                    <a href="borrowedBooks.php" class="nav-link px-3">
                                        <span class="me-2"><i class="bi bi-book-fill"></i></i></span>
                                        <span>Borrowed Books</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="returnedBooks.php" class="nav-link px-3">
                                        <span class="me-2"><i class="bi bi-book-fill"></i></i></span>
                                        <span>Returned Books</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#books">
                            <span class="me-2"><i class="bi bi-layout-split"></i></span>
                            <span>Books</span>
                            <span class="ms-auto">
                                <span class="right-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </span>
                        </a>
                        <div class="collapse" id="books">
                            <ul class="navbar-nav ps-3">
                                <li>
                                    <a href="categories.php" class="nav-link px-3">
                                        <span class="me-2"><i class="bi bi-book-fill"></i></i></span>
                                        <span>Categories</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="bookList.php" class="nav-link px-3">
                                        <span class="me-2"><i class="bi bi-book-fill"></i></i></span>
                                        <span>Book list</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="bookRequest.php" class="nav-link px-3">
                                        <span class="me-2"><i class="bi bi-book-fill"></i></i></span>
                                        <span>Book Request</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="pending_books.php" class="nav-link px-3">
                                        <span class="me-2"><i class="bi bi-book-fill"></i></i></span>
                                        <span>Pending Books</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="requestLogs.php" class="nav-link px-3">
                                        <span class="me-2"><i class="bi bi-book-fill"></i></i></span>
                                        <span>Request Logs</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link px-3 sidebar-link active" data-bs-toggle="collapse" href="#students">
                            <span class="me-2"><i class="bi bi-people-fill"></i></span>
                            <span>Students</span>
                            <span class="ms-auto">
                                <span class="right-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </span>
                        </a>
                        <div class="collapse show" id="students">
                            <ul class="navbar-nav ps-3">
                                <li>
                                    <a href="studentList.php" class="nav-link px-3 active">
                                        <span class="me-2"><i class="bi bi-people-fill"></i></span>
                                        <span>Student List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="course.php" class="nav-link px-3">
                                        <span class="me-2"><i class="bi bi-book-fill"></i></i></span>
                                        <span>Courses</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <main class="mt-5 pt-4 pl-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h4>Students</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Student</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Student List</li>
                        </ol>
                    </nav>
                    <div class="border border-secondary border-opacity-25 p-3 overflow-auto rounded">
                        <div class="row">
                            <div class="col-sm-6">

                                <button type="button" class="btn btn-primary mb-2 text-nowrap" data-bs-toggle="modal"
                                    data-bs-target="#add_a_student">Add Student</button>
                            </div>
                            <div class="col-sm-6">

                                <input class="form-control mb-3" id="search" type="search" placeholder="Search">

                            </div>
                        </div>


                        <div class="modal fade" id="add_a_student" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                    class="modal-content" method="POST">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Add a Student</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <label class="form-label">First Name</label>
                                            <input type="text" name="s_fname" class="form-control">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" name="s_lname" class="form-control">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Course</label>
                                            <input type="text" name="s_course" class="form-control">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Section</label>
                                            <input type="text" name="s_section" class="form-control">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Year level</label>
                                            <input type="number" name="s_year" class="form-control">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Username</label>
                                            <input type="text" name="s_username" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="add_a_student" class="btn btn-primary">Save
                                            changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal for update student data -->
                        <div class="modal fade" id="editmodal" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="updatecode.php" class="modal-content" method="POST">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Update Student Data</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <input type="hidden" name="update_id" id="update_id">
                                        <div class="mb-2">
                                            <label class="form-label">First Name</label>
                                            <input type="text" name="s_fname" id="fname" class="form-control">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" name="s_lname" id="lname" class="form-control">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Course</label>
                                            <input type="text" name="s_course" id="course" class="form-control">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Section</label>
                                            <input type="text" name="s_section" id="section" class="form-control">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Year level</label>
                                            <input type="number" name="s_year" id="year" class="form-control">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Username</label>
                                            <input type="text" name="s_username" id="username" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="edit_a_student"
                                            class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- =========================================================================== -->
                        <table class="table table-striped table-hover text-nowrap">
                            <thead class="table-dark">
                                <tr>
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Email</th>
                                    <th>Course</th>
                                    <th>Section</th>
                                    <th>Year Level</th>
                                    <th>Username</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                <?php include "message.php"; ?>
                                <?php
                                $query = "SELECT * FROM students";
                                $query_run = mysqli_query($conn, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $student) {
                                ?>
                                        <tr>
                                            <td>
                                                <?= $student['s_fname']; ?>
                                            </td>
                                            <td>
                                                <?= $student['s_lname']; ?>
                                            </td>
                                            <td>
                                                <?= $student['s_email']; ?>
                                            </td>
                                            <td>
                                                <?= $student['s_course']; ?>
                                            </td>
                                            <td>
                                                <?= $student['s_section']; ?>
                                            </td>
                                            <td>
                                                <?= $student['s_year']; ?>
                                            </td>
                                            <td>
                                                <?= $student['s_username']; ?>
                                            </td>
                                            <td class="d-flex align-items-start m-0 py-1">
                                                <button class="editbtn btn btn-success py-1">Edit</button>&nbsp;&nbsp;
                                                <form class="m-0" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                                    method="POST">
                                                    <button class="btn btn-danger py-1" type="submit" name="delete_student"
                                                        value="<?= $student['s_ID']; ?>">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="9" class="h5 text-center">No Record Found!</td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.editbtn').on('click', function() {
                $('#editmodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#update_id').val(data[0]);
                $('#fname').val(data[1]);
                $('#lname').val(data[2]);
                $('#course').val(data[3]);
                $('#section').val(data[4]);
                $('#year').val(data[5]);
                $('#username').val(data[6]);
            });


            // search for table row
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>

</html>