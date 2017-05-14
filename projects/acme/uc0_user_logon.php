<?php
  session_start();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>Welcome Jayson</title>
    <meta charset="utf-8"/>
	  <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
  </head>
  <body>
  <!-- NAVIGATION BAR -->
	<ul class="navBar">
	  <li id="logOut"><a  href="uc0_user_logout_confirmation.php">Log out</a></li>
		<li><a href="uc1a_list_item.php">Auction an item</a></li>
		<li><a href="uc3_find_listing.php">Browse auction</a></li>
	</ul>
  <?php require_once ''. getcwd() . '/openDatabase.php';
  $logonID = $_SESSION['authenticatedUser'];
  $query = $database->prepare(<<<'SQL'
    SELECT
        AUCTION.AUCTION_ID,
        AUCTION.OPEN_TIME,
        AUCTION.CLOSE_TIME,
        AUCTION.CURRENT_PRICE,
        ITEM_CATEGORY.NAME AS ITEM_CATEGORY,
        AUCTION.ITEM_CAPTION,
        AUCTION.ITEM_DESCRIPTION,
        CONCAT(PERSON.FORENAME,' ',PERSON.SURNAME) AS SELLER,
        AUCTION_STATUS.NAME
        FROM AUCTION
          JOIN ITEM_CATEGORY ON AUCTION.ITEM_CATEGORY = ITEM_CATEGORY.ITEM_CATEGORY_ID
          JOIN PERSON ON AUCTION.SELLER = PERSON.PERSON_ID
          JOIN AUCTION_STATUS ON AUCTION.STATUS = AUCTION_STATUS.AUCTION_STATUS_ID
        WHERE PERSON.PERSON_ID = :seller
        ORDER BY AUCTION.AUCTION_ID ASC;
SQL
  );
  $query2 = $database->prepare(<<<'SQL'
    SELECT
        CONCAT(PERSON.FORENAME,' ',PERSON.SURNAME) AS SELLER
        FROM PERSON
        WHERE PERSON.PERSON_ID = :seller2
SQL
  );
  $query->bindValue(':seller',$logonID, PDO::PARAM_INT);
  $query2->bindValue(':seller2',$logonID, PDO::PARAM_INT);
  $query->execute();
  $query2->execute();
  $rows = $query->rowCount();
  $auction = $query->fetchAll();
  $seller = $query2->fetch();
  $query->closeCursor();
  $query2->closeCursor();

  ?>
  <h1>Welcome <span class="userID"> <?= $seller['SELLER'] ?>!</span></h1>
  <section> <h2>Your auctions:</h2>
	  <?php
	  if($rows == 0)
		  echo 'No auction found';
	  else{
		  echo '<table style="width:100%">';
		  echo '<tr>';
		  echo '<th>Item Name</th>';
		  echo '<th>Description</th>';
		  echo '<th>Open Time</th>';
		  echo '<th>Closing Time</th>';
		  echo '<th>Current Price</th>';
		  echo '<th>Status</th>';
		  echo '<th></th>';
		  echo '<th></th>';
		  echo '</tr>';

		  $count = 0;
		  while($count < $rows){
			  echo '<tr>';
			  echo '<td>' . htmlspecialchars($auction[$count][5]);
			  echo '<br></br>';
			  echo '<a href="uc3_auction_detail.php?id=' . htmlspecialchars($auction[$count][0]) . '">More details</a>' . '</td>'; /*Item name*/
			  echo '<td>' . htmlspecialchars($auction[$count][6]);
			  echo '<br></br>';
			  echo 'Category: ' . htmlspecialchars($auction[$count][4]) . '</td>'; /*Description*/
			  echo '<td>' . htmlspecialchars($auction[$count][1]) . '</td>';/*Open Time*/
			  echo '<td>' . htmlspecialchars($auction[$count][2]) . '</td>';/*Closing Time*/
			  echo '<td>$' . htmlspecialchars($auction[$count][3]) . '</td>';/*Current price*/
			  echo '<td>' . htmlspecialchars($auction[$count][8]) . '</td>';
			  echo '<td><form action="uc7a_update_listing.php" method="post">';
			  echo '<input type="submit" value="Update"/>';
			  echo '<input type="hidden" name="id" value="'.urlencode($auction[$count][0]).'""/>';
			  echo '</form></td>'; /*Update box*/
			  echo '<td><form action="uc2a_cancel_listing.php">';
			  echo '<input type="submit" value="Cancel"/>';
			  echo '<input type="hidden" name="id" value="'.urlencode($auction[$count][0]).'""/>';
			  echo '</form></td>'; /*Cancel box*/
			  echo '</tr>';
			  $count = $count + 1;
		  }}
	  ?>
	  </table>
</section>
  <?php require_once ''. getcwd() . '/openDatabase.php';
  $logonID = $_SESSION['authenticatedUser'];
  $query3 = $database->prepare(<<<'SQL'
    SELECT
        AUCTION.AUCTION_ID,
        AUCTION.CURRENT_PRICE,
        AUCTION.CLOSE_TIME,
        ITEM_CATEGORY.NAME AS ITEM_CATEGORY,
        AUCTION.ITEM_CAPTION,
        AUCTION.ITEM_DESCRIPTION,
        CONCAT(PERSON.FORENAME,' ',PERSON.SURNAME) AS SELLER,
        AUCTION.WINNER_ID,
        PERSON.PERSON_ID,
        AUCTION_STATUS.NAME
        FROM AUCTION
          JOIN ITEM_CATEGORY ON AUCTION.ITEM_CATEGORY = ITEM_CATEGORY.ITEM_CATEGORY_ID
          JOIN PERSON ON AUCTION.SELLER = PERSON.PERSON_ID
          JOIN AUCTION_STATUS ON AUCTION.STATUS = AUCTION_STATUS.AUCTION_STATUS_ID
        WHERE WINNER_ID = :winner
        ORDER BY AUCTION.AUCTION_ID ASC;
SQL
  );
  $query3->bindValue(':winner',$logonID, PDO::PARAM_INT);
  $query3->execute();
  $rows = $query3->rowCount();
  $auction = $query3->fetchAll();
  $query3->closeCursor();
  ?>
  <section>
	  <h2>Your winning auctions:</h2>
		  <?php
		  $count = 0;
		  $won = 0;
		  while($count < $rows){
			  $winnerID = $auction[$count][7];
			  $sellerID = $auction[$count][8];
			  if($winnerID != $sellerID){
				  $won = 1;
			  }
			  $count = $count +1;
		  }
		  if($rows == 0 || $won == 0)
			  echo 'No winning auctions found';
		  else{
			  echo '<table>';
			  echo '<table style="width:100%">';
			  echo '<tr>';
			  echo '<th>Item Name</th>';
			  echo '<th>Description</th>';
			  echo '<th>Closing Time</th>';
			  echo '<th>Seller</th>';
			  echo '<th>Price</th>';
			  echo '<th>Status</th>';
			  echo '<th></th>';
			  echo '</tr>';

			  $count = 0;
			  while($count < $rows){
				  $winnerID = $auction[$count][7];
				  $sellerID = $auction[$count][8];
				  if($winnerID != $sellerID){
				  echo '<tr>';
				  echo '<td>' . htmlspecialchars($auction[$count][4]);
				  echo '<br></br>';
				  echo '<a href="uc3_auction_detail.php?id=' . htmlspecialchars($auction[$count][0]) . '">More details</a>' . '</td>'; /*Item name*/
				  echo '<td>' . htmlspecialchars($auction[$count][5]);
				  echo '<br></br>';
				  echo 'Category: ' . htmlspecialchars($auction[$count][3]) . '</td>'; /*Description*/
				  echo '<td>' . htmlspecialchars($auction[$count][2]) . '</td>';/*Closing Time*/
				  echo '<td>' . htmlspecialchars($auction[$count][6]) . '</td>';/*Seller*/
				  echo '<td>$' . htmlspecialchars($auction[$count][1]) . '</td>';/*Current price*/
					  echo '<td>' . htmlspecialchars($auction[$count][9]) . '</td>';
					  echo '<td><form action="uc6a_pay_page.php" method="post">';
					  echo '<input type="submit" value="Pay"/>';
					  echo '<input type="hidden" name="id" value="'.urlencode($auction[$count][0]).'""/>';
					  echo '<input type="hidden" name="amount" value="'.urlencode($auction[$count][1]).'""/>';
					  echo '</form></td>'; /*Pay box*/
				  echo '</tr>';}
				  $count = $count + 1;
			  }
		  		echo '</table>';}
		  ?>
  </body>
</html>
