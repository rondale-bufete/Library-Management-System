<?php
  include "header.php";
  include "links.php";
  require "../dbcon.php";
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['btn_approve'])) {
          $bt_ID = mysqli_real_escape_string($conn, $_POST['btn_approve']);
          $query = "UPDATE `book_transactions` SET `bt_status`='1' WHERE bt_ID = '$bt_ID' ";
          $query_run = mysqli_query($conn, $query); 
          
          if ($query_run) {
            $_SESSION['message'] = "Request successfully Approved!";
          } else {
            $_SESSION['message'] = "Request not Approved!";
          }
      }

      if (isset($_POST['btn_decline'])) {
        $bt_ID = mysqli_real_escape_string($conn, $_POST['btn_decline']);
        $query = "UPDATE `book_transactions` SET `bt_status`='2' WHERE bt_ID = '$bt_ID' ";
        $query_run = mysqli_query($conn, $query); 

        if ($query_run) {
          $_SESSION['message'] = "Request successfully Declined!";
        } else {
          $_SESSION['message'] = "Request not Decline!";
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
    <title>Pending Books</title>
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
                                    <a href="pending_books.php" class="nav-link px-3 active">
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
                            <li class="breadcrumb-item active" aria-current="page">Request Logs</li>
                        </ol>
                    </nav>
                    <div class="border border-secondary border-opacity-25 p-3 overflow-auto rounded">
                        <table class="table table-striped table-hover text-nowrap">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">ISBN</th>
                                    <th scope="col">Book Title</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Student ID</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include 'message.php'; ?>
                                <?php
                                    $query = "SELECT book_transactions.bt_ID, books.ISBN, books.book_title, books.book_author, books.book_category , students.s_ID, book_transactions.bt_date
                                    FROM ((book_transactions 
                                    INNER JOIN books ON book_transactions.ISBN = books.ISBN)
                                    INNER JOIN students ON book_transactions.s_ID = students.s_ID) WHERE bt_status = '0' ";
                                    $query_run = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach($query_run as $data) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?=$data['ISBN']; ?>
                                                </td>
                                                <td>
                                                    <?=$data['book_title']; ?>
                                                </td>
                                                <td>
                                                    <?=$data['book_author']; ?>
                                                </td>
                                                <td>
                                                    <?=$data['book_category']; ?>
                                                </td>
                                                <td>
                                                    <?=$data['s_ID']; ?>
                                                </td>
                                                <td>
                                                    <?=$data['bt_date']; ?>
                                                </td>
                                                <td class="d-flex m-0 p-0 py-1">
                                                    <form class="m-0" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                                        method="POST">
                                                        <button type="submit" name="btn_approve" class="btn btn-success py-1"
                                                            value="<?=$data['bt_ID']; ?>">Approve</button>
                                                    </form>
                                                    &nbsp;&nbsp;
                                                    <form class="m-0" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                                        method="POST">
                                                        <button type="submit" name="btn_decline" class="btn btn-danger py-1"
                                                            value="<?=$data['bt_ID']; ?>">Decline</button>
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
</body>

</html>