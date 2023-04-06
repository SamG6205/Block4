<?php 
// Get session info and redirect if not logged in
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php?e=1');
	exit;
}
if ($_POST['class']) {
                                                
                $class = $_POST['class'];
                $capacity = $_POST['capacity'];
                
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
                // Insert class into classes
                $sql = "INSERT INTO Classes (className, capacity) VALUES ('$class','$capacity')";
                try {
                  if (mysqli_query($link, $sql)) {
                    header("location: classes.php?s=1");
                  } else {
                    header("location: classes.php?e=1");
                  } 
                }
                catch (Exception $e) {
                  header("location: classes.php?e=1");
                }
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
        <main class="container-fluid" style="text-align: center;">
            <p class="display-2"> Classes</p>
          <hr>
            <button class="collapseBtn btn btn-secondary mb-2" data-bs-toggle="collapse" data-bs-target="#addClass" >Add Class</button><br>
            <div id="addClass" class="collapse show">
              <?php
              if ($_GET['s']==1) {
                echo "<div class='alert alert-success' style='padding: 3px;'>
  <strong>Success!</strong> Class successfully added.
</div>";
              }
              elseif ($_GET['e']==1) {
                echo "<div class='alert alert-danger' style='padding: 3px;'>
  <strong>Error!</strong> Failed to add class.
</div>";
              }
            
              ?>
                <form  method="post" action="classes.php">
                    <div class="input-group mb-2">
                        <label for="class" class="input-group-text"> Name</label>
                        <input id="class" name="class" class="form-control" placeholder="Class name" required>
                    </div>
                    <div class="input-group mb-2">
                        <label for="capacity" class="input-group-text"> Capacity</label>
                        <input id="capacity" name="capacity" class="form-control" placeholder="Capacity" required type="number">
                    </div>
                    <div class="mb-2">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
<hr>
            <button class="collapseBtn btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#viewClasses">View Classes</button><br>
            <div id="viewClasses" class="collapse">
                <br>
                <table class="center">
                    <tr>
                    <th width="250px">Class Name<br><hr></th>
                    <th width="250px">Capacity<br><hr></th>
                    <th width="150px"><br><hr></th>
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
                    // Select classes from class in Asceding order
                $sql = mysqli_query($link, "SELECT * FROM Classes 
                ORDER BY CASE 
                WHEN className = 'Year Six' THEN 4 
                WHEN className = 'Year Five' THEN 3 
                WHEN className = 'Year Four' THEN 2 
                WHEN className = 'Year Three' THEN 1 
                END ASC;");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "
                    <tr>
                        <th>{$row['className']}</th>
                        <th>{$row['capacity']}</th>
                        <th><form method='post' action='classinfo.php'><input name='class' value='{$row['className']}' hidden>
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