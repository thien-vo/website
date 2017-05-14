<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>Browse auctions</title>
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


  <h1 class="singleHeading">Search result:</h1>
  <?php require_once ''. getcwd() . '/openDatabase.php';
  $id = $_GET['searchID'];
  /*Keywords*/
  if($id == 1){
  $query = $database->prepare(<<<'SQL'
    SELECT
        AUCTION.AUCTION_ID,
        AUCTION.OPEN_TIME,
        AUCTION.CLOSE_TIME,
        AUCTION.CURRENT_PRICE,
        ITEM_CATEGORY.NAME AS ITEM_CATEGORY,
        AUCTION.ITEM_CAPTION,
        AUCTION.ITEM_DESCRIPTION
        FROM AUCTION
          JOIN ITEM_CATEGORY ON AUCTION.ITEM_CATEGORY = ITEM_CATEGORY.ITEM_CATEGORY_ID
        WHERE AUCTION.ITEM_CAPTION LIKE :caption AND AUCTION.STATUS = 1;
SQL
  );
      $query->bindValue(':caption','%' . $_GET['caption'] . '%', PDO::PARAM_STR);
  }
  /*Seller*/
  if($id == 2){
      $query = $database->prepare(<<<'SQL'
    SELECT
        AUCTION.AUCTION_ID,
        AUCTION.OPEN_TIME,
        AUCTION.CLOSE_TIME,
        AUCTION.CURRENT_PRICE,
        ITEM_CATEGORY.NAME AS ITEM_CATEGORY,
        AUCTION.ITEM_CAPTION,
        AUCTION.ITEM_DESCRIPTION,
        CONCAT(PERSON.FORENAME,' ',PERSON.SURNAME) AS SELLER
        FROM AUCTION
          JOIN ITEM_CATEGORY ON AUCTION.ITEM_CATEGORY = ITEM_CATEGORY.ITEM_CATEGORY_ID
          JOIN PERSON ON AUCTION.SELLER = PERSON.PERSON_ID
        WHERE PERSON.SURNAME LIKE :seller AND AUCTION.STATUS = 1
        OR PERSON.FORENAME LIKE :seller AND AUCTION.STATUS = 1;
SQL
      );
      $query->bindValue(':seller','%' . $_GET['seller'] . '%', PDO::PARAM_STR);
  }
  if($id == 3){
      $query = $database->prepare(<<<'SQL'
    SELECT
        AUCTION.AUCTION_ID,
        AUCTION.OPEN_TIME,
        AUCTION.CLOSE_TIME,
        AUCTION.CURRENT_PRICE,
        ITEM_CATEGORY.NAME AS ITEM_CATEGORY,
        AUCTION.ITEM_CAPTION,
        AUCTION.ITEM_DESCRIPTION
        FROM AUCTION
          JOIN ITEM_CATEGORY ON AUCTION.ITEM_CATEGORY = ITEM_CATEGORY.ITEM_CATEGORY_ID
        WHERE AUCTION.ITEM_CATEGORY = :category AND AUCTION.STATUS = 1;
SQL
      );
      $query->bindValue(':category',$_GET['category'], PDO::PARAM_INT);
  }
  if($id == 4){
      $query = $database->prepare(<<<'SQL'
    SELECT
        AUCTION.AUCTION_ID,
        AUCTION.OPEN_TIME,
        AUCTION.CLOSE_TIME,
        AUCTION.CURRENT_PRICE,
        ITEM_CATEGORY.NAME AS ITEM_CATEGORY,
        AUCTION.ITEM_CAPTION,
        AUCTION.ITEM_DESCRIPTION
        FROM AUCTION
          JOIN ITEM_CATEGORY ON AUCTION.ITEM_CATEGORY = ITEM_CATEGORY.ITEM_CATEGORY_ID
        WHERE AUCTION.CURRENT_PRICE BETWEEN :low AND :high AND AUCTION.STATUS = 1;
SQL
      );
      $query->bindValue(':low',$_GET['low'], PDO::PARAM_INT);
      $query->bindValue(':high',$_GET['high'], PDO::PARAM_INT);
  }
  $query->execute();
  $rows = $query->rowCount();
  $auction = $query->fetchAll();
  $query->closeCursor();
  ?>

  <section>
    <!-- <p class="optional"> View option: <select>
      <option value="recent">Most recent</option>
      <option value="seller">By seller</option>
      <option value="category">By catergory</option>
      </select>
      </p> -->
      <?php
      if($rows == 0)
          echo 'No matches found';
      else{
      echo '<table style="width:100%">';
      echo '<tr>';
      echo '<th>Item Name</th>';
      echo '<th>Description</th>';
      echo '<th>Open Time</th>';
      echo '<th>Closing Time</th>';
      echo '<th>Current Price</th>';
      echo '<th></th>';
      echo '</tr>';

          $count = 0;
          while($count < $rows){
              $id = $auction[$count][0];
              $bid = $auction[$count][3] + 1;
              echo '<tr>';
              echo '<td>' . htmlspecialchars($auction[$count][5]);
              echo '<br></br>';
              echo '<a href="uc3_auction_detail.php?id=' . urlencode($id) . '">More details</a>' . '</td>'; /*Item name*/
              echo '<td>' . htmlspecialchars($auction[$count][6]);
              echo '<br></br>';
              echo 'Category: ' . htmlspecialchars($auction[$count][4]) . '</td>'; /*Description*/
              echo '<td>' . htmlspecialchars($auction[$count][1]) . '</td>';/*Open Time*/
              echo '<td>' . htmlspecialchars($auction[$count][2]) . '</td>';/*Closing Time*/
              echo '<td>$' . htmlspecialchars($auction[$count][3]) . '</td>';/*Current price*/
              echo '<td><form action="uc4a_bid_page.php" method="get">';
              echo '$<input type="number" name="bid" min ="' . htmlspecialchars($bid) . '" value="'. htmlspecialchars($bid) . '"/>';
              echo '<input type="hidden" name="id" value="' . urlencode($id) . '" />';
              echo '<input type="submit" value="Place bid" />';
              echo '</form></td>'; /*Bid box*/
              echo '</tr>';
              $count = $count + 1;
          }}
          ?>
      </table>
  </section>
  </body>
</html>
