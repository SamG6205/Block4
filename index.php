<?php
// Get session info
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Rishton Academy Home</title>
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
                          // If user is logged in show restriced pages
                          if (isset($_SESSION['loggedin'])) {
                            echo "
                            <li class='navbar-item'><a href='index.php'>Home</a></li>
                            <li class='navbar-item'><a href='student.php'>Student</a></li>
                            <li class='navbar-item'><a href='parent.php'>Parent</a></li>
                            <li class='navbar-item'><a href='teacher.php'>Teacher</a></li>
                            <li class='navbar-item'><a href='classes.php'>Class</a></li>
                            <li class='navbar-item'><a href='library.php'>Library</a></li>";
                            // If user is an admin show admin page
                            if ($_SESSION['role'] == 'admin') {
                              echo "<li class='navbar-item'><a href='admin.php'>Admin</a></li>";
                            }
                            echo "
                            <li class='navbar-item'><a href='contact.php'>Contact</a></li>
                            <li class='navbar-item'><a href='logout.php'>Logout</a></li>
                            ";
                          } else {
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
        <main class="container">
            <p class="display-2 text-center"> Welcome to Rishton Academy</p><br>
          <p class="text-center display-6">
            Login to access the records in the webportal.
          </p><br>
          <p class="lead text-center" style="font-size:1.5rem">
            Welcome to Rishton Academy Primary School's web portal! We are delighted that you have chosen to visit our website and learn more about our school.
<br><br>
Rishton Academy is a vibrant and welcoming primary school located in the heart of our community. Our school is a place where children are encouraged to discover, learn, and grow in a nurturing and supportive environment.
<br><br>
At Rishton Academy, we are committed to providing an excellent education for all of our pupils. We believe that every child is unique and has something special to offer. Our dedicated and experienced staff work hard to create a positive and inclusive learning environment that caters to the individual needs of each child.
<br><br>
Our curriculum is designed to challenge and inspire our pupils, with a focus on developing key skills in literacy, numeracy, and critical thinking. We also place a strong emphasis on creativity, physical development, and personal, social, and emotional wellbeing.
<br><br>
We are proud of our school community, and we work closely with parents and carers to ensure that our pupils receive the best possible support and guidance. We believe that education is a partnership, and we value the input and involvement of parents and carers in their child's learning journey.
<br><br>
Thank you for visiting our web portal. We hope that you find the information you are looking for, and we look forward to welcoming you to our school community.
          </p>
        </main>
    </body>
</html>