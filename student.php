<?php 
// Create session to store session information server side.
session_start();

// Check user is logged into an account
if (!isset($_SESSION['loggedin'])) {
  // If not logged in send to login.php with error
	header('Location: login.php?e=1');
	exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Rishton Academy Students</title>
      <!-- Link to Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
      <!-- Link to CSS files -->
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
  // If user is an admin show the admin button in navbar
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
      <!-- Bootstrap collapse button -->
      <!--  Made referencing https://www.w3schools.com/bootstrap5/bootstrap_collapse.php -->
        <main class="container-fluid" style="text-align: center;">
            <p class="display-2"> Students</p>
          <hr>
            <button class="collapseBtn mb-2 btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#addStudent">Add Student</button><br>
            <div id="addStudent" class="collapse show">
              
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
              // Check submit button was press
              if ($_POST['submit'] == 'Submit') {
                // Check required fields aren't empty
                if (strlen($_POST['fname']) >0 and strlen($_POST['lname'])>0) {
                  if (strlen($_POST['medical']) >0) {
                    if (strlen($_POST['class']) >0) {
                    if (strlen($_POST['addressID'])>0) {
                      // Add person to databse
                      $sql = "INSERT INTO Persons (firstname,lastname) VALUES ('{$_POST['fname']}','{$_POST['lname']}')";
                      try {
                        if (mysqli_query($link, $sql)) {
                          $person = mysqli_insert_id($link);
                          // Add person to student table
                          $sql = "INSERT INTO Students (personID ,className, medicalInfo) VALUES ('$person' ,'{$_POST['class']}','{$_POST['medical']}')";
                          if (mysqli_query($link, $sql)){
                            $student = mysqli_insert_id($link);
                            // Connect person with address
                            $sql = "INSERT INTO Residents (addressID, personID, `primary`) VALUES ('{$_POST['addressID']}','$person', '1')";
                            if (mysqli_query($link, $sql)){
                              if (isset($_POST['address2ID'])) {
                                // Connect with second address if applicable
                                $sql = "INSERT INTO Residents (addressID, personID, `primary`) VALUES ('{$_POST['address2ID']}','$person', '0')";
                                if (mysqli_query($link, $sql)){
                                  // Echo javascript code to refresh page with an error code
                                  // PHP redirect doesn't work if content has been displayed
                                  echo "<script>window.location.href='student.php?s=1';</script>";
                                }
                              }
                              else {
                                echo "<script>window.location.href='student.php?s=1';</script>";
                              }
                            }
                          }  
                        } else {
                          echo("SQL Error");
                        } 
                      }
                      catch (Exception $e) {
                        echo("SQL Error");
                      }

                    }
                      // Tell user if their was an error
                      else {
                        echo "<div class='alert alert-danger' style='padding: 3px;'>
  <strong>Error!</strong> Address required. </div>";
                      }
                    }
                      else {
                      echo "<div class='alert alert-danger' style='padding: 3px;'>
  <strong>Error!</strong> Class required. </div>";
                    }
                  }
                  else {
                    echo "<div class='alert alert-danger' style='padding: 3px;'>
  <strong>Error!</strong> Medical Information required. </div>";
                  }
                }
                else {
                  echo "<div class='alert alert-danger' style='padding: 3px;'>
  <strong>Error!</strong> First name and Last name required. </div>";
                }       
              }
              // If successful tell user
              if ($_GET['s']=='1') {
                echo "<div class='alert alert-success' style='padding: 3px;'>
  <strong>Success!</strong> Student added to database. </div>";
              }
              if (!isset($_POST['button']) and !isset($_POST['button2'])) {
                if (($_POST['stage'] != 8) and ($_POST['stage']>0)) {
                  $_POST['stage'] -= 1;
                }
              }
              ?>
              <div class='alert alert-warning' style='padding: 3px;'>
  <strong>Warning!</strong> Parents should be added before the student. </div>
                <form  action="student.php" method='post'>
                  <!-- PHP Used in form to remeber data if it was submitted if their was an error adding to database -->
                    <div class="input-group mb-2">
                        <label for="fname" class="input-group-text"> Name</label>
                        <input id="fname" name="fname" class="form-control" placeholder="First name" value="<?php echo $_POST['fname']??''; ?>" required>
                        <input id="lname" name="lname" class="form-control" placeholder="Last name" value="<?php echo $_POST['lname']??''; ?>" required>
                    </div>
                    <div class="input-group mb-2">
                        <label for="medical" class="input-group-text"> Medical <br>Information</label>
                        <textarea id="medical" name="medical" type="text" class="form-control" placeholder="Medical information" required><?php echo $_POST['medical']??''; ?></textarea>
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
                  </div>
                  <?php
                  // Shows input first input for address
                  if (!isset($_POST['stage']) or ($_POST['stage'] == 0)) {
                    echo "<div class='input-group mb-2'>
                        <label class='input-group-text'>Postcode</label>
                        <input class='form-control' name='postcode' placeholder='House Postcode'>
                        <input name='stage' value = '1' hidden>
                        <input class='btn btn-success' type='submit' name='button' value='Find'>
                    </div>";
                  }
                  // Shows dropdown of all addressing matching the postcode.
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
                    // Show Inputs to add new address
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
                    // Show full address with add button for second address.
                    if (isset($_POST['addressText'])) {
                      echo "<div  class='input-group mb-2'>
                        <label class='input-group-text'>Address</label>
                        <input class='form-control' placeholder='{$_POST['addressText']}' name='address' disabled>
                        <input name='addressText' value = '{$_POST['addressText']}' hidden>
                        <input class='form-control' value='{$_POST['addressID']}' name='addressID' hidden>
                        <input name='stage' value = '4' hidden>
                        <input type='submit' name='button' value='x' class='btn btn-danger'>
                       <input type='submit' name='button' value='Add' class='btn btn-success'> 
                    </div>";
                    }
                    else {
                      // Add address if new address submitted.
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
                  }
                  elseif ($_POST['stage'] == '4') {
                    // Show input for second address
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
                    // Show dropdown for second address
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
                    // Show new address inputs for second address.
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
                    // Insert second address into database if new.
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
                    // Show both addresses
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
                  <?php
                  if (isset($_POST['findParent1'])) {
                    // PHP for find first parent from input
                    $FName = $_POST['p1FName'];
                    $LName = $_POST['p1LName'];
                    
                    echo "<div class='input-group mb-2'> <label class='input-group-text'>Parent/Guardian Primary</label>
                    <select class='form-control' name='parent1ID'>
                    <option value='0' hidden> Select Parent </option>";
                    
                    $sql = mysqli_query($link, "SELECT Persons.personID, Persons.firstname, Persons.lastname, Parents.email, Parents.mobile FROM Parents
INNER JOIN Persons ON Parents.personID = Persons.personID
WHERE Persons.firstname = '$FName'
AND Persons.lastname = '$LName'");
                    
                    while ($row = $sql->fetch_assoc()) {
                      echo "<option value='{$row['personID']}'>{$row['firstname']}, {$row['lastname']}, {$row['email']}, {$row['mobile']}</option>";
                    }
                      echo "</select><input type='submit' name='selectP1' value='Select' class='btn btn-success'></div>";
                      
                  }
                  elseif (isset($_POST['selectP1'])) {
                    $P1ID = $_POST['parent1ID'];
                      
                    $sql =  mysqli_query($link, "SELECT Persons.firstname, Persons.lastname, Parents.email, Parents.mobile FROM Parents
INNER JOIN Persons ON Parents.personID = Persons.personID WHERE Persons.personID = $P1ID");
                      
                    $row = $sql->fetch_assoc();
                      
                    echo "<div class='input-group mb-2'>
                        <label class='input-group-text'>Parent/Guardian Primary</label>
                        <input class='form-control' name='parent1' value='{$row['firstname']}, {$row['lastname']}, {$row['email']}, {$row['mobile']}' disabled>
                        <input name='person1ID' value='$P1ID' hidden>
                        <input name='parent1text' value='{$row['firstname']}, {$row['lastname']}, {$row['email']}, {$row['mobile']}' hidden>
                        <input type='submit' name='deleteP1' value='x' class='btn btn-danger'>
                    </div>"; 
                  }
                  elseif (isset($_POST['deleteP1'])) {
                    $p1F = $_POST['p1FName']??'';
                    $p1L = $_POST['p1LName']??'';
                    echo "<div class='input-group mb-2'>
                        <label class='input-group-text'>Parent/Guardian Primary</label>
                        <input class='form-control' placeholder='First name' name='p1FName' value='$p1F'>
                        <input class='form-control' placeholder='Last name' name='p1LName' value='$p1L'>
                        <input type='submit' name='findParent1' value='Find' class='btn btn-success'>
                    </div>";
                  }
                  elseif ($_POST['person1ID']>0) {
                    echo "<div class='input-group mb-2'>
                        <label class='input-group-text'>Parent/Guardian Primary</label>
                        <input class='form-control' name='parent1' value='{$_POST['parent1text']}' disabled>
                        <input name='person1ID' value='{$_POST['person1ID']}' hidden>
                        <input name='parent1text' value='{$_POST['parent1text']}' hidden>
                        <input type='submit' name='deleteP1' value='x' class='btn btn-danger'>
                    </div>"; 
                  }
                  else {
                    $p1F = $_POST['p1FName']??'';
                    $p1L = $_POST['p1LName']??'';
                    echo "<div class='input-group mb-2'>
                        <label class='input-group-text'>Parent/Guardian Primary</label>
                        <input class='form-control' placeholder='First name' name='p1FName' value='$p1F'>
                        <input class='form-control' placeholder='Last name' name='p1LName' value='$p1L'>
                        <input type='submit' name='findParent1' value='Find' class='btn btn-success'>
                    </div>";
                  }
                  ?>
                  <?php
                  // PHP for searching for second parent.
                  if (isset($_POST['findParent2'])) {
                    $FName = $_POST['p2FName'];
                    $LName = $_POST['p2LName'];
                    
                    echo "<div class='input-group mb-2'> <label class='input-group-text'>Parent/Guardian Secondary</label>
                    <select class='form-control' name='parent2ID'>
                    <option value='0' hidden> Select Parent </option>";
                    
                    $sql = mysqli_query($link, "SELECT Persons.personID, Persons.firstname, Persons.lastname, Parents.email, Parents.mobile FROM Parents
INNER JOIN Persons ON Parents.personID = Persons.personID
WHERE Persons.firstname = '$FName'
AND Persons.lastname = '$LName'");
                    
                    while ($row = $sql->fetch_assoc()) {
                      echo "<option value='{$row['personID']}'>{$row['firstname']}, {$row['lastname']}, {$row['email']}, {$row['mobile']}</option>";
                    }
                      echo "</select><input type='submit' name='selectP2' value='Select' class='btn btn-success'></div>";
                      
                  }
                  elseif (isset($_POST['selectP2'])) {
                    $P2ID = $_POST['parent2ID'];
                      
                    $sql =  mysqli_query($link, "SELECT Persons.firstname, Persons.lastname, Parents.email, Parents.mobile FROM Parents
INNER JOIN Persons ON Parents.personID = Persons.personID WHERE Persons.personID = $P2ID");
                      
                    $row = $sql->fetch_assoc();
                      
                    echo "<div class='input-group mb-2'>
                        <label class='input-group-text'>Parent/Guardian Secondary</label>
                        <input class='form-control' name='parent2' value='{$row['firstname']}, {$row['lastname']}, {$row['email']}, {$row['mobile']}' disabled>
                        <input name='person2ID' value='$P2ID' hidden>
                        <input name='parent2text' value='{$row['firstname']}, {$row['lastname']}, {$row['email']}, {$row['mobile']}' hidden>
                        <input type='submit' name='deleteP2' value='x' class='btn btn-danger'>
                    </div>"; 
                  }
                  elseif (isset($_POST['deleteP2'])) {
                    $p2F = $_POST['p2FName']??'';
                    $p2L = $_POST['p2LName']??'';
                    echo "<div class='input-group mb-2'>
                        <label class='input-group-text'>Parent/Guardian Secondary</label>
                        <input class='form-control' placeholder='First name' name='p2FName' value='$p2F'>
                        <input class='form-control' placeholder='Last name' name='p2LName' value='$p2L'>
                        <input type='submit' name='findParent2' value='Find' class='btn btn-success'>
                    </div>";
                  }
                  elseif ($_POST['person2ID']>0) {
                    echo "<div class='input-group mb-2'>
                        <label class='input-group-text'>Parent/Guardian Secondary</label>
                        <input class='form-control' name='parent2' value='{$_POST['parent2text']}' disabled>
                        <input name='person2ID' value='{$_POST['person2ID']}' hidden>
                        <input name='parent2text' value='{$_POST['parent2text']}' hidden>
                        <input type='submit' name='deleteP2' value='x' class='btn btn-danger'>
                    </div>"; 
                  }
                  else {
                    $p2F = $_POST['p2FName']??'';
                    $p2L = $_POST['p2LName']??'';
                    echo "<div class='input-group mb-2'>
                        <label class='input-group-text'>Parent/Guardian Secondary</label>
                        <input class='form-control' placeholder='First name' name='p2FName' value='$p2F'>
                        <input class='form-control' placeholder='Last name' name='p2LName' value='$p2L'>
                        <input type='submit' name='findParent2' value='Find' class='btn btn-success'>
                    </div>";
                  }
                  ?>
                    <div class="mb-2">
                        <input class="btn btn-primary" type="submit" name='submit' value='Submit'>
                    </div>
                </form>
            </div>
          <hr>
            <button class="collapseBtn btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#viewStudents">View Students</button><br>
            <div id="viewStudents" class="collapse">
            <br>
                <table class="center">
                    <tr>
                    <th width="100px">ID<br><hr></th>
                    <th width="200px">First Name<br><hr></th>
                    <th width="200px">Last Name<br><hr></th>
                    <th width="250px">Class<br><hr></th>
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
                // Select student from database and display in the table    
                $sql = mysqli_query($link, "
                SELECT Students.personID,Persons.firstname, Persons.lastname, Students.className
                FROM Students 
                INNER JOIN Persons on Students.personID = Persons.personID;");
                
                while ($row = $sql->fetch_assoc()) {
                    echo "
                    <tr>
                        <th>{$row['personID']}</th>
                        <th>{$row['firstname']}</th>
                        <th>{$row['lastname']}</th>
                        <th>{$row['className']}</th>
                        <th><form method='post' action='personinfo.php'><Input name='id' value='{$row['personID']}' hidden>
                        <Input name='role' value='Student' hidden>
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