<?php
  include "header.php";
  include "links.php";
  require "../dbcon.php";

  session_start();

 if (isset($_POST['edit_course'])) {
        $update_course = mysqli_real_escape_string($conn, $_POST['update_course']);
        $prev_course = mysqli_real_escape_string($conn, $_POST['s_course']);
        
        $query = "UPDATE students SET s_course='$update_course' WHERE s_course='$prev_course' ";
        $query_run = mysqli_query($conn, $query);
    
        if($query_run) {
          $_SESSION['message'] = "Data Updated Successfully!";
        } else {
          $_SESSION['message'] = "Data not Updated";
        }
  } 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="css/">
    <title>Course</title>
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
                                    <a href="studentList.php" class="nav-link px-3">
                                        <span class="me-2"><i class="bi bi-people-fill"></i></span>
                                        <span>Student List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="course.php" class="nav-link px-3 active">
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
    <!-- offcanvas -->
    <main class="mt-5 pt-4 pl-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h4>Students</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Students</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Course</li>
                        </ol>
                    </nav>
                    <div class="border border-secondary border-opacity-25 p-3 overflow-auto rounded">
                        <div class="row d-flex">
                            <div class="col-sm-6">
                                <!-- search form -->
                                <form>
                                    <input class="form-control" type="search" placeholder="Search">
                                </form>
                                <!-- search form -->
                            </div>
                        </div>

                        <!-- ============================================================================================= -->
                        <!-- Modal for edit course -->
                        <div class="modal fade" id="editmodal" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                    class="modal-content" method="POST">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Update Course Title</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="s_course" id="s_course">
                                        <div class="mb-2">
                                            <label class="form-label">Course title</label>
                                            <input type="text" name="update_course" id="update_course"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="edit_course" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- ============================================================================================= -->
                        <table class="table table-striped table-hover text-nowrap">
                            <thead class="table-dark">
                                <tr>
                                    <th>No. of students</th>
                                    <th>Course title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include "message.php";?>
                                <?php
                                  $query = "SELECT COUNT(s_ID) as no_students, s_course FROM students GROUP BY s_course ASC";

                                  $query_run = mysqli_query($conn, $query);

                                  if (mysqli_num_rows($query_run) >= 1) {
                                    foreach($query_run as $course) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?=$course['no_students']; ?>
                                            </td>
                                            <td>
                                                <?=$course['s_course']; ?>
                                            </td>
                                            <td class="d-flex  align-items-start m-0 py-1">
                                                <button class="editbtn btn btn-success py-1">Edit</button>&nbsp;&nbsp;
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                  } else {
                                    ?>
                                    <tr>
                                        <td colspan="3" class="h5 text-center">No Record Found!</td>
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
</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script>
    $(document).ready(function () {

        $('.editbtn').on('click', function () {

            $('#editmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            $('#s_course').val(data[1]);

            $('#update_course').val(data[1]);
        });
    });
</script>

</html>