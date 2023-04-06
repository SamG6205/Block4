<?php 
// Get session info and redirect if not logged in.
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php?e=1');
	exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Rishton Academy Classes</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
 <link rel="stylesheet" href="style.css"> 
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-expand-sm bg-light">
                <div class="container-fluid">
                    <img style="width:300px" id="nav-logo" src="images/Logo.png" alt="Logo"/>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="collapsibleNavbar" style="font-size: 1.5rem; padding:10px">
                        <ul class="navbar-nav">
                            <li class="navbar-item"><a href="index.php">Home</a></li>
                            <li class="navbar-item"><a href="student.php">Student</a></li>
                            <li class="navbar-item"><a href="parent.php">Parent</a></li>
                            <li class="navbar-item"><a href="teacher.php">Teacher</a></li>
                            <li class="navbar-item"><a href="classes.php">Class</a></li>
                            <li class="navbar-item"><a href="library.php">Library</a></li>
                          <?php if ($_SESSION['role'] == 'admin') {
                              echo "<li class='navbar-item'><a href='admin.php'>Admin</a></li>";
                            }
                          ?>
                            <li class="navbar-item"><a href="contact.php">Contact</a></li>
                          <li class='navbar-item'><a href='logout.php'>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
      <div class="container">

<?php
      $id = $_POST['id'];
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
                

// Get Class name, capacity and teacher
echo "<h2> Class Info </h2><br><table>
                    <tr>
                    <th width='80px'>Book ID<br><hr></th>
                    <th width='300px'>Title<br><hr></th>
                    <th width='300px'>Author ID<br><hr></th>
                    <th width='120px'>Borrow Date<br><hr></th>
                    <th width='120px'>Return Date<br><hr></th>
                    </tr>";
        // Select all borrows for a book ordered by return date where most recent are first with 'Null' being at the top.
                $sql = mysqli_query($link, "SELECT Borrows.bookID, Books.title,Books.author, Borrows.borrowDate, Borrows.returnDate FROM Borrows
INNER JOIN Books ON Books.bookID = Borrows.bookID
WHERE Borrows.bookID = '$id'
ORDER BY -Borrows.returnDate");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['bookID']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['author']}</td>
                        <td>{$row['borrowDate']}</td>
                        <td>";
                    if (strlen($row['returnDate'])>0) {
                      echo "{$row['returnDate']}";   
                    }
                    else {
                      echo "<form method='post' action='returnbook.php'>
                        <input name='id' value='{$row['bookID']}' hidden>
                        <button>Return</info>
                        </form>";
                    }
                    echo "</td>
                        </tr>";
                }
echo "</table><br>";

?>
      </div>
    </body>
</html>      