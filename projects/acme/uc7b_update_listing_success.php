<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>Update auction</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
  </head>
  <?php
  $val1 = $_POST['dateo'] . ' ' . $_POST['houro'] . ':' . $_POST['minuteo'] . ':00.000';
  $val2 = $_POST['datec'] . ' ' . $_POST['hourc'] . ':' . $_POST['minutec'] . ':00.000';

  $datetime1 = new DateTime($val1);
  $datetime2 = new DateTime($val2);
  $correct = 1;
  if($datetime1 > $datetime2) {
    $correct = 0;
  }
  else {
    require_once require_once ''. getcwd() . '/openDatabase.php';
    $closing = $_POST['datec'] . ' ' . $_POST['hourc'] . ':' . $_POST['minutec'];
    $open = $_POST['dateo'] . ' ' . $_POST['houro'] . ':' . $_POST['minuteo'];
      if(isset($_FILES['photo']) && $_FILES['photo']['error'] === 0){
              $query = $database->prepare(<<<'SQL'
  UPDATE AUCTION
      SET OPEN_TIME = :open, CLOSE_TIME  = :close, ITEM_CATEGORY = :category, ITEM_CAPTION = :caption , ITEM_DESCRIPTION = :description, ITEM_PHOTO = :photo
      WHERE AUCTION_ID = :auctionId;
SQL
              );
              $photoFile = fopen($_FILES['photo']['tmp_name'], 'rb');
              $query->bindValue(':photo', $photoFile, PDO::PARAM_LOB);
      }
      else{
          $query = $database->prepare(<<<'SQL'
  UPDATE AUCTION
      SET OPEN_TIME = :open, CLOSE_TIME  = :close, ITEM_CATEGORY = :category, ITEM_CAPTION = :caption , ITEM_DESCRIPTION = :description
      WHERE AUCTION_ID = :auctionId;
SQL
          );}
    $query->bindValue(':open', $open, PDO::PARAM_STR);
    $query->bindValue(':close', $closing, PDO::PARAM_STR);
    $query->bindValue(':auctionId', $_POST['id'], PDO::PARAM_INT);
    $query->bindValue(':category', $_POST['category'], PDO::PARAM_INT);
    $query->bindValue(':caption', $_POST['caption'], PDO::PARAM_STR);
    $query->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
    $id = $_POST['id'];
    $query->execute();
    $query->closeCursor();
  }
  ?>
  <?php if($correct == 1)
    echo "<body>
  <h1>Successfully updated the item!</h1>
  <ul class=\"actionBar\">
    <li><a href=\"uc3_auction_detail.php?id=$id]\">Go to auction detail page</a></li>
    <li><a href=\"uc5_close_auction.php\">Return to your account</a></li>
    <li> <a href=\"index.php\">Return to main menu</a></li>
  </ul>
  </body>";
  else
    echo "<body>
  <h1>Unsuccessfully auctioned the item</h1>
  <strong>Closing time cannot be earlier than open time</strong><br></br>
  <button type=\"button\" onclick=\"history.back();\">Go back and fix the time</button>
  <br></br>
  <ul class=\"actionBar\">
    <li><a href=\"uc5_close_auction.php\">Return to your account</a></li>
    <li> <a href=\"index.php\">Return to main menu</a></li>
  </ul>
  </body>";
  ?>
  </body>
</html>
