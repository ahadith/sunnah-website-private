<?php 
  $con = mysql_connect("localhost", "ilmfruit_ansari", "ansari") or die(mysql_error()); 
  mysql_select_db("ilmfruit_testhadithdb") or die(mysql_error()); 


 //This code runs if the form has been submitted
  if (isset($_POST['submit'])) { 

   //This makes sure they did not leave any fields blank
    if (!$_POST['username'] | !$_POST['pass'] | !$_POST['pass2'] | !$_POST['email'] ) {
      die('You did not complete all of the required fields');
    }

 // checks if the username is in use
    if (!get_magic_quotes_gpc()) {
      $_POST['username'] = addslashes($_POST['username']);
    }

    $usercheck = $_POST['username'];
    $check = mysql_query("SELECT username FROM users WHERE username = '$usercheck'") 
      or die(mysql_error());

     $check2 = mysql_num_rows($check);

     //if the name exists it gives an error

    if ($check2 != 0) {
      die('Sorry, the username '.$_POST['username'].' is already in use.');
    }

    // this makes sure both passwords entered match

    if ($_POST['pass'] != $_POST['pass2']) {
      die('Your passwords did not match. ');
    }

  // here we encrypt the password and add slashes if needed
  $_POST['pass'] = md5($_POST['pass']);
  if (!get_magic_quotes_gpc()) {
    $_POST['pass'] = addslashes($_POST['pass']);
    $_POST['username'] = addslashes($_POST['username']);
    $_POST['email'] = addslashes($_POST['email']);
  }



   // now we insert it into the database
  $insert = "INSERT INTO users (username, password, email)
      VALUES ('".$_POST['username']."', '".$_POST['pass']."', '".$_POST['email']."')";
  $add_member = mysql_query($insert);

      $to = "sunnahhadith@gmail.com";
      $subject = "New admin user registration ".$_POST['username'];
      $headers = "From: admin@sunnah.com";
      mail($to, $subject, $_POST['username'].": ".$_POST['email'], $headers);

?>



 
 <h1>Registered</h1>

 <p>Jazakallahu khair, you have registered - <a href="/admin">you may now login</a>.</p>

<?php 
 } 

 else 
 {  
 ?>


 
 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
   <table border="0">
   <tr><td>Username:</td><td>
   <input type="text" name="username" maxlength="60">
   </td></tr>
   <tr><td>Password:</td><td>
   <input type="password" name="pass" maxlength="10">
   </td></tr>
   <tr><td>Confirm Password:</td><td>
   <input type="password" name="pass2" maxlength="10">
   </td></tr>
   <tr><td>Email address:</td><td>
   <input type="text" name="email" maxlength="100" size=20>
   </td></tr>
   <tr><th colspan=2><input type="submit" name="submit" value="Register"></th></tr> </table>
 </form>


 <?php

 }
 ?> 
