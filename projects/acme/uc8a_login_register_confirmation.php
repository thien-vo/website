<?php
/*if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== "on") {
    header('HTTP/1.1 403 Forbidden: TLS Required');
    // Optionally output an error page here
    exit(1);

}*/

session_start();

require_once ''. getcwd() . '/openDatabase.php';

$emailAddress = $_POST['email'];
$rawPassword = $_POST['password'];

$personQuery = $database->prepare(<<<'SQL'
   SELECT PERSON_ID, PASSWORD, CONCAT(PERSON.FORENAME,' ',PERSON.SURNAME) AS SELLER
   FROM PERSON
   WHERE EMAIL_ADDRESS = :emailAddress;
SQL
);

$personQuery->bindValue(':emailAddress', $emailAddress, PDO::PARAM_STR);
$personQuery->execute();

$queryStatus = $personQuery->execute();

if ($queryStatus) {
    $personRow = $personQuery->fetch();
    $hashedPassword = password_hash($personRow['PASSWORD'],PASSWORD_DEFAULT);
    $authenticationSucceeded = password_verify($rawPassword, $hashedPassword);
} else {
    // E-mail address didn't match
    $authenticationSucceeded = false;
}

if ($authenticationSucceeded) {
    $_SESSION['authenticatedUser'] = $personRow['PERSON_ID'];
} else {
    unset($_SESSION['authenticatedUser']);
}

$personQuery->closeCursor();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title>Login</title>
    <meta charset="utf-8"/>
      <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
  </head>
  <body>
    <main id="content">
<?php
if ($_SESSION['authenticatedUser']) {
?>
    <!-- NAVIGATION BAR -->

    <ul class="navBar">
        <li id="logOut"><a  href="uc0_user_logout_confirmation.php">Log out</a></li>
        <li><a href="uc5_close_auction.php">My account</a></li>
    </ul>
    <header id="siteHeader">
        <h1><p>Welcome, <?= $personRow['SELLER'] ?>!</p></h1>
    </header>
  <ul class="actionBar">
    <li><a href="uc5_close_auction.php">Return to your account</a></li>
  </ul>
<?php
} else {
?>
    <!-- NAVIGATION BAR -->

    <ul class="navBar">
        <li><a href="index.php">Main menu</a></li>
    </ul>
    <header id="siteHeader">
        <h1><p>Wrong email address or password!</p></h1>
    </header>
    <button type="button" onclick="history.back();">Go back</button>
<?php
}
?>
    </main>
  </body>
</html>
