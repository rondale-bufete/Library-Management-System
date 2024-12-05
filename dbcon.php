<?php
// Create connection
$conn = mysqli_connect('localhost', 'root', "", "library_management_system");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "<script>console.log('Connected successfully');</script>";
?>