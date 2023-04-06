<?php 
$author = $_POST['bookAuthor'];
$title = $_POST['bookTitle'];
                
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
                // Insert book into database
                $sql = "INSERT INTO Books (title, author) VALUES ('$title','$author')";
                try {
                  if (mysqli_query($link, $sql)) {
                    header("location: library.php?a=1");
                  } else {
                    header("location: library.php?a=0");
                  } 
                }
                catch (Exception $e) {
                  header("location: library.php?a=0");
                }
?>