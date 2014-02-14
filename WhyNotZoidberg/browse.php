<?php
	//Session start all the way up here...... alone
	include_once 'cart/cart.php';
	include_once('CommonMethods.php');
	session_start();
	
	/*
	 * Creates the browse page 
	 */
	function browseBook($COMMON, $isbn){
		$query = 'SELECT * FROM `Books` WHERE `ISBN` = "'. $isbn . '"';
		$result = $COMMON->executeQuery($query, $_SERVER['browse.php']);
		$book = mysql_fetch_array($result);
		
		echo('<table id="browse" border="0" width="100%" cellspacing="0" cellpadding="14">');
		echo('<tr>');
		printImage($book);
		echo('</tr>');
		
		echo('<tr>');
		printBookInfo($book);
		printCheckoutArea($book);
		echo('</tr>');
		
		echo('<tr>');
		printSummary($book);
		echo('</tr>');
		echo('</table>');
	}

	/*
	 * Prints the book image on the browse page
	 */
	function printImage($book){
		
		//Use default image if image to book is set to NULL
		if($book['ImageLink'] == NULL)
		{
			echo('<td colspan="2" align="center"><img src="image/defaultBookImage.png" width="250" height="250"/></td>');
		}
		else 
		{
			echo('<td colspan="2" align="center"><img src="' . $book['ImageLink'] . '" width="250" height="250"/></td>');	
		}
	}
	
	/*
	 * Prints the book information on the browse page (Title, Author, Year Published and Price)
	 */
	function printBookInfo($book){
		echo('<td width="190"><p>Title: ' . $book['Title'] . '</p><p>Author: ' . $book['Author'] . '</p><p>Year Published: ' . 
				$book['YearPublished'] . '</p><p>Price: $' . $book['Price'] . '</p></td>');
	}
	
	/*
	 * Prints the html form for the checkout area. This includes a drop down box for quantity and a 
	 * add to shopping cart button
	 */
	 function printCheckoutArea($book){
	 	echo('<td align="right">');
		$_SESSION['bookRecord'] = $book;
		
		// If the user is not logged in or an administrator, or if there are no copies of the book available, do NOT display the add to cart button
		if(isset($_SESSION['username']) && $_SESSION['admin'] == 'no' && $book['CurrentStock'] > 0){
	 		echo('<form action="cart/addToCart.php" name="addItem" onsubmit="return validate_quantity()" method="post" />');
	 		echo('<p>Quantity: <input type="text" name="quantity" size="2" value="1"/><input type="submit" name="AddtoCart" value="Add to Cart"/></p>');
	 		echo('</form>');
		}
		
		// If there are no books available, let the customer know
		if($book['CurrentStock'] == 0){
			echo('<p><font color="red"><b>Not available for purchase. </b></font></p>');
		}
		else{
			echo('<p>Quantity Remaining: ' . $book['CurrentStock'] . '</p>');
		}
		
		echo('<p>ISBN: ' . $book['ISBN'] . '</p>');
		echo('<p>Genre: ' . $book['Genre'] . '</p>');
		echo('</td>');
	 }
	 
	 /*
	  * Prints the summary of the book 
	  */
	 function printSummary($book){
	 	echo('<td colspan="2"><p>Book Summary:<br></p><p>' . $book['Summary'] . '</p></td>');
	 }

		$COMMON = new Common(FALSE);
						
		$isbn = $_POST['productType'];
?>

<script language = "JavaScript" type = "text/javascript">
	function validate_quantity(){
	var quantity = document.forms["addItem"]["quantity"].value;

	if(quantity.length < 1 || quantity.length > 2){
		alert("Quantity format invalid");
		return false;
	}
	else{
		for (i = 0 ; i < quantity.length ; i++) {
			if ((quantity.charAt(i) < '0') || (quantity.charAt(i) > '9')){
				alert("Quantity format invalid");
				return false;
			}
		}
	}
	if(+quantity < 1 || +quantity > 99){
		alert("Quantity must be a value between 0-99 inclusive.");
		return false;
	}
	return true;
}
</script>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Why Not Zoidberg? : Browse</title>
	<link rel="icon" type="image/png" href="image/favicon.ico" />
	<link href="store-style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<!-- Wrapper = whole general website -->
<div id="wrapper">

	<!-- Header area -->
	<div id="header">
    	<div id="logo"><a href="index-build.php"><img src="image/logo-zoidberg.png" width="180" height="180" border="0" /></a></div>
	  	
    	<!-- Buttons at the header -->
    	<?php
    		if(isset($_SESSION['username']))
			{
				//If you're an admin you can logout and visit the admin control panel
				if($_SESSION['admin'] == "yes")
				{
		?>
					<div id="log-out"><a href="admin/logout.php">Logout</a></div>
					<div id="account"><a href="admin/Admin.php">Control Panel</a></div>
		<?php			
				}
				//If you're just a registered user you can logout and view account
				else
				{
		?>
					<div id="log-out"><a href="admin/logout.php">Logout</a></div>
					<div id="account"><a href="viewAccount.php">View Account</a></div>
		<?php	
				}
			}
			//If you're not a registered user then you can only create account and login
			else 
			{
		?>
				<div id="account"><a href="admin/CreateAccount.php">Create Account</a></div>
				<div id="log-out"><a href="admin/getLogin.php">Login</a></div>
		<?php
			}
    	?>
		
        <div id="search">
			<form name="search" action='search.php' method="post">
			
			Search:
			<select name="searchOption">
  			<option value="Title">Title</option>
  			<option value="Author">Author</option>
  			<option value="Genre">Genre</option>
			<option value="ISBN">ISBN</option>
			</select>
			
			<input type="text" name="searchBar" size="40" maxlength="100">
			<input type="submit" value="Search">
			</form> 
		</div>
  </div>
  
 	<!-- Content area -->
	<div id="content">
		<!-- In between each cell there a spacing of 20 -->
  		<table width="100%" border="0" cellspacing="20" cellpadding="10">
			<tr>
  			<!-- Left sidebar-->
    		<td valign="top" id="sidebar-left"><h1>Popular Genres </h1>
      			<!-- Check to see if popGenre.php works-->
      			<?php
      				include_once "popGenre.php";
      			?>
      		</td>
      			
      		<!-- Middle content area -->	
    		<td valign="top" id="content-area">
    			
    			<?php
						browseBook($COMMON, $isbn);
				?>
      		
      		</td>
      		
      		<!-- Right sidebar -->
    		<td valign="top" id="sidebar-right">
    		<?php
    			//Only display the shopping cart for users who are logged in and not admin
    			$isAdmin = $_SESSION['admin'];
    		
				if(isset($_SESSION['username']))
				{
					if($isAdmin == "no")
					{
					?>
						<h1>Shopping cart</h1>
					<?php
						include_once 'cart/miniCart.php';	
					}		
				}
      		?>
      		
      		<br>
      		<p align="center"><img src="image/drink-slurm.jpg" width="180" height="113" /> </p></td>
			</tr>
		</table>
		
		<!-- Footer section-->
  		<div id="footer"><a href="aboutPlanetExpress.html">About us</a> &copy; 2012 Why Not Zoidberg</div>
	</div>
</div>
</body>
</html>
