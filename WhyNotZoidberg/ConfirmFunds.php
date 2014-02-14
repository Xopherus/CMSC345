<?php 
	include_once 'cart/cart.php';
	session_start(); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Why Not Zoidberg?</title>
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
					<div id="account"><a href="../Admin.php">Control Panel</a></div>
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
				<div id="account"><a href="../CreateAccount.php">Create Account</a></div>
				<div id="log-out"><a href="../GetLogin.html">Login</a></div>
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
					$getUsername = $_SESSION['username'];
					$getFundInput = $_POST['Fund'];
					
					mysql_connect("studentdb.gl.umbc.edu", "craborg1", "craborg1") or die(mysql_error());
					mysql_select_db("craborg1") or die("Could not connect to database");
				
					$result = mysql_query("SELECT * FROM `Account` WHERE Username='$getUsername'");
					$row = mysql_fetch_array($result);
				
					echo "<h1>Are you sure you wish to add $$getFundInput?</h1>";
				
				?>
					<script type="text/javascript">
						var audio = new Audio("sound/sound.wav"); audio.play();
					</script>
			
					<br/><img src="http://i2.kym-cdn.com/photos/images/original/000/264/241/9e9.gif" width="400" height="200"><br/><br/>
					
					<?php
				
				     	if ($_POST['submit'])  
				     	{
							$updatedFunds = $_POST['Funds'] + $row['Funds'];
							mysql_query("UPDATE `Account` SET `Funds` = '$updatedFunds' WHERE `Username` = '$getUsername'")or die(mysql_error());
							mysql_close();
					?>
						<script type="text/javascript">
							window.location = "index-build.php"
						</script>
					<?php
				     	}
					?>
					<form method="post" action="">
						<input type="hidden" name="Funds" value="<? echo $getFundInput; ?>">
						<input type="Submit" name="submit" value="Shut Up and Take My Money!">
					</form>
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
