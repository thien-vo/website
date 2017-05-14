<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>Bidding</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
  </head>
  <body>
  <!-- NAVIGATION BAR -->

    <ul class="navBar">
      <li id="logOut"><a  href="uc0_user_logout_confirmation.php">Log out</a></li>
      <li><a href="uc5_close_auction.php">My account</a></li>
      <li><a href="uc3_find_listing.php">Find auctions</a></li>
    </ul>
  <?php require_once ''. getcwd() . '/openDatabase.php';
  $query = $database->prepare(<<<'SQL'
    SELECT
        AUCTION.OPEN_TIME,
        AUCTION.CLOSE_TIME,
        AUCTION.CURRENT_PRICE,
        ITEM_CATEGORY.NAME AS ITEM_CATEGORY,
        AUCTION.ITEM_CAPTION,
        AUCTION.ITEM_DESCRIPTION
        FROM AUCTION
          JOIN ITEM_CATEGORY ON AUCTION.ITEM_CATEGORY = ITEM_CATEGORY.ITEM_CATEGORY_ID
        WHERE AUCTION.AUCTION_ID = :auctionId;
SQL
  );
  $query->bindValue(':auctionId', $_GET['id'], PDO::PARAM_INT);
  $query->execute();
  $auction = $query->fetch();
  $id = $_GET['id'];
  $query->closeCursor();
  ?>
  <h1>Are you sure to place a <strong class="money"/>$<?= $_GET['bid'] ?> </strong>  bid for the following auction:</h1>
  <table style="width:100%">
    <tr>
      <th>Item Name</th>
      <th>Description</th>
      <th>Open time</th>
      <th>Close time</th>
      <th>Current price</th>
    </tr>
    <tr>
      <td><?= htmlspecialchars($auction['ITEM_CAPTION']) ?></td>
      <td><p><?= htmlspecialchars($auction['ITEM_DESCRIPTION'] )?><br></br>
          Category: <?= htmlspecialchars($auction['ITEM_CATEGORY']) ?><br></br>
        </p></td>
      <td><?= htmlspecialchars($auction['OPEN_TIME']) ?></td>
      <td><?= htmlspecialchars($auction['CLOSE_TIME']) ?></td>
      <td>$<?= htmlspecialchars($auction['CURRENT_PRICE']) ?></td>
    </tr>
  </table>
  <form class="cancel" action="uc4b_bid_success.php">
    <input type="submit" value="Yes" />
    <input type="hidden" name="id" value="<?= $id ?>" />
    <input type="hidden" name="bid" value="<?= $_GET['bid'] ?>" />
    <button type="button" onclick="history.back();">Go back </button>
  </form>
  </body>
</html>
