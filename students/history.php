<?php
include "header.php";
include "links.php";
require "../dbcon.php";

if (isset($_POST['request_a_book'])) {
    $ISBN = mysqli_real_escape_string($conn, $_POST['request_a_book']);
    $student_id = $_SESSION['s_ID'];

    $query = "UPDATE `books` SET`book_is_request`= '1' WHERE `ISBN`='$ISBN' ";
    $query_run = mysqli_query($conn, $query);

    $query = "INSERT INTO `request_logs`(`ISBN`, `s_ID`) VALUES ('$ISBN','$student_id')";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['message'] = "Book requested Successfully";
    } else {
        $_SESSION['message'] = "Book Not requested";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>History</title>
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
                        <div class="collapse show" id="manage">
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
                        <a href="history.php" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-clock-history"></i></span>
                            <span>History</span>
                        </a>
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
                    <h4>Manages</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Manages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">History</li>
                        </ol>
                    </nav>
                    <div class="border border-secondary border-opacity-25 p-3 overflow-auto rounded">
                        <table class="table table-striped table-hover text-nowrap">
                            <thead class="table-dark">
                                <tr>
                                    <th>ISBN</th>
                                    <th>Book Title</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>Date Requested</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include "message.php" ?>
                                <?php
                                $student_id = $_SESSION['s_ID'];
                                $query = "SELECT books.ISBN, books.book_title, books.book_author, books.book_category, book_transactions.bt_date, book_transactions.bt_status
                                   FROM ((book_transactions 
                                   INNER JOIN books ON book_transactions.ISBN = books.ISBN)
                                   INNER JOIN students ON book_transactions.s_ID = students.s_ID) WHERE book_transactions.s_ID = '$student_id' ";

                                $query_run = mysqli_query($conn, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $book) {
                                ?>
                                        <tr>
                                            <td>
                                                <?= $book['ISBN']; ?>
                                            </td>
                                            <td>
                                                <?= $book['book_title']; ?>
                                            </td>
                                            <td>
                                                <?= $book['book_author']; ?>
                                            </td>
                                            <td>
                                                <?= $book['book_category']; ?>
                                            </td>
                                            <td>
                                                <?= $book['bt_date']; ?>
                                            </td>
                                            <?php
                                            if ($book['bt_status'] == 0) {
                                            ?>
                                                <td class="d-flex align-items-start m-0 py-1">
                                                    <div class="btn btn-info py-1">Pending</div>
                                                </td>
                                        </tr>
                                    <?php
                                            } elseif ($book['bt_status'] == 1) {
                                    ?>
                                        <td class="d-flex align-items-start m-0 py-1">
                                            <div class="btn btn-success py-1">Approved</div>
                                        </td>
                                        </tr>
                                    <?php
                                            } else if ($book['bt_status'] == 2) {
                                    ?>
                                        <td class="d-flex align-items-start m-0 py-1">
                                            <div class="btn btn-danger py-1">Declined</div>
                                        </td>
                                        </tr>
                                    <?php
                                            } else if ($book['bt_status'] == 3) {
                                    ?>
                                        <td class="d-flex align-items-start m-0 py-1">
                                            <div class="btn btn-secondary py-1">Returned</div>
                                        </td>
                                        </tr>
                                <?php
                                            }
                                        }
                                    } else {
                                ?>
                                <tr>
                                    <td colspan="7" class="h5 text-center">No Record Found!</td>
                                </tr>
                            <?php
                                    }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </main>
    <script src="sessionTimer.js"></script>
</body>

</html>