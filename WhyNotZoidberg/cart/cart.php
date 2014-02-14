<?php
	include_once 'item.php';
	
class Cart{
	
	var $cart;
	var $size;
	var $total;

	/*
	 * Creates an instance of the cart
	 * @return $this->cart, the shopping cart
	 */
    function Cart(){
    	$this->size = 0;
		$this->total = 0;
		$this->cart = array();
		return $this;		
    }
	
	/*
	 * Returns the item at a particular index
	 * $index - the index of the item in the array
	 * @return an item
	 */
	function getItem($index){
		return $this->cart[$index];	
	}
	
	/*
	 * Returns the first item from the cart
	 * @return - the first item in the cart
	 */
	function getNextItem(){
		return $this->cart[0];
	}
	
	/*
	 * Returns the total price of all of the items in the shopping cart 
	 */
	function getTotal(){
		return $this->total;	
	}
	
	/*
	 * Adds an item to the shopping cart 
	 * $item - the database entry of the item
	 * $quantity - the number of copies of an item to be purchased
	 */
	function addItem($item, $quantity){
		// If the quantity is invalid, do something
		if($quantity < 0)
			return FALSE;
		else{
			$index = $this->findItem($item['ISBN']);
			// If the item is already in the cart, add the quantity to the original quantity
			if($index != -1){
				// Calculate the new total quantity
				$item = $this->getItem($index);
				$quantity += $item->getQuantity();				
				$this->editQuantity($index, $quantity);
			}
			else{
				$newItem = new Item($item['ISBN'], $quantity, $item['Price'], $item['Title'], $item['ImageLink']);
				array_push($this->cart, $newItem);
				$this->size++;
				$this->total += ($newItem->getPrice() * $newItem->getQuantity());
			}
		}
	}
	
	/*
	 * Edits the quantity of an item in the shopping cart
	 * $ISBN - the item to edit the quantity of
	 * $newQuantity - the new quantity of the item 
	 * @return the updated shopping cart
	 */
	function editQuantity($index, $newQuantity){
		// if the item is contained in the array, update its quantity
		if($index >= 0 && $index < $this->size){
			// Get the item in the array
			$item = $this->getItem($index);
			
			// Subtract the item's price total from the total price of the cart
			$this->total -= ($item->getPrice() * $item->getQuantity());
			
			// Change the quantity of the original item and assign it back to the cart
			$item->changeQuantity($newQuantity);
			$this->cart[$index] = $item;
			
			// Add the item's new price total to the total price of the cart
			$this->total += ($item->getPrice() * $item->getQuantity());
		}
	}
	
	/*
	 * Removes an item from the shopping cart
	 * $ISBN - the identifier for the item to be deleted
	 * @return the updated shopping cart
	 */
	function removeItem($index){
		// If the item is found, remove it from the cart, otherwise do nothing
		if($index >= 0 && $index < $this->size){
			$item = $this->getItem($index);
			
			// Subtract the item's price total from the total price of the cart
			$this->total -= ($item->getPrice() * $item->getQuantity());
					
			array_splice($this->cart, $index, 1);
	
			// Decrement the size of the cart
			$this->size--;
		}
	}
	
	/*
	 * Prints a particular item in the shopping cart
	 */
	function printItem($ISBN){
		$index = $this->findItem($ISBN);
		$this->cart[$index]->toString();
	}
	
	/*
	 * Returns true if the cart is empty
	 */
	function isEmpty(){
		if($this->size == 0)
			return TRUE;
		return FALSE;
	}
	
	/*
	 * Returns the size of the shopping cart
	 * @return size
	 */
	function getSize(){
		return $this->size;
	}
	
	/*
	 * Searches for an item with a given ISBN and returns the index where it is located in the shopping cart
	 * $ISBN - the ISBN to search for
	 * @return the index where it is located, -1 if not found
	 */
	function findItem($ISBN){
		for($i = 0; $i < $this->size; $i++){
			$nextItem = $this->cart[$i];
			
			// If the ISBNs are matching, return the index
			if(strcmp($nextItem->getISBN(), $ISBN) == 0)
				return $i;
		}
		// If the item was not found, return -1
		return -1;
	}
	
}


?>