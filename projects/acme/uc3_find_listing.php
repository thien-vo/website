<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>Find auctions</title>
    <meta charset="utf-8"/>
      <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
  </head>
  <body>
  <!-- NAVIGATION BAR -->

    <ul class="navBar">
      <li id="logOut"><a  href="uc0_user_logout_confirmation.php">Log out</a></li>
      <li><a href="uc5_close_auction.php">My account</a></li>
    </ul>

  <h1>Search for auctions</h1>
  <section><h2>Search by keywords:</h2>
  <form action="uc3_current_listing.php" method="get">
    <input type="text" name="caption"/>
    <input type ="hidden" name="searchID" value="1">
    <input type="submit" value="Find auctions""/>
  </form></section>
  
  <section><h2>Search by seller:</h2>
  <form action="uc3_current_listing.php" >
    <input type="text" name="seller" />
    <input type ="hidden" name="searchID" value="2">
    <input type="submit" value="Find auctions" />
  </form></section>
  
  <section><h2>Search by category:</h2>
  <form action="uc3_current_listing.php">
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
    </select>
    <input type ="hidden" name="searchID" value="3">
  <input type="submit" value="Find auctions" /></form></section>

  <section><h2>Search by price:</h2>
    <form action="uc3_current_listing.php">

      <p>From $<input type="number" name="low" min="0" required> to $<input type="number" name="high" min="0" required></p>
      <input type ="hidden" name="searchID" value="4">
      <input type="submit" value="Find auctions" /></form></section>
  </body>
</html>
