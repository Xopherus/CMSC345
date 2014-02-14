<?php

/*
 * Defines an item which has an ISBN (unique identifier), quantity, price, title and image link
 * Basically all info required to display the item in the shopping cart and checkout menus 
 */
class Item{
	
	var $ISBN;
	var $quantity;
	var $price;
	var $title;
	var $imageLink;
	
	/*
	 * Creates an instance of an item
	 * $ISBN - the unique identifier of a book
	 * $quantity - the number of copies of the book
	 */
	function Item($ISBN, $quantity, $price, $title, $imageLink){
		$this->ISBN = $ISBN;
		$this->quantity = $quantity;
		$this->price = $price;
		$this->title = $title;
		$this->imageLink = $imageLink;
		return $this;
	}
	
	/*
	 * Returns the ISBN of an item
	 * @return ISBN
	 */
	function getISBN(){
		return $this->ISBN;
	}
	
	/*
	 * Returns the quantity of an item
	 * @return quantity
	 */
	function getQuantity(){
		return $this->quantity;
	}
	
	/*
	 * Returns the price of the item
	 * @return price
	 */
	function getPrice(){
		return $this->price;
	}
	 
	/*
	 * Returns the title of the item
	 * @return title
	 */ 
	function getTitle(){
		return $this->title;
	}
	  
	/*
	 * Returns the item image
	 * @return imageLink
     */ 
	function getImage(){
		return $this->imageLink;
	}
	   
	   
	function addQuantity($add){
		$this->quantity += $add;
	}   
	   
	/*
	 * Changes the quantity of an item, returns false if $newQuantity is negative
	 * $newQuantity - the new quantity
	 */
	function changeQuantity($newQuantity){
		if($newQuantity < 0)
			return FALSE;
		else
			$this->quantity = $newQuantity;
	}
	
	/*
	 * A toString method (for testing)
	 */
	function toString(){
		echo("Book: $this->ISBN, Quantity: $this->quantity <br/>");
	}
	
}
?>