<?php
	include_once 'cart.php';
	session_start();

/*
 * Displays all of the items in the cart. Each item will have a text box that may be used to edit the quantity and a delete button
 * $cart - the shopping cart of items to display
 */	
function displayCart($cart){
	echo('<div>');
	if($cart->getSize() == 0)
		echo('<hr/><br/><h1>Your shopping cart is empty. ');
	else{
		echo('<form name="checkoutForm" onsubmit="return validate_input(' . $cart->getSize() . ')" action="checkout.php" method="post">');
		echo('<table id="tableShoppingCart" width="925px" cellspacing="15">');
	
		// For each item, display the image, the title, the quantity and a button to remove it. 
		for($i = 0; $i < $cart->getSize(); $i++){
			$cartItem = $cart->getItem($i);
			displayItem($cartItem, $i);
		}
		
		$total = money_format('%i', $cart->getTotal());
		echo('<tr><td colspan="2"></td><td><h1>Total: $' . $total . ' </h1></td><td colspan="2">' . 
			 '<input type="submit" name="updateCart" title="Update my shopping cart" value="Update">' . 
			 '<input type="submit" name="checkout" title="Checkout and purchase my items" value="Checkout"></td></tr>');
		echo('</table>');
		echo('</form>');
	}
	echo('</div>');
}

/*
 * Displays an item on the page, the image, title, price, quantity and a remove button\
 * $itemInfo
 * $quantity
 * @return quantity * price (total price for all copies of 1 item)
 */
function displayItem($item, $i){ 
	echo('<div id="cartItem">');
	echo('<tr><td>' . ($i + 1) . '.)</td>' . 
	 	 '<td><img src=' . $item->getImage(). ' width="80" height="80"/></td>' .
	 	 '<td><p>' . $item->getTitle() . '</p></td>' . 
	 	 '<td><p>Price: $' . $item->getPrice() . '</p></td>' .
	 	 '<td><p>Quantity: <input type="text" name="' . $i . '" value="' . $item->getQuantity() . '" size="2" maxlength="2"></p></td></tr>');
	echo('</div>');
}
 
?>

<!-- Code to validate the quantity forms -->
<script language="JavaScript" type="text/javascript">
	function validate_input(num){
		for (var i = 0 ; i < num ; i++)
		{
			var temp = document.forms["checkoutForm"][i].value;
			for (j = 0 ; j < temp.length ; j++) { 			
				if (temp.charAt(j) < '0' || temp.charAt(j) > '9'){					
					alert("Please provide a positive number in field " + (i + 1) + ". ");
					return false;
				}
			}
		}
   		return true;
	}
</script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Why Not Zoidberg?</title>
	<link rel="icon" type="image/png" href="../image/favicon.ico" />
	<link href="../store-style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<!-- Wrapper = whole general website -->
<div id="wrapper">

	<!-- Header area -->
	<div id="header">
    	<div id="logo"><a href="../index-build.php"><img src="../image/logo-zoidberg.png" width="180" height="180" border="0" /></a></div>
    	
    	<!-- Buttons at the header -->
    	<?php
    		if(isset($_SESSION['username']))
			{
				//If you're an admin you can logout and visit the admin control panel
				if($_SESSION['admin'] == "yes")
				{
		?>
					<div id="log-out"><a href="../admin/logout.php">Logout</a></div>
					<div id="account"><a href="../admin/Admin.php">Control Panel</a></div>
		<?php			
				}
				//If you're just a registered user you can logout and view account
				else
				{
		?>
					<div id="log-out"><a href="../admin/logout.php">Logout</a></div>
					<div id="account"><a href="../viewAccount.php">View Account</a></div>
		<?php	
				}
			}
			//If you're not a registered user then you can only create account and login
			else 
			{
		?>
				<div id="account"><a href="../admin/CreateAccount.php">Create Account</a></div>
				<div id="log-out"><a href="../admin/GetLogin.html">Login</a></div>
		<?php
			}
    	?>
		
        <div id="search">
			<form name="search" action='../search.php' method="post">
			
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
      		<!-- Middle content area -->	
    		<td valign="top" id="content-area"><h1>Your Shopping Cart</h1>
				<?php
					displayCart($_SESSION['cart']);
				?>
			</td></tr>
		</table>
		
		<!-- Footer section-->
  		<div id="footer"><a href="aboutPlanetExpress.html">About us</a> &copy; 2012 Why Not Zoidberg</div>
	</div>
</div>
</body>
</html>
