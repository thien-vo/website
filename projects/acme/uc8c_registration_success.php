<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>Registration success</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
  </head>
  <body>
  <!-- NAVIGATION BAR -->

  <ul class="navBar">
    <li> <a href="index.php">Main menu</a></li>
    <li id="logIn"><a href="uc8a_login_register.php">Log in</a></li>
  </ul>
  <?php require_once ''. getcwd() . '/openDatabase.php';
  /* CHECK FOR DUPLICATE */
  $query = $database->prepare(<<<'SQL'
  SELECT EMAIL_ADDRESS FROM PERSON WHERE EMAIL_ADDRESS = :email;
SQL
  );
  $query->bindValue(':email',$_POST['email'], PDO::PARAM_STR);
  $query->execute();
  $empty = $query->rowCount();
  $query->closeCursor();
  if($empty){
    ?>
    <h1>The email address you've entered has already been used!<br></br> Please use another email address!</h1>
    <button type="button" onclick="history.back();">Go back</button>
  <?php
  }
  else {
    $newIdQuery = $database->prepare('SELECT NEXT_SEQ_VALUE(:seqGenName);');
    $newIdQuery->bindValue(':seqGenName', 'PERSON', PDO::PARAM_STR);
    $newIdQuery->execute();
    $newId = $newIdQuery->fetchColumn(0);
    $newIdQuery->closeCursor();

    $query = $database->prepare(<<<'SQL'
  INSERT INTO PERSON
      (PERSON_ID, SURNAME, FORENAME, PASSWORD, EMAIL_ADDRESS)
         VALUES (:id, :surname, :forename, :pass, :email);
SQL
    );
    $query->bindValue(':id', $newId, PDO::PARAM_INT);
    $query->bindValue(':surname', $_POST['surname'], PDO::PARAM_STR);
    $query->bindValue(':forename', $_POST['forename'], PDO::PARAM_STR);
    $query->bindValue(':pass', $_POST['password'], PDO::PARAM_STR);
    $query->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $query->execute();
    $query->closeCursor();
    ?>
    <h1>Successfully registered!</h1>
    <ul class="actionBar">
      <li><a href="index.php"> Return to main menu</a></li>
      <li><a href="uc8a_login_register.php">Login now</a></li>
    </ul>
    <?php
  }
  ?>
  </body>
</html>
