<?php 
	include_once '../cart/cart.php';
	session_start();
?>

<html>
<head>
<title></title>
</head>
<body>

<?php
	
	$cart = new Cart();
	
	$getUsername = $_POST["Username"];
	$getPassword = $_POST["Password"];
	
	mysql_connect("studentdb.gl.umbc.edu", "craborg1", "craborg1") or die(mysql_error());
	mysql_select_db("craborg1") or die("Could not connect to database");
	
	$result = mysql_query("SELECT * FROM `User` WHERE `Username` = '$getUsername'");
	
	if ($result && mysql_num_rows($result) > 0){
		
		$row = mysql_fetch_array($result);

		// Start the PHP session
		if (strcmp($getPassword,$row['Password']) == 0){
			$_SESSION['username']= $row['Username'];
			$_SESSION['admin']= $row['isAdmin'];
			$_SESSION['cart'] = $cart;
?>

			<script language = "JavaScript" type = "text/javascript">
			
			window.location = "../index-build.php"

			</script>

<?php
		}
		else{
?>
			<script language = "JavaScript" type = "text/javascript">
				alert("Incorrect password.");
				history.go(-1)
			</script>

<?php
		}

		mysql_close();
	}
	else{
?>
		<script language = "JavaScript" type = "text/javascript">
			alert("That username has not been registered. You may create a new account.");
			window.location = "CreateAccount.php"
		</script>

		<?php
	}
?>

</body>
</html>