<?php
	include_once '../CommonMethods.php';
	include_once 'cart.php';
	session_start();

	$COMMON = new Common(FALSE);
	$update = $_POST['updateCart'];
	$checkout = $_POST['checkout'];
	
	// If the user wishes to update their shopping cart 
	if($update){
		updateCart($COMMON);
		?>
		<!-- Redirect the user back to the shopping cart page -->
		<script language="JavaScript" type="text/javascript">
			window.location = 'fullCart.php';
		</script>
		<?php
	
	}
	elseif($checkout){
		updateCart($COMMON);	
		checkout($COMMON);
		?>
		<!-- Redirect the user back to their account page -->
		<script language="JavaScript" type="text/javascript">
			window.location = '../viewAccount.php';
		</script>
		<?php
	
	}

/*
 *  Updates the shopping cart. You can only add 0-99 items, and no more than the current stock available
 */
function updateCart($COMMON){
	$cart = $_SESSION['cart'];
	
	for($i = 0; $i < $cart->getSize(); $i++){
		// Grab the data from the $ith form 
		$newQuantity = $_POST[$i];
			
		// If the user types a 0 in the form, remove the item from the cart.
		if($newQuantity == 0){
			$cart->removeItem($i);
		}
		else{
			// If the user provides a quantity > 0, get the item from the cart to change the quantity
			$nextItem = $cart->getItem($i);
				
			// Query the database to check the current stock of the item in the database.
			$query = 'SELECT `CurrentStock` FROM `Books` WHERE `ISBN` = "' . $nextItem->getISBN() . '"';
			$result = $COMMON->executeQuery($query, $_SERVER['checkout.php']);
			$record = mysql_fetch_array($result);
			$currentStock = $record['CurrentStock'];
			
			// If there are more books requested then available, allow the user to add the max available to their cart.
			if($newQuantity > $currentStock){
				$cart->editQuantity($i, $currentStock);
			?>
			<!-- Alert the customer if there are not enough copies available -->
			<script language="JavaScript" type="text/javascript">
				alert("There aren't enough copies that you have requested, so we have added as many copies that are available. ");
			</script>
			<?php
			}
			else{
				$cart->editQuantity($i, $newQuantity);	
			}				
		}
	}
	$_SESSION['cart'] = $cart;
}

/*
 * Allows a user to checkout their items, deduct the balance from their account, and update the item inventory
 */
function checkout($COMMON){
	$cart = $_SESSION['cart'];
	
	// Grab the customer balance has
	$query = 'SELECT `Funds` FROM `Account` WHERE `Username` = "' . $_SESSION['username'] . '"';
	$result = $COMMON->executeQuery($query, $_SERVER['checkout.php']);
	$record = mysql_fetch_array($result);
	$funds = $record['Funds'];
	
	// If the user does not have enough funds, notify them that they need to add more funds
	if($funds < $cart->getTotal()){
		?>
		<script language="JavaScript" type="text/javascript">
			alert("You do not have enough funds to purchase these items. Please add more funds to your balance");
			window.location = "../viewAccount.php";
		</script>
		<?php
	}
	else{
		// Update the user's balance
		$newBalance = $funds - $cart->getTotal();
		$query = 'UPDATE `Account` SET `Funds` = "' . $newBalance . '" WHERE `Username` = "' . $_SESSION['username'] . '"' ;
		$result = $COMMON->executeQuery($query, $_SERVER['checkout.php']);
		
		for($i = 0; $i < $cart->getSize(); $i++){
			// Grab the number of copies of the item left and the total # sold
			$nextItem = $cart->getItem($i);
			$query = 'SELECT `CurrentStock`, `TotalSold` FROM `Books` WHERE `ISBN` = "' . $nextItem->getISBN() . '"';
			$result = $COMMON->executeQuery($query, $_SERVER['checkout.php']);
			$record = mysql_fetch_array($result);
			$currentStock = $record['CurrentStock'];
			$totalSold = $record['TotalSold'];
			
			// Set the new stock, subtract the number of copies the customer wants. Also set the total sold
			$newStock = $currentStock - $nextItem->getQuantity();
			$newTotal = $totalSold + $nextItem->getQuantity();
			
			// Update the number of copies sold
			$query = 'UPDATE `Books` SET `TotalSold` = "' . $newTotal . '" WHERE `ISBN` = "' . $nextItem->getISBN() . '"';
			$result = $COMMON->executeQuery($query, $_SERVER['checkout.php']);
			
			// Update the current stock
			$query = 'UPDATE `Books` SET `CurrentStock` = "' . $newStock . '" WHERE `ISBN` = "' . $nextItem->getISBN() . '"' ;
			$result = $COMMON->executeQuery($query, $_SERVER['checkout.php']);
		}
		$_SESSION['cart'] = new Cart();
		?>
		<script language="JavaScript" type="text/javascript">
			alert("Thank you for shopping with Why Not Zoidberg?");
		</script>
		<?php
	}
}
?>