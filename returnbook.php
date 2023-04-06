<?php
$id = $_POST['id'];
$date = date("Y-m-d");

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
                // Update borrow to have todays date as the return date.
                $sql = "UPDATE Borrows SET returnDate = '$date' WHERE Borrows.bookID = '$id' AND returnDate is null";
                try {
                  if (mysqli_query($link, $sql)) {
                    header("location: library.php");
                  } else {
                    header("location: library.php?e=1");
                  } 
                }
                catch (Exception $e) {
                  header("location: library.php?e=1");
                }
?>