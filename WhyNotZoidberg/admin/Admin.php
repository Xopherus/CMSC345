<?php 
	session_start(); 
?>

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
					<div id="log-out"><a href="logout.php">Logout</a></div>
					<div id="account"><a href="Admin.php">Control Panel</a></div>
		<?php			
				}
				//If you're just a registered user you can logout and view account
				else
				{
		?>
					<div id="log-out"><a href="logout.php">Logout</a></div>
					<div id="account"><a href="../viewAccount.php">View Account</a></div>
		<?php	
				}
			}
			//If you're not a registered user then you can only create account and login
			else 
			{
		?>
				<div id="account"><a href="CreateAccount.php">Create Account</a></div>
				<div id="log-out"><a href="getLogin.php">Login</a></div>
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
    		<td valign="top">
				<script language = "JavaScript" type = "text/javascript">
					function is_int(){
					   var x = document.forms["bookForm"]["ISBN"].value;
					   for (i = 0 ; i < x.length ; i++) {
					      if ((x.charAt(i) < '0') || (x.charAt(i) > '9')) 
							return false; 
					   } 	
					   return true;
					}
				</script>
				<?php
					// If the user is a customer or not logged in, they CANNOT access the admin page. Redirect them to the home page
					if(!isset($_SESSION['username']) || $_SESSION['admin'] == 'no'){
				?>
						<script language="JavaScript" type="text/javascript">
							window.location = "../index-build.php";
						</script>
				<?php
					}
					echo('<div id="content-area-admin">');
						echo('<font size="6">Welcome, Ms. Matthews!</font><hr/><br><br><br>');
						echo('<form name="bookForm" action="UpdateDelete.php" onsubmit="return is_int()" method="post">');
						echo('Please enter an ISBN to start editing the inventory.' . 
							 '<input type="text" name="ISBN" size="20" pattern=".{10}" title="ISBN must be exactly 10 numbers"/>' . 
							 '<input type="submit" value="Go"/>');
						echo('</form><br><br><br><br>');
	
						mysql_connect("studentdb.gl.umbc.edu", "craborg1", "craborg1") or die(mysql_error());
						mysql_select_db("craborg1") or die("Could not connect to database");
						$query = "SELECT * FROM `Books` ORDER BY `TotalSold` DESC LIMIT 0 , 5";
					
						$result = mysql_query($query) or die("Could not complete query");
						$curBook = 1;
						
						// Print out the top selling items table
						echo('<div>');
							echo('<table border="1" width="100%" cellpadding="15">');
							echo('<th colspan="4">Top 5 Selling Books:</th>');
							echo('<tr><td>Rank</td><td>ISBN</td><td>Title</td><td>Copies Sold</td></tr>');
							
							while($row = mysql_fetch_array($result)){
								echo '<tr><td>' .  $curBook . '.) </td>' . '<td>' . $row['ISBN'] . '</td>' . 
									 '<td>' . $row['Title'] . '</td>' . '<td>' . $row['TotalSold'] . '</td></tr>';
								$curBook++;
							}
							echo('</table><br><br><br>');
						echo('</div>');
					
						mysql_close();
					echo('</div>');

				?>
      		</td>
			</tr>
		</table>
		
		<!-- Footer section-->
  		<div id="footer"><a href="../aboutPlanetExpress.html">About us</a> &copy; 2012 Why Not Zoidberg</div>
	</div>
</div>
</body>
</html>
