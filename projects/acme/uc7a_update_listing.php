<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>Update item</title>
    <meta charset="utf-8"/>
	  <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
  </head>
  <body>
  <!-- NAVIGATION BAR -->
<?php require_once ''. getcwd() . '/openDatabase.php';
$query = $database->prepare(<<<'SQL'
    SELECT
        AUCTION.AUCTION_ID,
        AUCTION.OPEN_TIME,
        AUCTION.CLOSE_TIME,
        AUCTION.CURRENT_PRICE,
        ITEM_CATEGORY.NAME AS ITEM_CATEGORY,
        ITEM_CATEGORY.ITEM_CATEGORY_ID AS ID,
        AUCTION.ITEM_CAPTION,
        AUCTION.ITEM_DESCRIPTION,
        CONCAT(PERSON.FORENAME,' ',PERSON.SURNAME) AS SELLER
        FROM AUCTION
          JOIN ITEM_CATEGORY ON AUCTION.ITEM_CATEGORY = ITEM_CATEGORY.ITEM_CATEGORY_ID
          JOIN PERSON ON AUCTION.SELLER = PERSON.PERSON_ID
        WHERE AUCTION_ID = :auctionID;
SQL
);
$query->bindValue(':auctionID',$_POST['id'], PDO::PARAM_INT);
$query->execute();
$auction = $query->fetch();
$query->closeCursor();

//Sepearte time/hour
$openSplit = explode(" ", $auction['OPEN_TIME']);
$closeSplit = explode(" ", $auction['CLOSE_TIME']);

$dateo = $openSplit[0];
$timeo = $openSplit[1];
$datec = $closeSplit[0];
$timec = $closeSplit[1];

$dateoSplit = explode("-", $dateo);
$datecSplit = explode("-", $datec);
$timeoSplit = explode(":", $timeo);
$timecSplit = explode(":", $timec);

$mo =$dateoSplit[1];
$do =$dateoSplit[2];
$yo =$dateoSplit[0];
$mc =$datecSplit[1];
$dc =$datecSplit[2];
$yc =$datecSplit[0];

$ho = $timeoSplit[0];
$mino = $timeoSplit[1];
$hc = $timecSplit[0];
$minc = $timecSplit[1];

?>
	  <ul class="navBar">
		  <li> <a href="index.php">Main menu</a></li>
		  <li><a href="uc5_close_auction.php">My account</a></li>
		  <li> <a id="logOut" href="uc0_user_logout_confirmation.php">Log out</a></li>
	  </ul>

  <h1 class="singleHeading">Update an auction</h1>
	<form action="uc7b_update_listing_success.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?= $auction['AUCTION_ID']?>"/>
	Title:  <input type="text" name="caption" value="<?= $auction['ITEM_CAPTION'] ?>"/> <br></br>
	Item description:  <input type="text" name="description" value="<?= $auction['ITEM_DESCRIPTION'] ?> "/> <br></br>
	Category: <select name="category">
			<option value="<?= $auction['ID'] ?>"><?= $auction['ITEM_CATEGORY'] ?></option>
			<option value="1">Antiques</option>
			<option value="2">Art and Collectibles</option>
			<option value="3">Books/Movies/Music</option>
			<option value="4">Cars</option>
			<option value="5">Clothing</option>
			<option value="6">Computers&Electronics</option>
			<option value="7">Jewelry</option>
			<option value="8">Musical Instruments</option>
			<option value="9">Tools</option>
			<option value="10">Toys</option>
	</select><br></br>
		<input type="file" name="photo" accept="image/gif"/><br></br>
		Auction open time:  <br> </br>
		<input type="number" name="houro" min="0" max="23" value="<?= $ho ?>"  required>
		<input type="number" name="minuteo" min="0" max="59" value="<?= $mino ?>" required>
		<input type="date" name="dateo" min=<?= date("Y-m-d")?> value="<?= date("Y-m-d",mktime(0,0,0,$mo,$do,$yo))?>" required>
		<br></br>
		Auction closing time:  <br> </br>
		<input type="number" name="hourc" min="0" max="23" value="<?= $hc ?>"required>
		<input type="number" name="minutec" min="0" max="59" value="<?= $minc ?>"required>
			<input type="date" name="datec" min=<?= date("Y-m-d")?> value="<?= date("Y-m-d",mktime(0,0,0,$mc,$dc,$yc))?>" required>
			<br></br>
			<input type="submit" value="Update item" />
		<button type="button" onclick="history.back();">Go back</button>
	</form>
  </body>
</html>
