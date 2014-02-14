<?php

/*
 * This php code will display the search results
 */
include_once('connect.php');
include_once 'cart/cart.php';
session_start();

function displayResults($result)
{
	//Check to see if the query was sucessful or not in the first place
	if(mysql_num_rows($result) == FALSE)
	{
		//Probably gonna replace this with a hilarious image
		echo("<br><h1>Could not find item in store, but here's a suggestion:</h1>");
		echo("<img src=image/404-Error.jpg>");
	}
	//If there are results from the query, display all the books found
	else
	{
		//Fetch the number of books found
		$numBooksFound = mysql_num_rows($result);
		
		//Setup table
		echo("<table id='searchResult' width='100%' border='0' cellpadding='10' cellspacing='0'>");
		
		//Setup the form and input type to make the book ISBN send value to browse.php
		echo("<form name='browseForm' method='post' action='browse.php'>");
		echo("<input type='hidden' name='productType' />");
		
		for($x = 0; $x < $numBooksFound; $x++)
		{
			$title = mysql_result($result, $x, 1);
			$imageLink = mysql_result($result, $x, 8);
			$ISBN = mysql_result($result, $x, 0);
			
			//If the image link is NULL, set it to the default image path
			if($imageLink == NULL)
			{
				$imageLink = "image/defaultBookImage.png";
			}
			
			echo("<tr class='content'>");
			echo("<td>");
?>

		<!--This script helps makes a link send a form with the value = book title-->
		<script language="JavaScript" type="text/javascript">
	
		function getProduct ( selectedType )
		{
  			document.browseForm.productType.value = selectedType ;
  			document.browseForm.submit() ;
		}
		
		</script>
		
<?php

			echo("Title: ");
			echo("<a href= 'javascript:getProduct(\"" . $ISBN . "\")'>" . $title . "</a>");
			
			echo("<br>Author: " . mysql_result($result, $x, 2) . "<br>");
			echo("Genre: " . mysql_result($result, $x, 3) . "<br>");
			echo("ISBN: " . mysql_result($result, $x, 0));
			echo("</td>");
			
			echo("<td align='right'>");
			echo("<a href= 'javascript:getProduct(\"" . $ISBN . "\")'>");
			echo("<img src=" . $imageLink . " width = '150' height= '150'>");
			echo("</a>");
			echo("</td>");
			
			echo("</tr>");
		}
		
		echo("</form>");
		echo("</table>");
		 
	}//This was the end of the else statement previously
}

$searchOption = $_POST["searchOption"]; //Name of the drop down bar back in index-build.html
$searchRequest = $_POST["searchBar"]; //Name of the search bar back in index-build.html

$query; //Store the string for the query

if($searchOption == "Title")
{
	//$query = "SELECT * FROM Books WHERE Title = '$searchRequest'";
	$query = "SELECT * FROM Books WHERE Title LIKE '%$searchRequest%'";
}
elseif ($searchOption == "Author")
{
	//$query = "SELECT * FROM Books WHERE Author = '$searchRequest'";
	$query = "SELECT * FROM Books WHERE Author LIKE '%$searchRequest%'";
}
elseif ($searchOption == "Genre")
{
	//$query = "SELECT * FROM Books WHERE Genre = '$searchRequest'";
	$query = "SELECT * FROM Books WHERE Genre LIKE '%$searchRequest%'";
}
else
{
	//$query = "SELECT * FROM Books WHERE ISBN = '$searchRequest'";
	$query = "SELECT * FROM Books WHERE ISBN LIKE '%$searchRequest%'";
}

//Perform query
$result = mysql_query($query);

?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Why Not Zoidberg? : Search Results</title>
	<link rel="icon" type="image/png" href="image/favicon.ico" />
	<link href="store-style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="themes/default/default.css" type="text/css" media="screen" />	
	<link type="text/css" rel="stylesheet" href="pajinate-style.css" />
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
    			
    			<!-- Display the random popular genres on the left sidebar -->
      			<?php
      			
      				include_once "popGenre.php";
      				
      			?>
      		</td>
      			
      		<!-- Middle content area -->	
			<!-- Display search results here-->

			<script type="text/javascript" src="scripts/jquery-1.7.1.min.js"></script>
			<script type="text/javascript" src="jquery.pajinate.js"></script>
			<script type="text/javascript">
				$(document).ready(function(){
					$('#paging_container1').pajinate({
						items_per_page: 10,
						num_page_links_to_display : 6
					});
				});
			</script>

			<td valign="top" id="content-area"><h1>Search Results</h1>
				<div id="paging_container1" class="container">		
						<div class="page_navigation"></div><br>	
							<?php
		      					displayResults($result);
		      				?>
		      			<br><div class="page_navigation"></div>
				</div>
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