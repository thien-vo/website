<?php
$dbHost = 'fdb13.biz.nf';
$dbName = '2188185_db1';
$username = '2188185_db1';
$password = 'Unp@!nt3d_AZ';
	$conn = mysqli_connect($dbHost,$username,$password,$dbName);
    if(isset($_GET['id'])) {
		echo success;
        $sql = "SELECT ITEM_PHOTO FROM AUCTION WHERE AUCTION_ID = '21'";
		$result = mysqli_query("$sql") or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>" . mysqli_error());
		$row = mysqli_fetch_array($result);
		header('Content-Type: image/gif');
        echo $row["ITEM_PHOTO"];
	}
	mysqli_close($conn);
?>