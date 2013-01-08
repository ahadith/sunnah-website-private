<?php 
	$path = dirname(__FILE__)."/about/".$this->_collectionName.".php";
	if (realpath($path)) include "about/".$this->_collectionName.".php";
	else echo "Either the collection name is invalid, or we haven't yet added information for this collection yet. Please bear with us."."about/".$this->_collectionName.".php";
?>
