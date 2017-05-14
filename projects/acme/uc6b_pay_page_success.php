<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>Paid for purchase</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
  </head>
  <body>
  <?php require_once ''. getcwd() . '/openDatabase.php';
  $query = $database->prepare(<<<'SQL'
  UPDATE AUCTION
      SET STATUS = 4
      WHERE AUCTION_ID = :auctionId;
SQL
  );
  $query->bindValue(':auctionId', $_POST['id'], PDO::PARAM_INT);
  $query->execute();
  $query->closeCursor();
?>
  <h1>Successfully paid for the purchase!</h1>
  <ul class="actionBar">
    <li><a href="uc5_close_auction.php">Return to your account</a></li>
    <li> <a href="index.php">Return to main menu</a></li>
  </ul>
  </body>
</html>
