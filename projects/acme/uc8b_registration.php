<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>Registration</title>
    <meta charset="utf-8"/>
      <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
  </head>
  <body>
  <!-- NAVIGATION BAR -->

      <ul class="navBar">
          <li> <a href="index.php">Main menu</a></li>
          <li id="logIn"><a href="uc8a_login_register.php">Log in</a></li>
      </ul>


  <h1>Acme Auction Registration</h1>
  
  <section><h2>Please enter the follow information:</h2>
  <form action ="uc8c_registration_success.php" method="post">
	First name:  <input type="text" name="forename" required/> <br></br>
	Last name:  <input type="text" name="surname" required/> <br></br>
	Email:  <input type="email" name="email" required/><br></br>
	Password:  <input type="password" name="password" required/> <br></br>
      <button type="reset" value="reset">Clear</button>
  <br></br>
  <section class="importantRequirements">
  <header><h2>Terms and Conditions</h2></header>
  <textarea rows="5" cols="100">By reading and register an account with Acme Auction, you agree to the following rules:
      1. You will not post an item of which you don't have possession of
      2. You will not post, list or upload content or items in inappropriate categories or areas on our sites
      Any violation of Terms and Conditions will result in termination of your account and possible legal prosecution.
  </textarea>
      <input type="submit" value="Agree to Terms and Conditions and Register" /><br></br>
      <button type="submit" formaction="index.php" value="cancel">Go back to main menu</button>
  </section>
      </section>
  </body>
</html>
