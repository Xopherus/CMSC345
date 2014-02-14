<?php
	include_once 'cart.php';
	session_start();

/*
 * Displays the shopping cart sidebar
 * $cart - the user's shopping cart
 */
function displayMiniCart($cart){
	echo('<div id="shoppingCartMini">');
	echo('<table id="tableShoppingMiniCart" border = "1">');
	if($cart->getSize() == 0){
		echo('<tr><td>Your shopping cart is empty.</td></tr>');
	}
	else{
		echo('<tr><td>Title</td><td>Quantity</td><td>Price</td></tr>');
		for($i = 0; $i < $cart->getSize(); $i++){
			$cartItem = $cart->getItem($i);
			$quantity = $cartItem->getQuantity();
			$iPrice = $cartItem->getPrice();
			$total = money_format('%i', ($iPrice * $quantity));
			echo('<tr><td>' . $cartItem->getTitle() . '</td><td>' . $cartItem->getQuantity() . '</td><td>' . $total . '</td></tr>');
		}
	}		
	echo('</table>');
?>
	<script language = "JavaScript" type = "text/javascript">
		function redirectCart(){
 			window.location = "cart/fullCart.php"
		}
	</script>
	<button id="btnCart" onclick="redirectCart()">View Shopping Cart</button>
	
<?php
	echo('</div>');
}

displayMiniCart($_SESSION['cart']);

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