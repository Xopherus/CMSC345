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
	<link rel="stylesheet" href="themes/default/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="nivo-slider.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
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
      			<!-- Check to see if popGenre.php works-->
      			<?php
      				include_once "popGenre.php";
      			?>
      		</td>
      			
      		<!-- Middle content area -->	
    		<td valign="top" id="content-area"><h1>Featured Advertisements </h1>
		
			  <div class="slider-wrapper theme-default">
            	<div id="slider" class="nivoSlider">
                	<img src="image/zoidberg-scream.jpg" data-thumb="image/zoidberg-scream.jpg" alt="" />
                	<img src="image/Lightspeed-Briefs.jpg" data-thumb="image/Lightspeed-Briefs.jpg" alt="" />
                	<img src="image/extreme-walrus-juice.png" data-thumb="image/extreme-walrus-juice.png" alt=""/>
                	<img src="image/molten-boron.png" data-thumb="image/molten-boron.png" alt="" />
					<img src="image/bachelor-chow.jpg" data-thumb="image/bachelor-chow" alt="" />
            	</div>
        	</div>
			
	    	<script type="text/javascript" src="scripts/jquery-1.7.1.min.js"></script>
    		<script type="text/javascript" src="jquery.nivo.slider.js"></script>
    		<script type="text/javascript">
				$(window).load(function(){
					$('#slider').nivoSlider({
						effect: 'fade', // Specify sets like: 'fold,fade,sliceDown'
						slices: 15, // For slice animations
						boxCols: 8, // For box animations
						boxRows: 4, // For box animations
						animSpeed: 500, // Slide transition speed
						pauseTime: 3000, // How long each slide will show
						startSlide: 0, // Set starting Slide (0 index)
						directionNav: true, // Next & Prev navigation
						directionNavHide: true, // Only show on hover
						controlNav: true, // 1,2,3... navigation
						controlNavThumbs: false, // Use thumbnails for Control Nav
						pauseOnHover: true, // Stop animation while hovering
						manualAdvance: false, // Force manual transitions
						prevText: 'Prev', // Prev directionNav text
						nextText: 'Next', // Next directionNav text
						randomStart: false, // Start on a random slide
						beforeChange: function(){}, // Triggers before a slide transition
						afterChange: function(){}, // Triggers after a slide transition
						slideshowEnd: function(){}, // Triggers after all slides have been shown
						lastSlide: function(){}, // Triggers when last slide is shown
						afterLoad: function(){} // Triggers when slider has loaded
					});
				});
    		</script>
	
			<!-- Just testing some text in content area-->
      		<p>Pop a poppler in your mouth when you come to Fishy Joe's<br>
      			What they're made of is a mystery<br>
      			Where they come from no one knows <br>
      			You can pick 'em, you can lick 'em<br>
      			You can chew 'em, you can stick 'em<br>
      			If you promise not to sue us you can shove one up your nose</p>
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
