<?php

include_once('CommonMethods.php');
include_once 'cart/cart.php';
session_start();

/*
 * Retrieves the database record with all of the customer info to display 
 * $username - the name of the customer who has the account
 */
function getUserData($COMMON, $username){
	$query = 'SELECT * FROM `Account` WHERE `Username` = "' . $username . '"';
	$result = $COMMON->executeQuery($query, $_SERVER['viewAccount.php']);		
	
	return mysql_fetch_array($result);
}

/*
 * Function displays the account page for customers.
 */
function displayAccountInfo($COMMON, $loginName){
	$userdata = getUserData($COMMON, $loginName);
	//echo("<div id='account'>");
	echo('<h1>Welcome, ' . $userdata['Username'] . '!</h1>');
	echo('<hr/>');
	echo('<h2>Your balance is : <b>$' . $userdata['Funds'] . '</b></h2>');
?>
	<!-- Button for add funds -->
	<button onclick="redirectMain()">Add Funds</button>
	
<?php
	
	echo('<br/>');
	echo('<h2>Current Address: </h2>');
	echo('<h3>' . $userdata['Address'] . '</h3>');
	echo('<h3>' . $userdata['City'] . ', ' . $userdata['Zipcode'] . '</h3>');
	//echo("</div>");
}

$debug = false;
$COMMON = new Common($debug);

$username = $_SESSION['username'];
?>

<script language = "JavaScript" type = "text/javascript">

function redirectMain(){
	window.location = "AddFunds.php"
}

</script>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Why Not Zoidberg? : View Account</title>
	<link rel="icon" type="image/png" href="image/favicon.ico" />
	<link href="store-style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<!-- Wrapper = whole general website -->
<div id="wrapper">

	<!-- Header area -->
	<div id="header">
    	<div id="logo"><a href="index-build.php"><img src="image/logo-zoidberg.png" width="180" height="180" border="0" /></a></div>
    	
    	<?php
    		if(isset($_SESSION['username']))
			{
				
		?>
				<div id="log-out"><a href="admin/logout.php">Logout</a></div>
				<div id="account"><a href="viewAccount.php">View Account</a></div>
		<?php
			}
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
    				// If the user is an admin or not logged in, they CANNOT access the view account page. They will be redirected to the home page
    				if(isset($_SESSION['username']) && $_SESSION['admin'] == 'no'){
						displayAccountInfo($COMMON, $username);
					}
					else{
				?>
				<script language="JavaScript" type="text/javascript">
					window.location = "index-build.php";
				</script>		
				<?php
					}
				?>
    			
      		</td>
      		
      		<!-- Right sidebar -->
    		<td valign="top" id="sidebar-right"><h1>Shopping  Cart </h1>
    		<?
				include_once 'cart/miniCart.php';
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