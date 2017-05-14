<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>Auction an item</title>
    <meta charset="utf-8"/>
	  <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
  </head>
  <body>
  <!-- NAVIGATION BAR -->

	  <ul class="navBar">
          <li id="logOut"><a  href="uc0_user_logout_confirmation.php">Log out</a></li>
		  <li><a href="uc5_close_auction.php">My account</a></li>
	  </ul>
<br></br>
  <h1 class="singleHeading">Auction an item</h1>
    <section>
		<form action="uc1b_list_item_success.php" method="post" class="listItem" enctype="multipart/form-data">
		Title:  <input type="text" name="caption" requried/> <br></br>
		Item description:  <input type="text" name="description" required/> <br></br>
		Category:
            <select name="category">
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
            <input type="file" name="photo" accept="image/jpeg"/><br></br>
		<p class="importantRequirements">Starting price:  $<input type="number" name="price" required/> <br></br>
            Auction open time:  <br> </br>
            <input type="number" name="houro" min="0" max="23" required>
            <input type="number" name="minuteo" min="0" max="59" required>
                <input type="date" name="dateo" min=<?= date("Y-m-d")?> required>
        <br></br>
		Auction closing time:  <br> </br>
            <input type="number" name="hourc" min="0" max="23" required>
            <input type="number" name="minutec" min="0" max="59" required>
	    <input type="date" name="datec" min=<?= date("Y-m-d")?> required>
		</p><br></br>
            <button type="submit" value="Submit">Submit</button>
        </form>
        <form action="uc5_close_auction.php" class="listItem"><button type="submit" value="Cancel">Cancel</button> </form>


  </section><br></br>
  </body>
</html>
