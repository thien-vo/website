<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
  <title>Cancel auction</title>
  <meta charset="utf-8"/>
  <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
</head>
<?php

  require_once ''. getcwd() . '/openDatabase.php';
  $query = $database->prepare(<<<'SQL'
DELETE FROM AUCTION WHERE AUCTION_ID = :auctionId;
SQL
  );
  $query->bindValue(':auctionId', $_GET['id'], PDO::PARAM_INT);
  $query->execute();
  $query->closeCursor();
?>
  <body>
  <h1>Successfully cancelled the item!</h1>
  <ul class="actionBar">
    <li><a href="uc5_close_auction.php">Return to your account</a></li>
    <li> <a href="index.php">Return to main menu</a></li>
  </ul>
  </body>

</html>
