<?php
/*if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== "on") {
    header('Location: https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
    exit(1);
}*/
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>Login/ Register</title>
    <meta charset="utf-8"/>
      <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
  </head>
  <body>
  <!-- NAVIGATION BAR -->

      <ul class="navBar">
          <li> <a href="index.php">Main menu</a></li>
      </ul>

  <section>
  <h1>Please login to continue:</h1>
	<form action="uc8a_login_register_confirmation.php" method="post" enctype="multipart/form-data">
        Email Address:<br></br>
        <input type="email" name="email" required/> <br></br>
        Password:<br></br>
        <input type="password" name="password" required/> <br></br>
        <input type="submit" value="Login" />
        <button type="reset" value="reset">Clear</button>
	</form>
  </section>

  <section>
      <h1>Don't have an account? <a href="uc8b_registration.php">Register now!</a></h1>
  </section>
  </body>
</html>
