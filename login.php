<?php
// Start session to get session information
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Rishton Academy Contact</title>
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
                            <?php
                          // If logged in show restricted pages
                          if (isset($_SESSION['loggedin'])) {
                            echo "
                            <li class='navbar-item'><a href='index.php'>Home</a></li>
                            <li class='navbar-item'><a href='student.php'>Student</a></li>
                            <li class='navbar-item'><a href='parent.php'>Parent</a></li>
                            <li class='navbar-item'><a href='teacher.php'>Teacher</a></li>
                            <li class='navbar-item'><a href='classes.php'>Class</a></li>
                            <li class='navbar-item'><a href='library.php'>Library</a></li>
                            <li class='navbar-item'><a href='contact.php'>Contact</a></li>
                            <li class='navbar-item'><a href='logout.php'>Logout</a></li>
                            ";
                          } else {
                            // Else show non restricted pages.
                            echo "
                            <li class='navbar-item'><a href='index.php'>Home</a></li>
                            <li class='navbar-item'><a href='contact.php'>Contact</a></li>
                            <li class='navbar-item'><a href='login.php'>Login</a></li>
                            ";
                          }
                          ?>
                        </ul>
                  </div>
              </div>
          </nav>
      </div>
      <main class="container-fluid" style="text-align: center;">
        <p class="display-2"> Login</p>
        <?php 
        // Display error message
        if ($_GET['e'] == '1') {
          echo "<div class='alert alert-danger' style='padding: 3px;'>
  <strong>Error!</strong> Incorrect username or password.
</div>";
        }
        ?>
        <form method="post" action="authenticate.php">
          <div class="input-group mb-2">
            <label for="email" class="input-group-text"> Email</label>
            <input id="email" name="email" class="form-control" placeholder="Email" required>
          </div>
          <div class="input-group mb-2">
            <label for="password" class="input-group-text"> Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
          </div>
          <div class="mb-2">
            <button class="btn btn-primary">Login</button>
          </div>
        </form>
      </main>
  </body>
</html>