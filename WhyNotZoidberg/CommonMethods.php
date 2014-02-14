<?php
  /*
   * Christopher Raborg - Project 1, CMSC 331
   *
   * CommonMethods.php holds the essential mySQL functions as well as methods
   * used for error checking data before inserting it 
   */


# This class of functions is used to gather user input from the addSyllabus
# page.
class Common
{
   var $conn;
   var $debug;

   // Does something with debugging?
   function Common($debug){
      $this->debug = $debug;
      $result = $this->connect("craborg1");
      return $result;
   }

   // Connects to MySQL
   function connect($database){
      $conn = mysql_connect("studentdb.gl.umbc.edu", "craborg1", "craborg1") 
	 or die("Could not connect to MySQL" . mysql_error());

      $result = mysql_select_db($database, $conn)
	 or die("Could not select $database database");
      $this->conn = $conn;
   }

   // Executes a query
   function executeQuery($query, $filename){
      if($this->debug == true)
         echo("$query <br/>\n");

      $result = mysql_query($query, $this->conn)
         or die("Could not execute query " . $query . "in" . $filename);

      return $result;
   }
}
?>