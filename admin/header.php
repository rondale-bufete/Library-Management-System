 <?php
   include "user_type_not_set.php";
 ?>
 <!-- top navigation bar -->
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
                aria-controls="offcanvasExample">
                <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
            </button>
            <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold" href="#">
            <img src="./images/library_icon.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">  
            LIBRARY MANAGEMENT SYSTEM</a>
            <!-- dropdown -->
            <div class="dropdown">
                <button class="btn text-light fs-5 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="../logout.php">Log out</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- top navigation bar -->