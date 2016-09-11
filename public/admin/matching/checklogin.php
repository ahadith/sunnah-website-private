<?php
  $con = mysql_connect("localhost", "ilmfruit_ansari", "ansari") or die(mysql_error());
  mysql_select_db("ilmfruit_testhadithdb") or die(mysql_error());
  mysql_query("SET NAMES utf8;"); mysql_query("SET CHARACTER_SET utf8;");


if (class_exists('Yii')) { 
	if (isset(Yii::app()->request->cookies['ID_ilmfruits_hadith'])) $cookieID = Yii::app()->request->cookies['ID_ilmfruits_hadith'];
	if (isset(Yii::app()->request->cookies['Key_ilmfruits_hadith'])) $cookieKey = Yii::app()->request->cookies['Key_ilmfruits_hadith'];
} else {
	if (isset($_COOKIE['ID_ilmfruits_hadith'])) $cookieID = $_COOKIE['ID_ilmfruits_hadith'];
	if (isset($_COOKIE['Key_ilmfruits_hadith'])) $cookieKey = $_COOKIE['Key_ilmfruits_hadith'];
}

 //checks cookies to make sure they are logged in 
  if(isset($cookieID)) {
    $username = $cookieID;
    $pass = $cookieKey;
    $check = mysql_query("SELECT * FROM users WHERE username = '$username'")or die(mysql_error());
    while($info = mysql_fetch_array( $check )) {
      //if the cookie has the wrong password, they are taken to the login page 
      if ($pass != $info['password']) {
        header("Location: /admin");
		exit();
      }

      //otherwise they are shown the admin area   
      else {
        $logged_in = true;
      }
    }
  }
  else {
    //if the cookie does not exist, they are taken to the login screen        
    header("Location: /admin");
	exit();
  }

if (class_exists('Yii')) return;

if (!isset($delay_headers)) {

?>


<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
    <title><?php echo $page_title; ?></title>
    <link href="style.css" rel="stylesheet" type="text/css" />

  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-22385858-1']);
    o_gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

  </script>
</head>


<body bgcolor="#DEE4D6">

<?php

}

?>
