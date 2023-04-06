<?php 
// Start session to store session information server side.
session_start();
// Check user is logged in
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php?e=1');
	exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Rishton Academy Teachers</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="style.css"> 
    </head>
    <body>
            <!-- Navbar made using Bootstrap -->
      <!-- Made referencing https://www.w3schools.com/bootstrap5/bootstrap_navbar.php -->
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
            <p class="display-2"> Teachers</p>
          <hr>
            <button class="collapseBtn btn btn-secondary mb-2" data-bs-toggle="collapse" data-bs-target="#addTeacher">Add Teacher</button><br>
            <div id="addTeacher" class="collapse show">
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
              // Check submit button was pressed
              if ($_POST['submit'] == 'Submit') {
                // Check all required input are not empty
                if (strlen($_POST['fname']) >0 and strlen($_POST['lname'])>0) {
                  if (strlen($_POST['phone']) >0) {
                    if (strlen($_POST['salary']) >0){
                      if (strlen($_POST['bgchecks']) >0) {
                        if (strlen($_POST['addressID'])>0) {
                          // Insert person into perons table
                          $sql = "INSERT INTO Persons (firstname,lastname) VALUES ('{$_POST['fname']}','{$_POST['lname']}')";
                          try {
                            if (mysqli_query($link, $sql)) {
                              $person = mysqli_insert_id($link);
                              // Add person to teachers table
                              $sql = "INSERT INTO Teachers (personID ,className, mobile, salary, bgCheck) VALUES ('$person' ,'{$_POST['class']}','{$_POST['phone']}','{$_POST['salary']}','{$_POST['bgchecks']}')";
                              if (mysqli_query($link, $sql)){
                                $parent = mysqli_insert_id($link);
                                // Connect teachcer to address
                                $sql = "INSERT INTO Residents (addressID, personID, `primary`) VALUES ('{$_POST['addressID']}','$person', '1')";
                                if (mysqli_query($link, $sql)){
                                  if (isset($_POST['address2ID'])) {
                                    // Connect to secondary address if applicable
                                    $sql = "INSERT INTO Residents (addressID, personID, `primary`) VALUES ('{$_POST['address2ID']}','$person', '0')";
                                    if (mysqli_query($link, $sql)){
                                      // Reload page with error info
                                      echo "<script>window.location.href='parent.php?s=1';</script>";
                                    }
                                  }
                                  else {
                                    echo "<script>window.location.href='parent.php?s=1';</script>";
                                  }
                                }
                              }  
                            } else {
                              echo("SQL Error");
                            } 
                          }
                          catch (Exception $e) {
                            echo("SQL Error, $e");
                          }

                        }
                        else {
                          // Show alert if there was an error
                          echo "<div class='alert alert-danger' style='padding: 3px;'>
  <strong>Error!</strong> Address required. </div>";
                        }
                      } else {
                        echo "<div class='alert alert-danger' style='padding: 3px;'>
  <strong>Error!</strong> Background Check required. </div>";
                      }
                    } else {
                      echo "<div class='alert alert-danger' style='padding: 3px;'>
  <strong>Error!</strong> Salary required. </div>";
                    }
                  }
                  else {
                    echo "<div class='alert alert-danger' style='padding: 3px;'>
  <strong>Error!</strong> Telephone and mobile number required. </div>";
                  }
                }
                else {
                  echo "<div class='alert alert-danger' style='padding: 3px;'>
  <strong>Error!</strong> First name and Last name required. </div>";
                }
                if ($_POST['stage'] != 8) {
                  $_POST['stage'] -= 1;
                }
              }
              if ($_GET['s']=='1') {
                // If successfull tell the user.
                echo "<div class='alert alert-success' style='padding: 3px;'>
  <strong>Success!</strong> Parent added to database. </div>";
              }
              ?>
              <form  action="" method="post">
                <div class="input-group mb-2">
                  <!-- PHP code saves data input if their was an error rather than all inputs being blank -->
                  <label for="fname" class="input-group-text"> Name</label>
                  <input id="fname" name="fname" class="form-control" placeholder="First name" value="<?php echo "{$_POST['fname']}" ?>" required>
                  <input id="lname" name="lname" class="form-control" placeholder="Last name" value="<?php echo "{$_POST['lname']}" ?>" required>
                </div>
                <div class="input-group mb-2">
                  <label for="phone" class="input-group-text"> Phone</label>
                  <input id="phone" name="phone" class="form-control" placeholder="Phone number" value="<?php echo "{$_POST['phone']}" ?>" type='number' required>
                </div>
                <div class="input-group mb-2">
                  <label for="salary" class="input-group-text" type='number'> Salary</label>
                  <input id="salary" name="salary" class="form-control" placeholder="Annualy salary" value="<?php echo "{$_POST['salary']}" ?>" required> 
                </div>
                <div class="input-group mb-2">
                  <label for="bgchecks" class="input-group-text"> Background <br>Checks</label>
                  <textarea id="bgchecks" name="bgchecks" type="text" class="form-control" placeholder="Background check information" required><?php echo "{$_POST['bgchecks']}"?></textarea>
                </div>
                <div class="input-group mb-2">
                  <label for="class" class="input-group-text">Class</label>
                  <select id="class" name="class" class="form-control">
                    <option <?php if($_POST['class'] == 'Reception'){echo("selected");}?>>Reception</option>
                            <option <?php if($_POST['class'] == 'Year One'){echo("selected");}?>>Year One</option>
                            <option <?php if($_POST['class'] == 'Year Two'){echo("selected");}?>>Year Two</option>
                            <option <?php if($_POST['class'] == 'Year Three'){echo("selected");}?>>Year Three</option>
                            <option <?php if($_POST['class'] == 'Year Four'){echo("selected");}?>>Year Four</option>
                            <option <?php if($_POST['class'] == 'Year Five'){echo("selected");}?>>Year Five</option>
                            <option <?php if($_POST['class'] == 'Year Six'){echo("selected");}?>>Year Six</option>
                  </select>
                  <label for="assistant" class="input-group-text">
                    <input id="assistant" name="assistant" type="checkbox" <?php if($_POST['assistant']){echo("checked");}?> >
                    <span class="ms-2">Assistant</span>
                  </label>
                </div>
                    <?php
  if (!isset($_POST['stage']) or ($_POST['stage'] == 0)) {
    echo "<div class='input-group mb-2'>
                        <label class='input-group-text'>Postcode</label>
                        <input class='form-control' name='postcode' placeholder='House Postcode'>
                        <input name='stage' value = '1' hidden>
                        <input class='btn btn-success' type='submit' name='button' value='Find'>
                    </div>";
  }
                               elseif ($_POST['stage'] == '1') {
                                 echo "<div class='input-group mb-2'>
                        <label for='address' class='input-group-text'>Address</label>
                        <input name='stage' value = '2' hidden>
                        <input name='postcode' value = '{$_POST['postcode']}' hidden>
                        <select id='address' name='address' class='form-control'>
                        <option hidden>Select Address</option>
                        <option value='0'>Add New Address</option>
                        ";

                                 $sql = mysqli_query($link, "SELECT addressID, line1, line2, line3 FROM Addresses WHERE postcode = '{$_POST['postcode']}'");

                                 while ($row = $sql->fetch_assoc()) {
                                   echo "
                        <option value='{$row['addressID']}'>{$row['line1']}, {$row['line2']}, {$row['line3']}</option>
                        ";
                                 }
                                 echo "</select><input type='submit' name='button' value='Add' class='btn btn-success'></div>";
                               }
                               elseif ($_POST['stage'] == '2') {
                                 if ($_POST['address'] > 0 ) {
                                   $sql = mysqli_query($link, "SELECT line1,line2,line3 FROM Addresses WHERE addressID = '{$_POST['address']}'");

                                   $row = $sql->fetch_assoc();

                                   echo "<div  class='input-group mb-2'>
                        <label class='input-group-text'>Address</label>
                        <input class='form-control' placeholder='{$row['line1']},{$row['line2']},{$row['line3']}' name='address' disabled>
                        <input name='addressText' value = '{$row['line1']},{$row['line2']},{$row['line3']}' hidden>
                        <input class='form-control' value='{$_POST['address']}' name='addressID' hidden>
                        <input name='stage' value = '4' hidden>
                        <input type='submit' name='button' value='x' class='btn btn-danger'>
                       <input type='submit' name='button' value='Add' class='btn btn-success'> 
                    </div>";
                                 } else {
                                   echo "<div class='input-group mb-2'> 
                        <label class='input-group-text'>Postcode</label>
                        <input class='form-control' placeholder='Postcode' name='postcode'>
                        </div><div  class='input-group mb-2'> 
                        <label class='input-group-text'>Address Line 1</label>
                        <input class='form-control' placeholder='Postcode' name='line1'>
                        </div><div  class='input-group mb-2'> 
                        <label class='input-group-text'>Address Line 2</label>
                        <input class='form-control' placeholder='Postcode' name='line2'>
                        </div><div  class='input-group mb-2'> 
                        <label class='input-group-text'>Address Line 3</label>
                        <input class='form-control' placeholder='Postcode' name='line3'>
                        <input name='stage' value = '3' hidden>
                        <input type='submit' name='button' value='Add' class='btn btn-success'> </div>";
                                 }
                               }
                               elseif ($_POST['stage'] == '3') {
                                 $sql = "INSERT INTO Addresses (postcode,line1,line2,line3) VALUES ('{$_POST['postcode']}','{$_POST['line1']}','{$_POST['line2']}','{$_POST['line3']}')";
                                 try {
                                   if (mysqli_query($link, $sql)){
                                     $addressID = mysqli_insert_id($link);
                                   }
                                 }
                                 catch (Exception $e) {
                                 }
                                 echo "<div  class='input-group mb-2'>
                        <label class='input-group-text'>Address</label>
                        <input class='form-control' placeholder='{$_POST['line1']},{$_POST['line2']},{$_POST['line3']}' name='address' disabled>
                        <input name='addressText' value = '{$_POST['line1']},{$_POST['line2']},{$_POST['line3']}' hidden>
                        <input class='form-control' value='$addressID' name='addressID' hidden>
                        <input name='stage' value = '4' hidden>
                        <input type='submit' name='button' value='x' class='btn btn-danger'>
                       <input type='submit' name='button' value='Add' class='btn btn-success'> 
                    </div>";
                               }
                               elseif ($_POST['stage'] == '4') {
                                 if ($_POST['button'] == 'x') {
                                   echo "<div class='input-group mb-2'>
                        <label class='input-group-text'>Postcode</label>
                        <input class='form-control' name='postcode' placeholder='House Postcode'>
                        <input name='stage' value = '1' hidden>
                        <input class='btn btn-success' type='submit' name='button' value='Find'>
                    </div>";
                                 }
                                 elseif ($_POST['button'] == 'Add') {
                                   echo "<div  class='input-group mb-2'>
                        <label class='input-group-text'>Primary Address</label>
                        <input class='form-control' placeholder='{$_POST['addressText']}' name='address' disabled>
                        <input name='addressText' value = '{$_POST['addressText']}' hidden>
                        <input class='form-control' value='{$_POST['addressID']}' name='addressID' hidden>
                        <input type='submit' name='button' value='x' class='btn btn-danger'>
                    </div>
                    <div class='input-group mb-2'>
                        <label class='input-group-text'>Postcode</label>
                        <input class='form-control' name='postcode2' placeholder='House Postcode'>
                        <input name='stage' value = '5' hidden>
                        <input class='btn btn-success' type='submit' name='button' value='Find'>
                    </div>";

                                 }
                               }
                               elseif ($_POST['stage'] == '5') {
                                 if ($_POST['button'] == 'x') {
                                   echo "<div class='input-group mb-2'>
                        <label class='input-group-text'>Postcode</label>
                        <input class='form-control' name='postcode' placeholder='House Postcode'>
                        <input name='stage' value = '1' hidden>
                        <input class='btn btn-success' type='submit' name='button' value='Find'>
                    </div>";
                                 }
                                 else {
                                   echo "<div  class='input-group mb-2'>
                        <label class='input-group-text'>Primary Address</label>
                        <input class='form-control' placeholder='{$_POST['addressText']}' name='address' disabled>
                        <input name='addressText' value = '{$_POST['addressText']}' hidden>
                        <input class='form-control' value='{$_POST['addressID']}' name='addressID' hidden>
                        <input type='submit' name='button' value='x' class='btn btn-danger'>
                    </div>

                      <div class='input-group mb-2'>
                        <label for='address' class='input-group-text'>Address</label>
                        <input name='stage' value = '6' hidden>
                        <input name='postcode2' value = '{$_POST['postcode2']}' hidden>
                        <select id='address' name='address2' class='form-control'>
                        <option hidden>Select Address</option>
                        <option value='0'>Add New Address</option>
                        ";

                                   $sql = mysqli_query($link, "SELECT addressID, line1, line2, line3 FROM Addresses WHERE postcode = '{$_POST['postcode2']}'");

                                   while ($row = $sql->fetch_assoc()) {
                                     echo "
                        <option value='{$row['addressID']}'>{$row['line1']}, {$row['line2']}, {$row['line3']}</option>
                        ";
                                   }
                                   echo "</select><input type='submit' name='button' value='Add' class='btn btn-success'></div>";
                                 }
                               }
                               elseif ($_POST['stage'] == '6') {
                                 if ($_POST['button'] == 'x') {
                                   echo "<div class='input-group mb-2'>
                        <label class='input-group-text'>Postcode</label>
                        <input class='form-control' name='postcode' placeholder='House Postcode'>
                        <input name='stage' value = '1' hidden>
                        <input class='btn btn-success' type='submit' name='button' value='Find'>
                    </div>";
                                 }
                                 else {
                                   echo "<div  class='input-group mb-2'>
                        <label class='input-group-text'>Primary Address</label>
                        <input class='form-control' placeholder='{$_POST['addressText']}' name='address' disabled>
                        <input name='addressText' value = '{$_POST['addressText']}' hidden>
                        <input class='form-control' value='{$_POST['addressID']}' name='addressID' hidden>
                        <input type='submit' name='button' value='x' class='btn btn-danger'>
                    </div>";
                                   if ($_POST['address2'] >0) {
                                     $sql = mysqli_query($link, "SELECT line1,line2,line3 FROM Addresses WHERE addressID = '{$_POST['address2']}'");

                                     $row = $sql->fetch_assoc();

                                     echo "<div  class='input-group mb-2'>
                        <label class='input-group-text'>Secondary Address</label>
                        <input class='form-control' placeholder='{$row['line1']},{$row['line2']},{$row['line3']}' name='address2' disabled>
                        <input name='addressText2' value = '{$row['line1']},{$row['line2']},{$row['line3']}' hidden>
                        <input class='form-control' value='{$_POST['address']}' name='address2ID' hidden>
                        <input name='stage' value = '8' hidden>
                        <input type='submit' name='button2' value='x' class='btn btn-danger'>
                    </div>";
                                   } else {
                                     echo "<div class='input-group mb-2'> 
                        <label class='input-group-text'>Postcode</label>
                        <input class='form-control' placeholder='Postcode' name='postcode2'>
                        </div><div  class='input-group mb-2'> 
                        <label class='input-group-text'>Address Line 1</label>
                        <input class='form-control' placeholder='Postcode' name='2line1'>
                        </div><div  class='input-group mb-2'> 
                        <label class='input-group-text'>Address Line 2</label>
                        <input class='form-control' placeholder='Postcode' name='2line2'>
                        </div><div  class='input-group mb-2'> 
                        <label class='input-group-text'>Address Line 3</label>
                        <input class='form-control' placeholder='Postcode' name='2line3'>
                        <input name='stage' value = '7' hidden>
                        <input type='submit' name='button' value='Add' class='btn btn-success'> </div>";
                                   }
                                 }
                               }
                               elseif ($_POST['stage'] == '7') {
                                 echo "<div  class='input-group mb-2'>
                        <label class='input-group-text'>Primary Address</label>
                        <input class='form-control' placeholder='{$_POST['addressText']}' name='address' disabled>
                        <input name='addressText' value = '{$_POST['addressText']}' hidden>
                        <input class='form-control' value='{$_POST['addressID']}' name='addressID' hidden>
                        <input type='submit' name='button' value='x' class='btn btn-danger'>
                    </div>";
                                 $sql = "INSERT INTO Addresses (postcode,line1,line2,line3) VALUES ('{$_POST['postcode2']}','{$_POST['2line1']}','{$_POST['2line2']}','{$_POST['2line3']}')";
                                 try {
                                   if (mysqli_query($link, $sql)){
                                     $address2ID = mysqli_insert_id($link);
                                   }
                                 }
                                 catch (Exception $e) {
                                 }
                                 echo "<div  class='input-group mb-2'>
                        <label class='input-group-text'>Secondary Address</label>
                        <input class='form-control' placeholder='{$_POST['2line1']},{$_POST['2line2']},{$_POST['2line3']}' name='address2' disabled>
                        <input name='addressText2' value = '{$_POST['2line1']},{$_POST['2line2']},{$_POST['2line3']}' hidden>
                        <input class='form-control' value='$address2ID' name='address2ID' hidden>
                        <input name='stage' value = '8' hidden>
                        <input type='submit' name='button2' value='x' class='btn btn-danger'>
                    </div>";
                               }
                               elseif ($_POST['stage'] == '8') {
                                 if ($_POST['button'] == 'x') {
                                   echo "<div  class='input-group mb-2'>
                        <label class='input-group-text'>Address</label>
                        <input class='form-control' placeholder='{$_POST['addressText2']}' name='address' disabled>
                        <input name='addressText' value = '{$_POST['addressText2']}' hidden>
                        <input class='form-control' value='$addressID' name='address2ID' hidden>
                        <input name='stage' value = '4' hidden>
                        <input type='submit' name='button' value='x' class='btn btn-danger'>
                       <input type='submit' name='button' value='Add' class='btn btn-success'> 
                    </div>";
                                 }
                                 elseif ($_POST['button2'] == 'x') {
                                   echo "<div  class='input-group mb-2'>
                        <label class='input-group-text'>Address</label>
                        <input class='form-control' placeholder='{$_POST['addressText']}' name='address' disabled>
                        <input name='addressText' value = '{$_POST['addressText']}' hidden>
                        <input class='form-control' value='$addressID' name='addressID' hidden>
                        <input name='stage' value = '4' hidden>
                        <input type='submit' name='button' value='x' class='btn btn-danger'>
                       <input type='submit' name='button' value='Add' class='btn btn-success'> 
                    </div>";
                                 }
                                 else {
                                   echo "<div  class='input-group mb-2'>
                        <label class='input-group-text'>Primary Address</label>
                        <input class='form-control' placeholder='{$_POST['addressText']}' name='address' disabled>
                        <input name='addressText' value = '{$_POST['addressText']}' hidden>
                        <input class='form-control' value='{$_POST['addressID']}' name='addressID' hidden>
                        <input type='submit' name='button' value='x' class='btn btn-danger'>
                    </div>
                    <div  class='input-group mb-2'>
                        <label class='input-group-text'>Secondary Address</label>
                        <input class='form-control' placeholder='{$_POST['addressText2']}' name='address' disabled>
                        <input name='addressText' value = '{$_POST['addressText2']}' hidden>
                        <input class='form-control' value='{$_POST['address2ID']}' name='addressID' hidden>
                        <input name='stage' value = '8' hidden>
                        <input type='submit' name='button2' value='x' class='btn btn-danger'>
                    </div>";
                                 }
                               }
                    ?>
                    <div class="mb-2">
                        <input class="btn btn-primary " type="submit" name='submit' value='Submit'>
                    </div>
                </form>
            </div>
          <hr>
            <button class="collapseBtn btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#viewTeachers">View Teachers</button><br>
            <div id="viewTeachers" class="collapse">
            <br>
                <table class="center">
                    <tr>
                    <th width="100px">ID<br><hr></th>
                    <th width="200px">First Name<br><hr></th>
                    <th width="200px">Last Name<br><hr></th>
                    <th width="250px">class<br><hr></th>
                    <th width="300px">salary<br><hr></th>
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
                // Select teacher from databse.    
                $sql = mysqli_query($link, "
                SELECT Teachers.personID,Persons.firstname, Persons.lastname, Teachers.className,
                Teachers.salary
                FROM Teachers 
                INNER JOIN Persons on Teachers.personID = Persons.personID;");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "
                    <tr>
                        <th>{$row['personID']}</th>
                        <th>{$row['firstname']}</th>
                        <th>{$row['lastname']}</th>
                        <th>{$row['className']}</th>
                        <th>£{$row['salary']}</th>
                        <th><form method='post' action='personinfo.php'><Input name='id' value='{$row['personID']}' hidden>
                        <Input name='role' value='Teacher' hidden>
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