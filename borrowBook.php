<?php 
$person = $_POST['personID'];
$book = $_POST['bookID'];
$date = $_POST['date'];

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
// Insert borrow into database
$sql = "INSERT INTO Borrows (bookID, personID, borrowDate) VALUES ('$book','$person','$date')";
try {
  if (mysqli_query($link, $sql)) {
    header("location: library.php?b=1");
  } else {
    header("location: library.php?b=0");
  } 
}
catch (Exception $e) {
  header("location: library.php?b=0");
}
?>