<?php 
if (isset($_POST['delete'])) {
  
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
  // Delect account from database
  $sql = "DELETE FROM Accounts WHERE `Accounts`.`personID` = {$_POST['delete']}";
  
  try {
    if (mysqli_query($link, $sql)) {
      header("location: admin.php?d=1");
    } else {
      header("location: admin.php?d=0");
    } 
  }
  catch (Exception $e) {
    header("location: admin.php?d=0");
  }
}

?>