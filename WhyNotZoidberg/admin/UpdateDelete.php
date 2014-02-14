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
					function validate_input(){
					   	var title = document.forms["adminForm"]["Title"].value;
					   	var author = document.forms["adminForm"]["Author"].value;
					   	var year = document.forms["adminForm"]["YearPublished"].value;
					   	var genre = document.forms["adminForm"]["Genre"].value;
					   	var price = document.forms["adminForm"]["Price"].value;
					   	var stock = document.forms["adminForm"]["CurrentStock"].value;
					   	var summary = document.forms["adminForm"]["Summary"].value;
				   
					    // Validate the title textfield
						if(title.length < 1 || title.length > 255){
							alert("The title must be between 1 - 255 characters, inclusive.");
							return false;	
						}
						// Validate the author textfield
						if(author.length < 1 || author.length > 50){
							alert("The author must be between 1 - 50 characters, inclusive.");
							return false;	
						}
						// Validate the year textfield
						if(year.length != 4){
							alert("The year must consist of 4 numbers.");
							return false;	
						}
						else{
							for (i = 0 ; i < year.length ; i++) {		
								if ((year.charAt(i) < '0') || (year.charAt(i) > '9')){
									alert("The year must consist of 4 numbers.");
									return false;
					 	   		}
							}
						}
						// Validate the genre textfield
						if(genre.length < 1 || genre.length > 15){
							alert("Genre must be between 1 - 15 characters.");
							return false;	
						}
						// Validate the price textfield
						if(price.length < 1 || price.length > 6){
							alert("The total price must be between 1 and 6 characters, including the decimal point.");
							return false;	
						}
						else{
							if(price.length == 1){
								if (price.charAt(0) < '0' || price.charAt(0) > '9'){
									alert("The price must be a number.");
									return false;
								}
							}
							else{
								for (i = 0 ; i < price.length ; i++) {	
									if (price.charAt(i) < '0' || price.charAt(i) > '9'){
										if(price.charAt(i) != '.'){
											alert("The price must be between 0.00 and 999.99, inclusive. No currency labels, please.");
											return false;
										}
					 	   			}
								}
							}
						}
						if(+price < 0 || +price >= 1000){
							alert("The price must be a value between 0 - 999.99, inclusive.");
							return false;
						}
						// Validate the current stock textfield
						if(stock.length < 1 || stock.length > 5){
							alert("The current stock must be a number with 1 - 5 numbers. ");
							return false;	
						}
						else{
							for (i = 0 ; i < stock.length ; i++) {		
								if ((stock.charAt(i) < '0') || (stock.charAt(i) > '9')){
									alert("The current stock must be a number. ");
									return false;
					 	   		}
							}
						}
						if(+stock < 0 || +stock > 65535){
							alert("The current stock must be a value between 0 - 65535 inclusive.");
							return false;
					
						}
						// Validate the summary textfield
						if(summary.length < 1 || summary.length > 65535){
							alert("The summary is too long. Please shorten the summary. ");
							return false;	
						}
					   	return true;
					}
					</script>
					<?php
						// If the user is a customer or not logged in, they CANNOT access this page. Redirect them to the home page
						if(!isset($_SESSION['username']) || $_SESSION['admin'] == 'no'){
					?>
						<script language="JavaScript" type="text/javascript">
							window.location = "../index-build.php";
						</script>
					<?php
					}
						$getISBN = $_POST["ISBN"];
					
						mysql_connect("studentdb.gl.umbc.edu", "craborg1", "craborg1") or die(mysql_error());
						mysql_select_db("craborg1") or die("Could not connect to database");
					
						$result = mysql_query("SELECT * FROM `Books` WHERE ISBN='$getISBN'");
						$row = mysql_fetch_array($result);
					
						// Display the Add/Edit/Delete a Book page
						echo('<div id="editBookPage">');
							echo('<font size="6">Add/Edit/Delete</font><hr/><br/>'); 
							echo('<form name="adminForm" onsubmit="return validate_input()" method="post" action="AdminSubmit.php">');
							
							echo('<input type="hidden" name="ISBN" value="' . $getISBN . '">');
							echo('<input type="hidden" name="TotalSold" value="' . $row['TotalSold'] . '">');
							
							echo('<div>');
								echo('<div id="bookForm">');
									echo('<table cellpadding="10">');
										echo('<tr><td><b>ISBN: </b></td><td>' . $getISBN . '</td></tr>');
										echo('<tr><td><b>Title: </b></td><td><input type="text" name="Title" value="' . $row['Title'] . '"></td></tr>');
							    		echo('<tr><td><b>Author: </b></td><td><input type="text" name="Author" value="' . $row['Author'] . '"</td></tr>');
						    			echo('<tr><td><b>Year Published: </b></td><td><input type="text" name="YearPublished" value="' . $row['YearPublished'] . '"></td></tr>');
						    			echo('<tr><td><b>Genre: </b></td><td><input type="text" name="Genre" value="' . $row['Genre'] . '"></td></tr>');
										echo('<tr><td><b>Price: </b></td><td><input type="text" name="Price" value="' . $row['Price'] . '"></td></tr>');
										echo('<tr><td><b>Current Stock: </b></td><td><input type="text" name="CurrentStock" value="' . $row['CurrentStock'] . '"></td></tr>');
									echo('</table>');
								echo('</div>');
									
								echo('<div id="bookForm">');	
									echo('<table cellpadding="10">');
										// Display the book image
										if(!is_null($row['ImageLink'] ) || !empty($row['ImageLink'])){
											echo('<tr><td colspan="2"><img src="' . $row['ImageLink'] . '" alt="Bad URL" width="200" height="250"></td></tr>');
										}
										else{
											echo('<tr><td colspan="2"><img src="../images/defaultBookImage.png" width="200" height="250"></td></tr>');
										}
										echo('<tr><td><b>Image Link: </b></td><td><input type="text" size="50" name="Image" value="' . $row['ImageLink'] . '"></td></tr>');
										
									echo('</table>');
								echo('</div>');
							echo('</div>');
							
							echo('<div>');
								echo('<div id="bookSummary">');
									echo('<table cellpadding="10">');
										echo('<tr><td><b>Summary: </b></td></tr>');
										echo('<tr><td><textarea name="Summary" cols="80" rows="8">' . $row['Summary'] . '</textarea></td></tr>');
									echo('</table>');
								echo('</div>');
								
								echo('<div id="bookSummary">');
									echo('<input name="Update Book Information" type="submit" value="Update"> <input name="Delete Book from Inventory" type="submit" value="Delete">');
								echo('</div>');
							echo('</div>');
							
							echo('</form>');
						echo('</div>');
						
						mysql_close();
	
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
