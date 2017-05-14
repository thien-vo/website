<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>Checkout</title>
    <meta charset="utf-8"/>
	  <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
  </head>
  <body>
  <!-- NAVIGATION BAR -->

	  <ul class="navBar">
		  <li> <a href="uc5_close_auction.php">My account</a></li>
		  <li id="logOut"><a href="uc0_user_logout_confirmation.php">Log out</a></li>
	  </ul>
  <?php require_once ''. getcwd() . '/openDatabase.php';
  $query = $database->prepare(<<<'SQL'
	SELECT
		STATUS
		FROM AUCTION
		WHERE AUCTION_ID = :auctionId;
SQL
  );
  $query->bindValue(':auctionId', $_POST['id'], PDO::PARAM_INT);
  $query->execute();
  $auction = $query->fetch();
  $query->closeCursor();
  $status = $auction['STATUS'];
  ?>
<?php
	$amount = number_format($_POST['amount'],2,'.',' ');
	$tax = $amount * 0.0825;
	$tax = number_format($tax,2,'.',' ');
	$shipping = number_format(5,2,'.',' ');
	$total = $amount + $tax + $shipping;
	$total = number_format($total,2,'.',' ');
?>
  <?php
  if($status == 3) {
	  ?>
	  <section><h1 class="singleHeading">Order Summary</h1><pre>
   Subtotal:  $<?= $amount ?>

   Tax: $<?= $tax ?>

   Shipping: $<?= $shipping ?>

   Total: $<?= $total ?>
  </pre>
	  </section>

	  <section><h2>Credit Card Information</h2>
		  <form action="uc6b_pay_page_success.php" method="post">Payment method: <select>
				  <option value="visa">Visa</option>
				  <option value="mastercard">MasterCard</option>
				  <option value="discover">Discover</option>
				  <option value="american">American Express</option>
			  </select><br></br>
			  Name on card: <input type="text" name="name" required/> <br></br>
			  Credit Card Number: <input type="number" name="card" min="1000000000000000" maxlength="16" required/>
			  <br></br>
			  CVV2 Security Code: <input type="number" name="code" min="100" max="999" required/><br></br>
			  Expiration date: <select>
				  <option value="-">-</option>
				  <option value="1">January</option>
				  <option value="2">Febuary</option>
				  <option value="3">March</option>
				  <option value="4">April</option>
				  <option value="5">May</option>
				  <option value="6">June</option>
				  <option value="7">July</option>
				  <option value="8">August</option>
				  <option value="9">September</option>
				  <option value="10">October</option>
				  <option value="11">November</option>
				  <option value="12">December</option>
			  </select><select>
				  <option value="-">-</option>
				  <option value="16">2016</option>
				  <option value="17">2017</option>
				  <option value="18">2019</option>
				  <option value="19">2019</option>
				  <option value="20">2020</option>
				  <option value="21">2021</option>
				  <option value="22">2022</option>
				  <option value="23">2023</option>
				  <option value="24">2024</option>
			  </select>
			  <br></br>
			  <input type="hidden" name="id" value="<?= $_POST['id'] ?>"/>
			  <input type="submit" value="Pay for purchase"/>
			  <button type="button" onclick="history.back();">Go back</button>
		  </form>
	  </section>
	  <?php
  }else if($status == 1){
	  ?>
	  <strong>This auction is still open.</strong><br></br>
	  <button type="button" onclick="history.back();">Go back</button>
	  <?php
  } else{
  ?>
	  <strong>This auction has already been paid.</strong><br></br>
	  <button type="button" onclick="history.back();">Go back</button>
  <?php
  }
  ?>
  </body>
</html>
