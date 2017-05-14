<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html" xml:lang="en">
  <head>
    <title>Registration</title>
    <meta charset="utf-8"/>
      <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
  </head>
  <body>
  <!-- NAVIGATION BAR -->
      <ul class="navBar">
          <li> <a href="index.php">Main menu</a></li>
          <li> <a href="uc5_close_auction.php">My account</a></li>
          <li id="logIn"><a href="uc8a_login_register.php">Log in</a></li>
      </ul>

  <?php require_once ''. getcwd() . '/openDatabase.php';
  $query = $database->prepare(<<<'SQL'
    SELECT
        AUCTION.STATUS,
        AUCTION.OPEN_TIME,
        AUCTION.CLOSE_TIME,
        AUCTION.CURRENT_PRICE,
        ITEM_CATEGORY.NAME AS ITEM_CATEGORY,
        CONCAT(PERSON.FORENAME,' ',PERSON.SURNAME) AS SELLER,
        PERSON.EMAIL_ADDRESS AS CONTACT,
        AUCTION.ITEM_CAPTION,
        AUCTION.ITEM_DESCRIPTION
        FROM AUCTION
          JOIN ITEM_CATEGORY ON AUCTION.ITEM_CATEGORY = ITEM_CATEGORY.ITEM_CATEGORY_ID
          JOIN PERSON ON AUCTION.SELLER = PERSON.PERSON_ID
        WHERE AUCTION.AUCTION_ID = :auctionId;
SQL
  );
  $query->bindValue(':auctionId', $_GET['id'], PDO::PARAM_INT);
  $query->execute();
  $auction = $query->fetch();
  $query->closeCursor();
  ?>

  <section><h1 class="itemTitle"><?= htmlspecialchars($auction['ITEM_CAPTION']) ?></h1>
  <p>
      <span class="detailDescp"><?= htmlspecialchars($auction['ITEM_DESCRIPTION']) ?> <br></br>
          <?php echo '<img src="auctionPhoto.php?id=' . urlencode($_GET['id']) . '" />' ?></span><br></br>
      <strong>Open time: </strong> <?= htmlspecialchars($auction['OPEN_TIME']) ?><br></br>
      <strong>Close time: </strong> <?= htmlspecialchars($auction['CLOSE_TIME'] )?><br></br>
      <strong>Category: </strong> <?= htmlspecialchars($auction['ITEM_CATEGORY']) ?><br></br>
      <strong>Current price:</strong> $<?= htmlspecialchars($auction['CURRENT_PRICE']) ?><br></br>
      <strong>Seller: </strong><?= htmlspecialchars($auction['SELLER']) ?><br></br>
      <strong>Contact seller: </strong> <?= htmlspecialchars($auction['CONTACT']) ?>
  </p>

  </section>

  <button type="button" onclick="history.back();">Go back</button>

  </section>
  </body>
</html>
