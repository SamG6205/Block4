<?php 
// Get session info and check if user is logged in
session_start();

if (!isset($_SESSION['loggedin'])) {
  // If not logged in redirect ot login page
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
      $role = $_POST['role'];
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
        echo "<h3> Person Info </h3><table>
                    <tr>
                    <th width='150px'>Person ID<br><hr></th>
                    <th width='100px'>First Name<br><hr></th>
                    <th width='100px'>Last Name<br><hr></th>
                    <th width='200px'>Role<br><hr></th>
                    </tr>";
        // Select person info from database
                $sql = mysqli_query($link, "SELECT Persons.personID, Persons.firstname, Persons.lastname
FROM Persons
WHERE Persons.personID = '5';");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['personID']}</td>
                        <td>{$row['firstname']}</td>
                        <td>{$row['lastname']}</td>
                        <td>{$role}</td>
                        </tr>";
                }
        echo "</table><br>";

      // Get Address
        echo "<h3>Addresses</h3><table>
                    <tr>
                    <th width='140px'>Address ID<br><hr></th>
                    <th width='140px'>Postcode<br><hr></th>
                    <th width='300px'>Address Line 1<br><hr></th>
                    <th width='300px'>Address Line 2<br><hr></th>
                    <th width='300px'>Address Line 3<br><hr></th>
                    <th width='120px'>Primary<br><hr></th>
                    </tr>";
        // Select address from database
                $sql = mysqli_query($link, "SELECT Addresses.addressID, Addresses.postcode, Addresses.line2, Addresses.line2, Addresses.line2, Residents.primary
FROM Addresses
INNER JOIN Residents ON Addresses.addressID = Residents.addressID
INNER JOIN Persons ON Persons.personID = Residents.personID
WHERE Persons.personID = '5'");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['addressID']}</td>
                        <td>{$row['postcode']}</td>
                        <td>{$row['line1']}</td>
                        <td>{$row['line2']}</td>
                        <td>{$row['line3']}</td>
                        <td>{$row['primary']}</td>
                        </tr>";
                }
        echo "</table><br>";
        
      if ($role == 'Student') {
        // Get Student's Info
        echo "<h3>Class Info</h3><table>
                    <tr>
                    <th width='120px'>Class Name<br><hr></th>
                    <th width='200px'>Class Capacity<br><hr></th>
                    </tr>";
        // Select class info from database
                $sql = mysqli_query($link, "SELECT Classes.className, Classes.capacity FROM Classes
INNER JOIN Students on Students.className = Classes.className
WHERE Students.personID = '$id'");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['className']}</td>
                        <td>{$row['capacity']}</td>
                        <th><form method='post' action='classinfo.php'><input name='class' value='{$row['className']}' hidden>
                        <button>Info</button>
                        </form></th>
                        </tr>";
                }
        echo "</table><br>";
        
        echo "<h3>Parent Info</h3><table>
                    <tr>
                    <th width='120px'>Parent ID<br><hr></th>
                    <th width='200px'>First Name<br><hr></th>
                    <th width='120px'>Last Name<br><hr></th>
                    <th width='120px'>Email<br><hr></th>
                    <th width='120px'>Telephone<br><hr></th>
                    <th width='120px'>Mobile<br><hr></th>
                    <th width='120px'>Primary<br><hr></th>
                    </tr>";
        
        // Select parents from database
                $sql = mysqli_query($link, "SELECT Parents.personID, Persons.firstname, Persons.lastname, Parents.email, Parents.telephone, Parents.mobile, StudentParent.primaryContact FROM Students
INNER JOIN StudentParent ON StudentParent.studentID = Students.personID
INNER JOIN Parents ON Parents.personID = StudentParent.parentID
INNER JOIN Persons ON Persons.personID = Parents.personID
WHERE Students.personID = '$id'");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['personID']}</td>
                        <td>{$row['firstname']}</td>
                        <td>{$row['lastname']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['telephone']}</td>
                        <td>{$row['mobile']}</td>
                        <td>{$row['primary']}</td>
                        <th><form method='post' action='personinfo.php'><input name='id' value='{$row['personID']}' hidden>
                        <input name='role' value='Parent' hidden>
                        <button>Info</button>
                        </form></th>
                        </tr>";
                }
        echo "</table><br>";
        
        echo "<h3>Medical Info</h3><table>";
                $sql = mysqli_query($link, "SELECT medicalInfo
FROM Students
WHERE Students.personID = '21'");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['medicalInfo']}</td>
                        </tr>";
                }
        echo "</table><br>";
        
      }
        elseif ($role == 'Teacher') {
          // Get Teacher's Info
          echo "<h2>Class Info</h2><table>
                    <tr>
                    <th width='120px'>Class Name<br><hr></th>
                    <th width='200px'>Class Capacity<br><hr></th>
                    </tr>";
                $sql = mysqli_query($link, "SELECT Classes.className, Classes.capacity FROM Classes
INNER JOIN Teachers on Teachers.className = Classes.className
WHERE Teachers.personID = '$id'");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['className']}</td>
                        <td>{$row['capacity']}</td>
                        <th><form method='post' action='classinfo.php'><input name='class' value='{$row['className']}' hidden>
                        <button>Info</button>
                        </form></th>
                        </tr>";
                }
          echo "</table><br>";
          
          echo "<h3>Background Check</h3><br><table>";
                $sql = mysqli_query($link, "SELECT bgCheck FROM Teachers WHERE personID = '$id'");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['bgCheck']}</td>
                        </tr>";
                }
          echo "</table><br>";
          
      
      }
        elseif ($role == 'Assistant') {
          // Get Assistant's Info
          echo "<h2>Class Info</h2><table>
                    <tr>
                    <th width='120px'>Class Name<br><hr></th>
                    <th width='200px'>Class Capacity<br><hr></th>
                    </tr>";
                $sql = mysqli_query($link, "SELECT Classes.className, Classes.capacity FROM Classes
INNER JOIN Assistants on Assistants.className = Classes.className
WHERE Assistants.personID = '$id'");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['className']}</td>
                        <td>{$row['capacity']}</td>
                        <th><form method='post' action='classinfo.php'><input name='class' value='{$row['className']}' hidden>
                        <button>Info</button>
                        </form></th>
                        </tr>";
                }
          echo "</table><br>";
          
          echo "<h3>Background Check</h3><br><table>";
                $sql = mysqli_query($link, "SELECT bgCheck FROM Assistants WHERE personID = '$id'");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['bgCheck']}</td>
                        </tr>";
                }
          echo "</table><br>";
          
      }
        elseif ($role == 'Parent') {
          // Get Parent's info
          echo "<h3>Children Info</h3><table>
                    <tr>
                    <th width='120px'>Person ID<br><hr></th>
                    <th width='200px'>First Name<br><hr></th>
                    <th width='200px'>Last Name<br><hr></th>
                    </tr>";
                $sql = mysqli_query($link, "SELECT Students.personID, Persons.firstname, Persons.lastname
FROM Parents
INNER JOIN StudentParent ON StudentParent.parentID = Parents.personID
INNER JOIN Students ON Students.personID = StudentParent.studentID
INNER JOIN Persons ON Students.personID = Persons.personID
WHERE Parents.personID = '$id'");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['personID']}</td>
                        <td>{$row['firstname']}</td>
                        <td>{$row['lastname']}</td>
                        <th><form method='post' action='personinfo.php'><input name='id' value='{$row['personID']}' hidden>
                        <input name='role' value='Student' hidden>
                        <button>Info</button>
                        </form></th>
                        </tr>";
                }
          echo "</table><br>";
          
      }
           

?>
      </div>
    </body>
</html>      