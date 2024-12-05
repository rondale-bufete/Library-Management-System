<?php
include "header.php";
include "links.php";
require "../dbcon.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['return_book'])) {
        $rl_id = $_POST['return_book'];
        $student_id = $_SESSION['s_ID'];
        $ISBN = mysqli_real_escape_string($conn, $_POST['ISBN']);

        $query = "UPDATE `book_transactions` SET `bt_status`='3' WHERE bt_ID = '$rl_id' AND s_ID = '$student_id' ";
        $query_run = mysqli_query($conn, $query);

        $query = "UPDATE `books` SET `book_is_request`='0' WHERE `ISBN`='$ISBN' ";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $_SESSION['message'] = "Book successfully returned!";
        } else {
            $_SESSION['message'] = "Book not returned!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Borrowod Books</title>
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
                        <a class="nav-link px-3 sidebar-link active" data-bs-toggle="collapse" href="#manage">
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
                                    <a href="borrowBooks.php" class="nav-link px-3 active">
                                        <span class="me-2"><i class="bi bi-book-fill"></i></i></span>
                                        <span>Borrowed Books</span>
                                    </a>
                                <li>
                                    <a href="suggest_books.php" class="nav-link px-3">
                                        <span class="me-2"><i class="bi bi-book-fill"></i></i></span>
                                        <span>Suggest Books</span>
                                    </a>
                                </li>
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
                    <h4>Transactions</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Transactions</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Borrowed Books</li>
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include "message.php"; ?>
                                <?php
                                $stud_ID = $_SESSION['s_ID'];
                                $query = "SELECT book_transactions.bt_ID, books.ISBN, books.book_title, books.book_author, books.book_category 
                                   FROM book_transactions 
                                   INNER JOIN books ON book_transactions.ISBN = books.ISBN WHERE book_transactions.bt_status = '1' AND book_transactions.s_ID = '$stud_ID'; ";
                                $query_run = mysqli_query($conn, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run  as $data) {
                                ?>
                                        <tr>
                                            <td>
                                                <?= $data['ISBN']; ?>
                                            </td>
                                            <td>
                                                <?= $data['book_title']; ?>
                                            </td>
                                            <td>
                                                <?= $data['book_author']; ?>
                                            </td>
                                            <td>
                                                <?= $data['book_category']; ?>
                                            </td>
                                            <td class="m-0 p-0">
                                                <form class="m-0 py-1" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                                    method="POST">
                                                    <input type="hidden" name="ISBN" value="<?= $data['ISBN']; ?>">
                                                    <button
                                                        type="submit"
                                                        name="return_book"
                                                        class="btn btn-danger py-1"
                                                        value="<?= $data['bt_ID']; ?>">Return
                                                    </button>
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
    </main>
    <script src="sessionTimer.js"></script>
</body>

</html>