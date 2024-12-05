<?php
  require "../dbcon.php";

  if(isset($_POST['edit_a_student']))
  {   
      $s_ID = $_POST['update_id'];
      $s_fname = $_POST['s_fname'];
      $s_lname = $_POST['s_lname'];
      $s_course = $_POST['s_course'];
      $s_section = $_POST['s_section'];
      $s_year = $_POST['s_year'];
      $s_username = $_POST['s_username'];
      $s_password = $_POST['s_password'];

      $query = "UPDATE students SET s_fname='$s_fname', s_lname='$s_lname', s_course='$s_course', s_section='$s_section', s_year='$s_year', s_username='$s_username', s_password='$s_password' WHERE s_ID='$s_ID' ";
      $query_run = mysqli_query($conn, $query);

      if($query_run)
      {
          echo '<script> alert("Data Updated"); </script>';
          header("Location:studentList.php");
      }
      else
      {
          echo '<script> alert("Data Not Updated"); </script>';
      }
  }
?>