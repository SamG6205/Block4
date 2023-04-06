<?php 
// Database information
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

if ($_POST['admin']) {
  $role = 'admin';
}
else {
  $role = 'staff';
}
// Encrypt password
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
// Insert into database
$sql = "INSERT INTO Accounts (personID, email, password, role) VALUES ('{$_POST['id']}','{$_POST['email']}','{$password}','$role')";

// Redirect with error or success info using GET
try {
  if (mysqli_query($link, $sql)) {
    header("location: admin.php?a=1");
  } else {
    header("location: admin.php?a=0");
  } 
}
catch (Exception $e) {
  header("location: admin.php?a=0");
}

?>