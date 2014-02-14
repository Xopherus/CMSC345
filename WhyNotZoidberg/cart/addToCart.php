<?php
	include_once '../CommonMethods.php';	
	include_once 'cart.php';
	session_start();
	
	$COMMON = new Common(FALSE);
	$cart = $_SESSION['cart'];
	
	/*
	 * Testing that the cart was grabbed from the PHP session
	for($i = 0; $i < $cart->getSize(); $i++){
		$item = $cart->getItem($i);
		$item->toString();
	}
	 * 
	echo("Retrieved cart successfully <hr/>");
	*/
	
	$book = $_SESSION['bookRecord'];
	//echo("<br/> Retrieved book successfully <br/>");
	
	$quantity = $_POST['quantity'];
	
	// Query the database to check the current stock of the item in the database.
	$query = 'SELECT `CurrentStock` FROM `Books` WHERE `ISBN` = "' . $book['ISBN'] . '"';
	$result = $COMMON->executeQuery($query, $_SERVER['addToCart.php']);
	$record = mysql_fetch_array($result);
	$currentStock = $record['CurrentStock'];
	
	// If there are more books requested then available, allow the user to add the max available to their cart.
	if($quantity > $currentStock){
		$cart->addItem($book, $currentStock);
?>
	<!-- Alert the customer if there are not enough copies available -->
	<script language="JavaScript" type="text/javascript">
		alert("There aren't enough copies that you have requested, so we have added as many copies that are available. ");
	</script>
<?php
	}
	else{
		$cart->addItem($book, $quantity);	
	}
	
	/*
	 * Testing that the cart was updated
	 *
	echo("<br/> Added book to cart successfully <br/>");
	
	for($i = 0; $i < $cart->getSize(); $i++){
		$item = $cart->getItem($i);
		$item->toString();
	}
	 */
	
	unset($_SESSION['bookRecord']);	
	$_SESSION['cart'] = $cart;	
	
?>

<script language = "JavaScript" type = "text/javascript">	
	window.location = "../index-build.php"
</script>	