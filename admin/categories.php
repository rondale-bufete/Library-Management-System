<?php
  include "header.php";
  include "links.php";
  require "../dbcon.php";

 if (isset($_POST['edit_category'])) { {
    $prev_category = mysqli_real_escape_string($conn, $_POST['prev_category']);
    $update_category = mysqli_real_escape_string($conn, $_POST['book_category']);

    
    $query = "UPDATE books SET book_category='$update_category' WHERE book_category='$prev_category' ";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['message'] = "Category updated Successfully!";
    } else {
        $_SESSION['message'] = "Category not updated!";
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
    <title>Categories</title>
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
                                    <a href="categories.php" class="nav-link px-3 active">
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
                    <h4>Books</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Books</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Categories</li>
                        </ol>
                    </nav>
                    <div class="border border-secondary border-opacity-25 p-3 overflow-auto rounded">
                        <div class="row d-flex">
                            <div class="col-sm-6">
                                <!-- search input -->
                                    <input class="form-control mb-3" type="search" id="search" placeholder="Search">
                                <!-- search input -->
                            </div>
                        </div>

                        <!-- ========================================================= -->
                        <!-- Modal for edit category -->
                        <div class="modal fade" id="edit_category" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                    class="modal-content" method="POST">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Edit Category</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="prev_category" id="prev_category">
                                        <div class="mb-3">
                                            <label class="form-label">Category Name</label>
                                            <input type="text" name="book_category" id="book_category"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="edit_category" class="btn btn-primary">Save
                                            changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- ========================================================= -->
                        <table class="table table-striped table-hover text-nowrap">
                            <thead class="table-dark">
                                <tr>
                                    <th>No. of Subjects</th>
                                    <th>Category Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                <?php include "message.php";?>
                                <?php
                                  $query = "SELECT COUNT(ISBN) AS no_subjects, book_category FROM books GROUP BY book_category ASC";
                                  $query_run = mysqli_query($conn, $query);

                                  if (mysqli_num_rows($query_run) >= 1) {
                                    foreach($query_run as $category) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?=$category['no_subjects']; ?>
                                            </td>
                                            <td>
                                                <?=$category['book_category']; ?>
                                            </td>
                                            <td class="d-flex align-items-center m-0 py-1">
                                                <button class="editbtn btn btn-success py-1">Edit</button>&nbsp;&nbsp;
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                  }  else {
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>

        $(document).ready(function () {

            $('.editbtn').on('click', function () {
                // show modal onclick
                $('#edit_category').modal('show');
                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#book_category').val(data[1]);
                $('#prev_category').val(data[1]);
            });

            
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