<?php
  session_start();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>Bidding success</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
  </head>
  <?php require_once ''. getcwd() . '/openDatabase.php';
  $personID = $_SESSION['authenticatedUser'];
  $query2 = $database->prepare(<<<'SQL'
  SELECT
    SELLER
    FROM AUCTION
    WHERE AUCTION_ID = :auctionId;

SQL
  );
  $query2->bindValue(':auctionId', $_GET['id'], PDO::PARAM_INT);
  $query2->execute();
  $seller = $query2->fetch();
  $query2->closeCursor();
  $sellerID = $seller['SELLER'];
  $bidSuc = 1;
  if($sellerID == $personID)
    $bidSuc = 0;
  else{
  $query = $database->prepare(<<<'SQL'
  UPDATE AUCTION
      SET CURRENT_PRICE = :price, WINNER_ID = :personID
      WHERE AUCTION_ID = :auctionId;
SQL
  );
  $query->bindValue(':auctionId', $_GET['id'], PDO::PARAM_INT);
  $query->bindValue(':personID', $personID, PDO::PARAM_INT);
  $query->bindValue(':price', $_GET['bid'], PDO::PARAM_INT);
  $query->execute();
  $query->closeCursor();}
  ?>
  <!-- NAVIGATION BAR -->

  <ul class="navBar">
    <li id="logOut"><a  href="uc0_user_logout_confirmation.php">Log out</a></li>
    <li><a href="uc5_close_auction.php">My account</a></li>
    <li><a href="uc3_find_listing.php">Find auctions</a></li>
  </ul>
  <body>
  <?php
  if($bidSuc == 1) {
    ?>
    <h1>Successfully placed a bid for the item!</h1>
    <ul class="actionBar">
      <li><a href="uc5_close_auction.php">Return to your account</a></li>
    </ul>
    <?php
  } else {
    ?>
    <h1>You can't bid on your own auction!</h1>
    <ul class="actionBar">
      <li><a href="uc5_close_auction.php">Return to your account</a></li>
    </ul>
    <?php
  }
  ?>
  </body>
</html>
