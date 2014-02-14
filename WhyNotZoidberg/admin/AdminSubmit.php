<html>
<head>
<title></title>
</head>
<body>

<?php
	$updateVar = $_POST['Update'];
	$deleteVar = $_POST['Delete'];

	$getISBN = $_POST["ISBN"];

	mysql_connect("studentdb.gl.umbc.edu", "craborg1", "craborg1") or die(mysql_error());
	mysql_select_db("craborg1") or die("Could not connect to database");

	if ($updateVar == "Update") {
  	
		$getTitle = $_POST["Title"];
		$getAuthor = $_POST["Author"];
		$getYear = $_POST["YearPublished"];
		$getGenre = $_POST["Genre"];
		$getPrice = $_POST["Price"];
		$getStock = $_POST["CurrentStock"];
		$getImage = $_POST["Image"];
		$getSold = $_POST["TotalSold"];
		$getSummary = mysql_real_escape_string($_POST["Summary"]);

		if(empty($getImage)){
			mysql_query("REPLACE INTO `Books` ( `ISBN` , `Title` , `Author` , `Genre` , `YearPublished` , `Price` , `CurrentStock` , `Summary` , `TotalSold` , `ImageLink` ) VALUES ('$getISBN','$getTitle','$getAuthor','$getGenre','$getYear','$getPrice','$getStock','$getSummary','$getSold',NULL)")or die(mysql_error());
		}
		else{
			mysql_query("REPLACE INTO `Books` ( `ISBN` , `Title` , `Author` , `Genre` , `YearPublished` , `Price` , `CurrentStock` , `Summary` , `TotalSold` , `ImageLink` ) VALUES ('$getISBN','$getTitle','$getAuthor','$getGenre','$getYear','$getPrice','$getStock','$getSummary','$getSold','$getImage')")or die(mysql_error());
		}

	} 
	elseif ($deleteVar == "Delete") {
  		
		mysql_query("DELETE FROM `Books` WHERE ISBN='$getISBN'")or die(mysql_error());

	}
		
	mysql_close();

?>

<script type="text/javascript">
<!--
	window.location = "Admin.php"
//-->
</script>

</body>
</html>