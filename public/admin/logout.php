<?php 
  $past = time() - 100; 
  //this makes the time in the past to destroy the cookie 

  setcookie(ID_ilmfruits_hadith, gone, $past); 
  setcookie(Key_ilmfruits_hadith, gone, $past); 

  header("Location: index.php"); 
?> 
