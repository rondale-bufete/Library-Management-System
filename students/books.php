<?php
include "header.php";
include "links.php";
require "../dbcon.php";

if (isset($_POST['request_a_book'])) {
    $ISBN = mysqli_real_escape_string($conn, $_POST['request_a_book']);
    $student_id = $_SESSION['s_ID'];
    $book_copies = mysqli_real_escape_string($conn, $_POST['book_copies']);

    $query = "UPDATE `books` SET book_is_request='1' WHERE `ISBN`='$ISBN' ";
    $query_run = mysqli_query($conn, $query);

    $query = "INSERT INTO `book_transactions`(`ISBN`, `s_ID`) VALUES ('$ISBN','$student_id')";
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
    <title>Books</title>
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
                            <li class="breadcrumb-item active" aria-current="page">View Books</li>
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
                                    <th>Book Published</th>
                                    <th>Copies</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include "message.php" ?>
                                <?php
                                $query = "SELECT * FROM books WHERE NOT book_copies='0' AND book_is_request='0'";

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
                                                <?= $book['book_published']; ?>
                                            </td>
                                            <td>
                                                <?= $book['book_copies']; ?>
                                            </td>
                                            <td class="d-flex align-items-start m-0 py-1">
                                                <form class="m-0" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                                    method="POST">
                                                    <button class="btn btn-success py-1" type="submit" name="request_a_book"
                                                        value="<?= $book['ISBN']; ?>">Borrow</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php
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