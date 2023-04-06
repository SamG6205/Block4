<?php 
// Get session info and redirect to login page if not logged in
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
      $class = $_POST['class'];
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
                    <th width='150px'>Class Name<br><hr></th>
                    <th width='100px'>Capacity<br><hr></th>
                    <th width='100px'>Teacher ID<br><hr></th>
                    <th width='200px'>Teacher Name<br><hr></th>
                    </tr>";
                $sql = mysqli_query($link, "SELECT Classes.className,Classes.capacity, Persons.personID, Persons.firstname, Persons.lastname FROM Classes
INNER JOIN Teachers on Teachers.className = Classes.className
INNER JOIN Persons on Teachers.personID = Persons.personID
WHERE Classes.className = '$class';");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['className']}</td>
                        <td>{$row['capacity']}</td>
                        <td>{$row['personID']}</td>
                        <td>{$row['firstname']} {$row['lastname']}</td>
                        <th><form method='post' action='personinfo.php'><Input name='id' value='{$row['personID']}' hidden>
                        <Input name='role' value='Teacher' hidden>
                        <button>Info</button>
                        </form></th>
                        </tr>";
                }
echo "</table><br>";

      // Get Assistants
echo "<h2>Teaching Assistants</h2><br><table>
                    <tr>
                    <th width='120px'>Assistant ID<br><hr></th>
                    <th width='200px'>Asssistant Name<br><hr></th>
                    </tr>";
                $sql = mysqli_query($link, "SELECT Assistants.personID, Persons.firstname, Persons.lastname FROM Classes
INNER JOIN Assistants on Assistants.className = Classes.className
INNER JOIN Persons on Assistants.personID = Persons.personID
WHERE Classes.className = '$class';");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['personID']}</td>
                        <td>{$row['firstname']} {$row['lastname']}</td>
                        <th><form method='post' action='personinfo.php'><input name='id' value='{$row['personID']}' hidden>
                        <Input name='role' value='Assistant' hidden>
                        <button>Info</button>
                        </form></th>
                        </tr>";
                }
echo "</table><br>";
      
            // Get Students
echo "<h2>Students</h2><br><table>
                    <tr>
                    <th width='120px'>Student ID<br><hr></th>
                    <th width='200px'>Student Name<br><hr></th>
                    </tr>";
                $sql = mysqli_query($link, "SELECT Students.personID, Persons.firstname, Persons.lastname FROM Classes
INNER JOIN Students on Students.className = Classes.className
INNER JOIN Persons on Students.personID = Persons.personID
WHERE Classes.className = '$class';");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['personID']}</td>
                        <td>{$row['firstname']} {$row['lastname']}</td>
                        <th><form method='post' action='personinfo.php'><input name='id' value='{$row['personID']}' hidden>
                        <Input name='role' value='Student' hidden>
                        <button>Info</button>
                        </form></th>
                        </tr>";
                }
echo "</table><br>";


?>
      </div>
    </body>
</html>      