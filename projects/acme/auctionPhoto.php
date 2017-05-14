<?php require_once getcwd() . '\openDatabase.php';
$query = $database->prepare(<<<'SQL'
    SELECT
        ITEM_PHOTO
        FROM AUCTION
        WHERE AUCTION_ID = :auctionId;
SQL
);
	 $query->bindValue(':auctionId', $_GET['id'], PDO::PARAM_INT);
	 $query->execute();
	$photoContents = $query->fetch();
	 header('Content-type: image');
	if (strlen($photoContents['ITEM_PHOTO']) == 0) {
		$photoContents['ITEM_PHOTO'] = file_get_contents('noPhoto.jpe');
	}
	 echo $photoContents['ITEM_PHOTO'];
	$query->closeCursor();
