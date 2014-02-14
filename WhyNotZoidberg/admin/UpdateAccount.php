<?php session_start(); ?>

<html>
<head>
<title></title>
</head>
<body>

<?php

	include_once("../cart/cart.php");

	$getUsername = $_POST["Username"];
	$getPassword = $_POST["Password"];
	$getAddress = $_POST["Address"];
	$getCity = $_POST["City"];
	$getZip = $_POST["Zip"];

	mysql_connect("studentdb.gl.umbc.edu", "craborg1", "craborg1") or die(mysql_error());
	mysql_select_db("craborg1") or die("Could not connect to database");

	$result = mysql_query("SELECT 1 FROM `User` WHERE `Username` = '$getUsername'");
	if ($result && mysql_num_rows($result) > 0){
	?>
	<script language = "JavaScript" type = "text/javascript">

	alert("Username already taken.");

	history.go(-1)
	
	</script>

	<?php
    	}
	else
    	{
    	mysql_query("INSERT INTO `Account` ( `Username` , `Funds` , `Address` , `City` , `Zipcode` ) VALUES ('$getUsername',0,'$getAddress','$getCity','$getZip')")or die(mysql_error());
		mysql_query("INSERT INTO `User` ( `Username` , `Password` , `isAdmin` ) VALUES ('$getUsername','$getPassword', 'no')")or die(mysql_error());
		$_SESSION['username']= $getUsername;
		$_SESSION['admin']= "no";

		$_SESSION['cart'] = new Cart();
		
		mysql_close();
		?>

		<script language = "JavaScript" type = "text/javascript">
			
		window.location = "../index-build.php"

		</script>
		<?php

    	}

?>

</body>
</html>