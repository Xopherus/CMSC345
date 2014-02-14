<?php

// Declared Constants ---------------------------------------------------------
$BOOKS = 4;
$FILE = $_SERVER["popGenre.php"];

// ----------------------------------------------------------------------------

/*
  Function queries database for genres and returns genres in an array
 */
function getGenres($COMMON){
   $genres = array();

   $query = 'SELECT DISTINCT `Genre` FROM `Books`';
   $result = $COMMON->executeQuery($query, $FILE); 

   // Convert genres relation to an array
   while($nextGenre = mysql_fetch_array($result))
      array_push($genres, $nextGenre['Genre']);

   return $genres;
   
}

/*
  Function queries database for books in a given genre, returns array of ISBNs, ImageLinks
 */
function getBooks($COMMON, $genre){
   $books = array();

   $query = 'SELECT `ISBN`, `Title`, `ImageLink` FROM `Books` WHERE `Genre` = "' . $genre . '"';
   $result = $COMMON->executeQuery($query, $FILE);

   // Convert books relation to an array
   while($nextBook = mysql_fetch_array($result)){
      if($nextBook['ImageLink'] == NULL)
	  $nextBook['ImageLink'] = "image/defaultBookImage.png";
      array_push($books, $nextBook);
   }

   return $books;
}

/*
  Function queries database and returns an array of randomly chosen genres
 */
function getRandomGenres($COMMON){
   // Run database query to return an array of genres
   $genres = getGenres($COMMON);
   $randomGenres = array();

   for($i = 0; $i < 3; $i++){

	// If there are no genres remaining, stop
	if(sizeof($genres) > 0){
      		// Select a random genre from the array
      		$nextGenre = $genres[rand(0, sizeof($genres) - 1)];
      
      		// Remove chosen genre from array
      		array_splice($genres, array_search($nextGenre, $genres), 1);

      		// Add chosen genre to result
      		array_push($randomGenres, $nextGenre);
	}
   }
   return $randomGenres;
}

/*
  Function queries database and returns an array of randomly chosen books from
  a particular genre.
 */
function getRandomBooks($COMMON, $genre){
   $books = getBooks($COMMON, $genre);
   $randomBooks = array();

   for($i = 0; $i < 4; $i++){

	// If there are no books remaining, stop
      	if(sizeof($books) > 0){
      		// Select a random genre from the array
      		$nextBook = $books[rand(0, sizeof($books) - 1)];
      
      		// Remove chosen genre from array
      		array_splice($books, array_search($nextBook, $books), 1);

      		// Add chosen genre to result
      		array_push($randomBooks, $nextBook);
	}
   }
   return $randomBooks;
}

/*
 Function displays a module which will contain 4 randomly selected books from a given genre in a 2x2 table.
 Each book will have an image and the title displayed, and there will be links to view each book in more detail.
 */
function displayBooks($COMMON, $genre, $books){
   $counter = 0;

   echo("<table class=pGenre>");
   echo('<th id="pGenre" colspan="2">' . $genre . ' Books:</th>');

   // Double for-loop prints 2 x 2 grid of randomly selected books
   for($i = 0; $i < 2; $i++){
	echo("<tr>");
	for($j = 0; $j < 2; $j++){
		if($counter < sizeof($books)){
			$nextBook = $books[$counter];
			// Set PHP Session variable with ISBN
			printBook($nextBook);
		}
		else{
			echo("<td class pGenre></td>");
		}
		$counter++;
	}
	echo("</tr>");
   }
   
   echo("</table><br>");
}

/*
 Function prints a clickable image of a book and the title

function printBook($book){
	echo('<td class=pGenre><a class=pGenre href="browse.php">' .
	'<div id="book">
		<img class=clickableBook; src="' . $book['ImageLink'] . '" width="80" height="80">' .
		'<p class=center><font class=booktext>' . $book['Title'] . '</font></p>' .
	'</div> </a></td>');
}
*/

function printBook($book){
	
	echo('<td class=pGenre>');
	echo('<div id="book">');
	
?>

<!--This script helps makes a link send a form with the value = book title-->
<script language="JavaScript" type="text/javascript">
	
function getProduct ( selectedType )
{
  	document.popGenreForm.productType.value = selectedType ;
  	document.popGenreForm.submit() ;
}
		
</script>

<?php
	
	echo("<a href= 'javascript:getProduct(\"" . $book['ISBN'] . "\")' title='" . $book['Title']. "'>");
	echo('<img class=clickableBook; src="' . $book['ImageLink'] . '" width="80" height="80" alt="'. $book['Title'] .'">');
	echo("</a>");
	
	//echo("<p class=center><font class=booktext>");
	//echo("<a href= 'javascript:getProduct(\"" . $book['ISBN'] . "\")'>" . $book['Title'] . "</a>");
	//echo("</p>");
	echo('</div></td>');
}

/*
 Function displays the popular genres toolbar
 */

function displayPopGenres($COMMON){
	echo('<link rel="stylesheet" type="text/css" href="popGenre.css" /></head>');
   	$genres = getRandomGenres($COMMON);
   	for($i = 0; $i < sizeof($genres); $i++){
       	$nextGenre = $genres[$i];
       	$books = getRandomBooks($COMMON, $nextGenre);
		displayBooks($COMMON, $nextGenre, $books);     
   	}
}


$debug = false;
include_once("CommonMethods.php");
$COMMON = new Common($debug);

//Setup the form and input type to make the book ISBN send value to browse.php
echo("<form name='popGenreForm' method='post' action='browse.php'>");
echo("<input type='hidden' name='productType' />");
displayPopGenres($COMMON);
echo("</form>");

?>