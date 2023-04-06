<?php 
// Start session and check if user is an admin
session_start();

if (!isset($_SESSION['loggedin'])) {
  header('Location: login.php?e=1');
  exit;
}
elseif ($_SESSION['role'] != 'admin'){
  header('Location: login.php?e=2');
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
              <li class="navbar-item"><a href="admin.php">Admin</a></li>
              <li class="navbar-item"><a href="contact.php">Contact</a></li>
              <li class='navbar-item'><a href='logout.php'>Logout</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
    <main class="container-fluid" style="text-align: center;">
      <p class="display-2"> Accounts</p><hr>
      <button class="collapseBtn btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#addAccounts">Add Accounts</button>
      <div id="addAccount" class="collapse show">
        <br>
        <form  method="post" action="addAccount.php">
          <div class="input-group mb-2">
            <label for="id" class="input-group-text"> Person ID</label>
            <input id="id" name="id" class="form-control" placeholder="ID" required type="number">
          </div>
          <div class="input-group mb-2">
            <label for="email" class="input-group-text"> Email</label>
            <input id="email" name="email" class="form-control" placeholder="Email" required>
          </div>
          <div class="input-group mb-2">
            <label for="password" class="input-group-text"> Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
          </div>
          <div class="mb-2">
            <label for="admin" class="btn btn-light">
              <input id="admin" name="admin" type="checkbox">
              <span class="ms-2">Admin</span></label>
          </div>
          <div class="mb-2">
            <button class="btn btn-primary" type="submit">Submit</button>
          </div>
        </form>
      </div>
      <hr>
      <button class="collapseBtn btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#viewAccounts">View Accounts</button>
      <div id="viewAccounts" class="collapse">
        <table class="center">
          <tr>
            <th width='100px'>ID<br><hr></th>
            <th width='250px'>Email<br><hr></th>
            <th width='150px'>Role<br><hr></th>
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
          // Select account and show them in a table
          $sql = mysqli_query($link, "SELECT personID, email, role FROM Accounts");

          while ($row = $sql->fetch_assoc()) {
            echo "
                    <tr>
                        <th>{$row['personID']}</th>
                        <th>{$row['email']}</th>
                        <th>{$row['role']}</th>
                        <th>
                        <form method='post' action='deleteAccount.php'><input name='delete' value='{$row['personID']}' hidden>
                        <button name='submit'>Delete</button>
                        </form>
                        </th>
                    </tr>";
          }

          ?>
        </table>
      </div>
    </main>
  </body>
</html>