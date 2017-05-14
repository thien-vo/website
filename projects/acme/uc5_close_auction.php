<?php require_once ''. getcwd() . '/openDatabase.php';
$query = $database->prepare(<<<'SQL'
  UPDATE AUCTION
      SET STATUS = 1
      WHERE CLOSE_TIME > CURRENT_TIMESTAMP AND STATUS != 4;
SQL
);
$query->execute();
$query->closeCursor();
  $query = $database->prepare(<<<'SQL'
  UPDATE AUCTION
      SET STATUS = 2
      WHERE CLOSE_TIME <= CURRENT_TIMESTAMP AND WINNER_ID = SELLER;
SQL
  );
  $query->execute();
  $query->closeCursor();
$query = $database->prepare(<<<'SQL'
  UPDATE AUCTION
      SET STATUS = 3
      WHERE CLOSE_TIME <= CURRENT_TIMESTAMP AND WINNER_ID != SELLER AND STATUS != 4;
SQL
);
$query->execute();
$query->closeCursor();

  header( 'Location: http://' . $_SERVER[HTTP_HOST] . dirname($_SERVER[REQUEST_URI]) . '/uc0_user_logon.php');
?>
