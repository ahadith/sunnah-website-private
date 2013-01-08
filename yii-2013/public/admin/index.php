<?php 

 // Connects to your Database 
  $con = mysql_connect("localhost", "ilmfruit_ansari", "ansari") or die(mysql_error());
  mysql_select_db("ilmfruit_testhadithdb") or die(mysql_error());

  //Checks if there is a login cookie
  if(isset($_COOKIE['ID_ilmfruits_hadith']))
     //if there is, it logs you in and directes you to the members page
    { 
      $username = $_COOKIE['ID_ilmfruits_hadith']; 
      $pass = $_COOKIE['Key_ilmfruits_hadith'];
      $check = mysql_query("SELECT * FROM users WHERE username = '$username'")or die(mysql_error());
      while($info = mysql_fetch_array( $check )){
        if ($pass != $info['password']) {
            }
        else  header("Location: home.php");
      }
    }


  //if the login form is submitted 
  if (isset($_POST['submit'])) { // if form has been submitted
    // makes sure they filled it in
    if(!$_POST['username'] | !$_POST['pass']) {
      die('You did not fill in a required field.');
    }

	if (!(strpos($_POST['username'], '\'') === false) or !(strpos($_POST['pass'], '\'') === false))
		die('No single quotes allowed!');

    $check = mysql_query("SELECT * FROM users WHERE username = '".$_POST['username']."'")or die(mysql_error());

    //Gives error if user dosen't exist

    $check2 = mysql_num_rows($check);
    if ($check2 == 0) {
      die('That user does not exist in our database');
    }

    while($info = mysql_fetch_array( $check )){
      $_POST['pass'] = stripslashes($_POST['pass']);
      $info['password'] = stripslashes($info['password']);
      $_POST['pass'] = md5($_POST['pass']);

      //gives error if the password is wrong
      if ($_POST['pass'] != $info['password']) {
        die('Incorrect password, please try again.');
      }
      else { 
        // if login is ok then we add a cookie 
        $_POST['username'] = stripslashes($_POST['username']); 
        $hour = time() + 7*86400; 
        setcookie(ID_ilmfruits_hadith, $_POST['username'], $hour); 
        setcookie(Key_ilmfruits_hadith, $_POST['pass'], $hour);  

        //then redirect them to the members area 
        header("Location: home.php"); 
      } 
    } 
  } 
  else {  
    // if they are not logged in 
?> 

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
  <table border="0"> 
  <tr><td colspan=2><h1>Login</h1></td></tr> 
  <tr><td>Username:</td><td> 
  <input type="text" name="username" maxlength="40"> 
  </td></tr> 
  <tr><td>Password:</td><td> 
  <input type="password" name="pass" maxlength="50"> 
  </td></tr> 
  <tr><td colspan="2" align="right"> 
  <input type="submit" name="submit" value="Login"> 
  </td></tr> 
  </table> 
</form> 
<?php 
} 
?> 

