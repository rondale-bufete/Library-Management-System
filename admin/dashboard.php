<?php
  include "header.php";
  include "links.php";
  require "../dbcon.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>

    <style>
        a {
            text-decoration: none;
            color: #FCFCFC;
        }
        a:hover{
            color: #E8E2E2;
        }
    </style>
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
                        <a href="dashboard.php" class="nav-link px-3 active">
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
                        <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#students">
                            <span class="me-2"><i class="bi bi-people-fill"></i></span>
                            <span>Students</span>
                            <span class="ms-auto">
                                <span class="right-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </span>
                        </a>
                        <div class="collapse" id="students">
                            <ul class="navbar-nav ps-3">
                                <li>
                                    <a href="studentList.php" class="nav-link px-3">
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
    <!-- offcanvas -->
    <main class="mt-5 pt-4 pl-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h4>Dashboard</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card bg-primary text-white h-100">
                            <div class="card-body p-3">Total Books
                                <h1 class="h1 text-center mb-2 ">
                                    <?php
                                        $query = "SELECT COUNT(*) AS all_books FROM books ";
                                        $query_run = mysqli_query($conn, $query);

                                        if (mysqli_num_rows($query_run) > 0) {
                                            foreach($query_run as $data) {
                                                echo $data['all_books'];
                                            }
                                        } else {
                                            echo "0";
                                        }
                                    ?>
                                </h1>
                        </div>
                        <a href="bookList.php">
                        <div class="card-footer d-flex">
                            View Details
                            <span class="ms-auto">
                                <i class="bi bi-chevron-right"></i>
                            </span>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card bg-warning text-dark h-100">
                        <div class="card-body p-3">Total Students
                            <h1 class="h1 text-center mb-2">
                                <?php
                                    $query = "SELECT COUNT(*) AS all_students FROM students ";
                                    $query_run = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach($query_run as $data) {
                                            echo $data['all_students'];
                                        }
                                    } else {
                                        echo "0";
                                    }
                                ?>
                            </h1>
                        </div>
                        <a href="studentList.php">
                        <div class="card-footer d-flex">
                            View Details
                            <span class="ms-auto">
                                <i class="bi bi-chevron-right"></i>
                            </span>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body p-3">Returned Books
                            <h1 class="h1 text-center mb-2">
                                <?php
                                    $query = "SELECT COUNT(*) AS all_returned_books FROM `book_transactions` WHERE bt_status = '3' ";
                                    $query_run = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach($query_run as $data) {
                                            echo $data['all_returned_books'];
                                        }
                                    } else {
                                        echo "0";
                                    }
                                ?>
                            </h1>
                        </div>
                        <a href="returnedBooks.php">
                        <div class="card-footer d-flex">
                            View Details
                            <span class="ms-auto">
                                <i class="bi bi-chevron-right"></i>
                            </span>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card bg-danger text-white h-100">
                        <div class="card-body p-3">Borrowed Books
                            <h1 class="h1 text-center mb-2">
                                <?php
                                    $query = "SELECT COUNT(*) AS all_borrowed_books FROM `book_transactions` WHERE bt_status = '1' ";
                                    $query_run = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach($query_run as $data) {
                                            echo $data['all_borrowed_books'];
                                        }
                                    } else {
                                        echo "0";
                                    }
                                ?>
                            </h1>
                        </div>
                        <a href="borrowedBooks.php">
                        <div class="card-footer d-flex">
                            View Details
                            <span class="ms-auto">
                                <i class="bi bi-chevron-right"></i>
                            </span>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>