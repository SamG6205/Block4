<?php 
session_start();

$host = "sdb-57.hosting.stackcp.net";
$username = "student109-353031352bc6";
$password = "ua92-studentAc";
$dbname = "student109-353031352bc6";

//Connect to database
$link = mysqli_connect($host,$username,$password,$dbname);

//Check connection
if ($link === false) {
  die("Connection failed: ");
}

$email = $_POST['email'];

// Get record from database with matching email
$sql = mysqli_query($link, "SELECT personID, password, role FROM Accounts WHERE email = '$email'");

$row = $sql->fetch_assoc();
// Check the passwords match
if (isset($row['password']) and password_verify($_POST['password'], $row['password'])) {
  // If matched reset the session and add data to it
  session_regenerate_id();
  $_SESSION['loggedin'] = TRUE;
  $_SESSION['id'] = $row['personID'];
  $_SESSION['email'] = $email;
  $_SESSION['role'] = $row['role'];
  // Redirect to home page 
  header('Location: index.php');
  exit;
  
}
else {
  // If unsuccesfull redirect to login page with error
  header('Location: login.php?e=1');
}
  
  
?>