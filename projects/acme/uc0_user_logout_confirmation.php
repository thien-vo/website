<?php
  session_start();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Successfully log out!</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
</head>
<body>
<?php
    unset($_SESSION['authenticatedUser']);
?>
<!-- NAVIGATION BAR -->

<ul class="navBar">
    <li><a href="index.php">Main menu</a></li>
</ul>
<h1>Successfully log out!</h1>
<ul class="actionBar">
    <li><a href="index.php">Return to main menu</a></li>
    <li><a href="uc8a_login_register.php">Log in</a></li>
</ul>
</body>
</html>