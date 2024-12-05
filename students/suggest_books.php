<?php
include "header.php";
include "links.php";
require "../dbcon.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['suggest_a_book'])) {

        $stud_id =  $_SESSION['s_ID'];
        $book_title = mysqli_real_escape_string($conn, $_POST['book_title']);
        $book_author = mysqli_real_escape_string($conn, $_POST['book_author']);
        $book_category = mysqli_real_escape_string($conn, $_POST['book_category']);
        $query = "INSERT INTO `book_request`(`br_title`, `br_author`, `br_category`, `stud_id`) 
        VALUES ('$book_title','$book_author','$book_category','$stud_id') ";

        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $_SESSION['message'] = "Book suggested successfully!";
        } else {
            $_SESSION['message'] = "Book not suggested!";
        }
    }

    if (isset($_POST['delete_btn'])) {
        $br_ID = mysqli_real_escape_string($conn, $_POST['delete_btn']);
        $query = "DELETE FROM `book_request` WHERE br_ID = '$br_ID' ";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $_SESSION['message'] = "Book deleted successfully!";
        } else {
            $_SESSION['message'] = "Book not deleted!";
        }
    }
    if (isset($_POST['update_details'])) {
        $stud_id = $_SESSION['s_ID'];
        $br_ID = mysqli_real_escape_string($conn, $_POST['br_ID']);
        $book_title = mysqli_real_escape_string($conn, $_POST['book_title']);
        $book_author = mysqli_real_escape_string($conn, $_POST['book_author']);
        $book_category = mysqli_real_escape_string($conn, $_POST['book_category']);

        $query = "UPDATE `book_request` SET `br_title`='$book_title',`br_author`='$book_author',`br_category`='$book_category' WHERE br_ID='$br_ID' AND `stud_id`='$stud_id' ";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $_SESSION['message'] = "Book updated successfully!";
        } else {
            $_SESSION['message'] = "Book not updated!";
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
    <title>Suggest a Book</title>
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
                                    <a href="suggest_books.php" class="nav-link px-3 active">
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
    <main class="mt-5 pt-4 pl-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h4>Transactions</h4>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Transactions</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Suggest books</li>
                        </ol>
                    </nav>

                    <div class="border border-secondary border-opacity-25 p-3 overflow-auto rounded ">
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary text-nowrap mb-2" data-bs-toggle="modal"
                                    data-bs-target="#request_a_book">Suggest a Book</button>
                            </div>
                        </div>

                        <!-- Modal for book request -->
                        <div class="modal fade" id="request_a_book" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                    class="modal-content" method="POST">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Suggest a book</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <label class="form-label">Book Title</label>
                                            <input type="text" name="book_title" class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Author</label>
                                            <input type="text" name="book_author" class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Category</label>
                                            <input type="text" name="book_category" class="form-control">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="suggest_a_book"
                                            class="btn btn-primary">Suggest</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal for edit book request -->
                        <div class="modal fade" id="editmodal" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                    class="modal-content" method="POST">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Edit</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="br_ID" id="br_ID">
                                        <div class="mb-2">
                                            <label class="form-label">Book Title</label>
                                            <input type="text" name="book_title" id="book_title" class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Author</label>
                                            <input type="text" name="book_author" id="book_author" class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Category</label>
                                            <input type="text" name="book_category" id="book_category" class="form-control">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="update_details"
                                            class="btn btn-primary">Edit</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- =============================================================================== -->
                        <table class="table table-striped table-hover text-nowrap">
                            <thead class="table-dark">
                                <tr>
                                    <td>Book Title</td>
                                    <td>Book Author</td>
                                    <td>Book Category</td>
                                    <td>Date</td>
                                    <td>Action</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php include "message.php"; ?>
                                <?php
                                $student_id = $_SESSION['s_ID'];
                                $query = "SELECT * FROM `book_request` WHERE stud_id = '$student_id' ";
                                $query_run = mysqli_query($conn, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $data) {
                                ?>
                                        <tr>
                                            <td class="d-none"><?= $data['br_ID']; ?></td>
                                            <td><?= $data['br_title']; ?></td>
                                            <td><?= $data['br_author']; ?></td>
                                            <td><?= $data['br_category']; ?></td>
                                            <td><?= $data['br_date']; ?></td>
                                            <td class="p-0 m-0 d-flex align-items-center">
                                                <button type="button" name="edit_btn" class="editbtn btn btn-success py-1">Edit</button>
                                                &nbsp;&nbsp;
                                                <form class="m-0 py-1" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                                    <button type="submit" name="delete_btn" class="btn btn-danger py-1" value="<?= $data['br_ID']; ?>">Delete</button>
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
    <script src="sessionTimer.js"></script>

    <script>
        $(document).ready(function() {
            $('.editbtn').on('click', function() {
                $('#editmodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#br_ID').val(data[0]);
                $('#book_title').val(data[1]);
                $('#book_author').val(data[2]);
                $('#book_category').val(data[3]);
            });
        });
    </script>
</body>

</html>