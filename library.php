<?php 
// Get session information to check the user is logged in.
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php?e=1');
	exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Rishton Academy Library</title>
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
  // Show admin button if user is an admin
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
        <main class="container-fluid" style="text-align: center;">
            <p class="display-2"> Library</p>
          <hr>
          <button class="collapseBtn btn btn-secondary mb-2" data-bs-toggle="collapse" data-bs-target="#addBook">Add Book</button><br>
            <div id="addBook" class="collapse">
              <form method="post" action="addBook.php">
                <div class="input-group mb-2">
                        <label for="bookTitle" class="input-group-text">Book Title</label>
                        <input id="bookTitle" name="bookTitle" class="form-control" placeholder="Book Title" required>
                    </div>
                <div class="input-group mb-2">
                        <label for="bookAuthor" class="input-group-text"> Book Author</label>
                        <input id="bookAuthor" name="bookAuthor" class="form-control" placeholder="Book Author" required>
                    </div>
                <div class="mb-2">
                            <button class="btn btn-primary" type="submit">Add</button>
                        </div>
              </form>
          </div>
          <hr>
            <button class="collapseBtn btn btn-secondary mb-2" data-bs-toggle="collapse" data-bs-target="#borrowBook">Borrow Book</button><br>
            <div id="borrowBook" class="collapse show">
                <form  action="borrowBook.php" method="post">
                    <div class="input-group mb-2">
                        <label for="personID" class="input-group-text" type="number" required> Person ID</label>
                        <input id="personID" name="personID" class="form-control" placeholder="Person ID">
                    </div>
                    <div class="input-group mb-2">
                        <label for="bookID" class="input-group-text"> Book ID</label>
                        <input id="bookID" name="bookID" class="form-control" placeholder="Book ID" type="number" required>
                    </div>
                    <div class="input-group mb-2">
                        <label for="date" class="input-group-text">Date Borrowed</label>
                        <input id="date" name="date" class="form-control" type="date" required>
                    </div>
                    <div class="mb-2">
                            <button class="btn btn-primary" type="submit">Borrow</button>
                        </div>
                </form>
            </div>
          <hr>
            <button class="collapseBtn btn btn-secondary mb-2" data-bs-toggle="collapse" data-bs-target="#availableBooks">Available Books</button><br>
            <div id="availableBooks" class="collapse">
            <br>
                <table class="center">
                    <tr>
                    <th width="80px">Book ID<br><hr></th>
                    <th width="400px">Title<br><hr></th>
                    <th width="250px">Author<br><hr></th>
                    <th width="50px"><br><hr></th>
                    </tr>
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
                    // Select books from database which have a reutrn data and display in a table
                $sql = mysqli_query($link, "SELECT Books.bookID, Books.title, Books.author FROM Books
WHERE Books.bookID not in (SELECT Borrows.bookID  
                FROM Borrows 
                WHERE returnDate IS NULL);");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "
                    <tr>
                        <th>{$row['bookID']}</th>
                        <th>{$row['title']}</th>
                        <th>{$row['author']}</th>
                        <th><form method='post' action='bookinfo.php'><input name='id' value='{$row['bookID']}' hidden>
                        <button>Info</button>
                        </form></th>
                    </tr>";
                }
                    
                ?>
                </table>
                <br>
            </div>
          <hr>
            <button class="collapseBtn btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#borrowedBooks">Borrowed Books</button><br>
            <div id="borrowedBooks" class="collapse">
            <br>
                <table class="center">
                    <tr>
                    <th width="80px">Book ID<br><hr></th>
                    <th width="400px">Title<br><hr></th>
                    <th width="250px">Author<br><hr></th>
                    <th width="150px">Borrow Date<br><hr></th>
                    <th width="300px">Borrowed By<br><hr></th>
                    <th width="50px"><br><hr></th>
                    <th width="50px"><br><hr></th>
                    </tr>
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
                    // Select books which dont have a return date
                $sql = mysqli_query($link, "SELECT Borrows.bookID, Books.title, Books.author, Borrows.borrowDate, 
                Borrows.personID, Persons.firstname, Persons.lastname  
                FROM Borrows 
                INNER JOIN Books ON Books.bookID = Borrows.bookID
                INNER JOIN Persons ON Persons.personID = Borrows.personID 
                WHERE returnDate IS NULL;");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "
                    <tr>
                        <th>{$row['bookID']}</th>
                        <th>{$row['title']}</th>
                        <th>{$row['author']}</th>
                        <th>{$row['borrowDate']}</th>
                        <th>{$row['personID']} {$row['firstname']} {$row['lastname']}</th>
                        <th><form method='post' action='returnbook.php'>
                        <input name='id' value='{$row['bookID']}' hidden>
                        <button>Return</info>
                        </form></th>
                        <th><form method='post' action='bookinfo.php'>
                        <input name='id' value='{$row['bookID']}' hidden>
                        <button>Info</button>
                        </form></th>
                    </tr>";
                }
                    
                ?>
                </table>
            </div>
        </main>
    </body>
</html>