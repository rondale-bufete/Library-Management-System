<?php
  include "header.php";
  include "links.php";
  require "../dbcon.php";

  if(isset($_POST['add_a_book'])) {
    $book_title = mysqli_real_escape_string($conn, $_POST['book_title']);
    $book_author = mysqli_real_escape_string($conn, $_POST['book_author']);
    $book_category = mysqli_real_escape_string($conn, $_POST['book_category']);
    $book_published = mysqli_real_escape_string($conn, date('Y-m-d', strtotime($_POST['book_published'])));
    $book_copies = mysqli_real_escape_string($conn, $_POST['book_copies']);
    $admin_ID = $_SESSION['admin_ID'];

    $query = "INSERT INTO books (book_title, book_author, book_category, book_published, book_copies, admin_ID)
     VALUES('$book_title', '$book_author', '$book_category', '$book_published', '$book_copies', '$admin_ID') ";

    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['message'] = "Book Created Successfully!"; 
    } else {
        $_SESSION['message'] = "Book Not Created!"; 
    }
  } else if (isset($_POST['delete_a_book'])) {
    $ISBN = mysqli_real_escape_string($conn, $_POST['delete_a_book']);

    $query = "DELETE FROM `books` WHERE ISBN='$ISBN' ";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['message'] = "Book deleted successfully!";
    } else {
        $_SESSION['message'] = "Book not deleted!";
    }

  } else if (isset($_POST['update_a_book'])) {
    $update_ISBN = mysqli_real_escape_string($conn, $_POST['update_ISBN']);
    $book_title = mysqli_real_escape_string($conn, $_POST['book_title']);
    $book_author = mysqli_real_escape_string($conn, $_POST['book_author']);
    $book_category = mysqli_real_escape_string($conn, $_POST['book_category']);
    $book_published = mysqli_real_escape_string($conn, date('Y-m-d', strtotime($_POST['book_published'])));
    $book_copies = mysqli_real_escape_string($conn, $_POST['book_copies']);

    $query = "UPDATE books 
    SET book_title='$book_title', book_author='$book_author', book_category='$book_category', book_published='$book_published', book_copies='$book_copies'
    WHERE ISBN='$update_ISBN' ";

    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['message'] = "Book updated successfully!";
    } else {
        $_SESSION['message'] = "Book not updated!";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Book List</title>
</head>

<body>
 
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
                        <a class="nav-link px-3 sidebar-link active" data-bs-toggle="collapse" href="#books">
                            <span class="me-2"><i class="bi bi-layout-split"></i></span>
                            <span>Books</span>
                            <span class="ms-auto">
                                <span class="right-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </span>
                        </a>
                        <div class="collapse show" id="books">
                            <ul class="navbar-nav ps-3">
                                <li>
                                    <a href="categories.php" class="nav-link px-3">
                                        <span class="me-2"><i class="bi bi-book-fill"></i></i></span>
                                        <span>Categories</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="bookList.php" class="nav-link px-3 active">
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
  
    <main class="mt-5 pt-4 pl-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h4>Books</h4>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Books</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Book List</li>
                        </ol>
                    </nav>

                    <div class="border border-secondary border-opacity-25 p-3 overflow-auto rounded ">
                        <div class="row">
                            <div class="col-sm-6">
                            
                                <button type="button" class="btn btn-primary text-nowrap mb-2" data-bs-toggle="modal"
                                    data-bs-target="#add_a_book">Add a Book</button>
                            </div>
                            <div class="col-sm-6">
                              
                                    <input class="form-control" id="search" type="search" placeholder="Search">
                              
                            </div>
                        </div>
                   
                        <div class="modal fade" id="add_a_book" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                    class="modal-content" method="POST">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Add a Book</h1>
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

                                        <div class="mb-2">
                                            <label class="form-label">Published</label>
                                            <input type="date" name="book_published" class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Copies</label>
                                            <input type="text" name="book_copies" class="form-control">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="add_a_book" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal for update books -->
                        <div class="modal fade" id="editmodal" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                    class="modal-content" method="POST">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Update Book Details</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="update_ISBN" id="update_ISBN" class="form-control">
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
                                            <input type="text" name="book_category" id="book_category"
                                                class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Published</label>
                                            <input type="date" name="book_published" id="book_published"
                                                class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Copies</label>
                                            <input type="number" name="book_copies" id="book_copies"
                                                class="form-control">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="update_a_book"
                                            class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- =============================================================================== -->
                        <table class="table table-striped table-hover text-nowrap">
                            <thead class="table-dark">
                                <tr>
                                    <th>ISBN</th>
                                    <th>Book Title</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>Published</th>
                                    <th>Copies</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody id="myTable">
                                <?php include "message.php" ?>
                                <?php
                                   $query = "SELECT * FROM books";

                                   $query_run = mysqli_query($conn, $query);

                                   if (mysqli_num_rows($query_run) > 0) {
                                      foreach($query_run as $book) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?=$book['ISBN']; ?>
                                            </td>
                                            <td>
                                                <?=$book['book_title']; ?>
                                            </td>
                                            <td>
                                                <?=$book['book_author']; ?>
                                            </td>
                                            <td>
                                                <?=$book['book_category']; ?>
                                            </td>
                                            <td>
                                                <?=$book['book_published']; ?>
                                            </td>
                                            <td>
                                                <?=$book['book_copies']; ?>
                                            </td>
                                            <td class="d-flex align-items-start m-0 py-1">
                                                <button class="editbtn btn btn-success py-1">Edit</button>&nbsp;&nbsp;
                                                <form class="m-0" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                                    method="POST">
                                                    <button class="btn btn-danger py-1" type="submit" name="delete_a_book"
                                                        value="<?=$book['ISBN']; ?>">Delete</button>
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
        </div>
    </main>

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

                $('#update_ISBN').val(data[0]);
                $('#book_title').val(data[1]);
                $('#book_author').val(data[2]);
                $('#book_category').val(data[3]);
                $('#book_published').val(data[4]);
                $('#book_copies').val(data[5]);
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