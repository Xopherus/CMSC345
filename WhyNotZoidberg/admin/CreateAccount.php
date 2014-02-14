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
   						var username = document.forms["createForm"]["Username"].value;
   						var password = document.forms["createForm"]["Password"].value;
						var conf_password = document.forms["createForm"]["Conf_Password"].value;
   						var address = document.forms["createForm"]["Address"].value;
						var city = document.forms["createForm"]["City"].value;
   						var zip = document.forms["createForm"]["Zip"].value;
   
						if(username.length < 8 || username.length > 20){
							alert("Username must be between 8-20 characters.");
							return false;	
						}
						if(password.length < 8 || password.length > 30){
							alert("Password must be between 8-30 characters.");
							return false;	
						}
						if(conf_password.length < 1){
							alert("You must confirm your password.");
							return false;	
						}
						if(password != conf_password){
							alert("Passwords do not match.");
							return false;	
						}
						if(address.length < 1 || address.length > 200){
							alert("Invalid address.");
							return false;	
						}
						if(city.length < 1 || city.length > 20){
							alert("City must be between 1-20 characters.");
							return false;	
						}
						if(zip.length != 5){
							alert("Zip Code must be exactly 5 characters.");
							return false;	
						}
						else{
							for (i = 0 ; i < zip.length ; i++) {
								if (zip.charAt(i) < '0' || zip.charAt(i) > '9'){					
										alert("Zip Code format invalid");
										return false;
								}
							}
						}	
   						return true;
					}
				</script>
				
				<div id="content-area-createAccount">
					<font size="6">Create Account</font><br/><br/>	
					Please provide the following information.<br/><br/>
					<table>
						<form name="createForm" onsubmit="return validate_input()" action="UpdateAccount.php" method="post">
						<tr><td>Username</td><td><input type="text" name="Username" size="20" maxlength="20"/></td></tr>
						<tr><td>Password </td><td><input type="password" name="Password" size="20" maxlength="30"></td></tr>
						<tr><td>Confirm Password</td><td><input type="password" name="Conf_Password" size="20" maxlength="30"></td></tr>
						<tr><td>Address</td><td><input type="text" name="Address" size="20" maxlength="200"></td></tr>
						<tr><td>City</td><td><input type="text" name="City" size="20" maxlength="20"></td></tr>
						<tr><td>Zip Code</td><td><input type="text" name="Zip" size="20" maxlength="5"></td></tr>
						<tr><td colspan="2"><input type="submit" value="Create Account" /></td></tr>
						</form>
					</table>
				</div>
      		</td>
			</tr>
		</table>
		
		<!-- Footer section-->
  		<div id="footer"><a href="aboutPlanetExpress.html">About us</a> &copy; 2012 Why Not Zoidberg</div>
	</div>
</div>
</body>
</html>
