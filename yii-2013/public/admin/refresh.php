<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta name="generator" content="jemdoc, see http://jemdoc.jaboc.net/" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="jemdoc.css" type="text/css" />
<title></title>
</head>
<body>
<table summary="Table for page layout." id="tlayout">
<tr valign="top">
<td id="layout-menu">
<div class="menu-item"><a href="home.php">Admin&nbsp;Home</a></div>
<div class="menu-item"><a href="matching">Hadith&nbsp;(English)</a></div>
<div class="menu-item"><a href="matching/?lang=indonesian">Hadith&nbsp;(Indonesian)</a></div>
<div class="menu-item"><a href="matching/?lang=urdu">Hadith&nbsp;(Urdu)</a></div>
<div class="menu-item"><a href="tasks.php">Ongoing&nbsp;Projects</a></div>
<div class="menu-item"><a href="utilities.php" class="current">Utilities</a></div>
<div class="menu-item"><a href="/">Public&nbsp;Website</a></div>
<div class="menu-item"><a href="logout.php">Logout</a></div>
</td>
<td id="layout-content">
<p><?php include "matching/checklogin.php"; ?> </p>
<h2>Refresh production tables</h2>
<?php
$sqlFileToExecute = 'refreshHadithTables.sql';
$hostname = 'localhost';
$db_user = 'refreshuser';
$db_password = 'refreshpass';
$link = mysql_connect($hostname, $db_user, $db_password);
if (!$link) {
  die ("MySQL Connection error");
}
 
$database_name = 'hadithdb';
mysql_select_db($database_name, $link) or die ("Wrong MySQL Database");
 
// read the sql file
$f = fopen($sqlFileToExecute,'r');
$sqlFile = fread($f, filesize($sqlFileToExecute));
$sqlArray = explode(';',$sqlFile);
foreach ($sqlArray as $stmt) {
  if (strlen($stmt)>3 && substr(ltrim($stmt),0,2)!='/*') {
    $result = mysql_query($stmt);
    if (!$result) {
      $sqlErrorCode = mysql_errno();
      $sqlErrorText = mysql_error();
      $sqlStmt = $stmt;
      break;
    }
  }
}
fclose($f);
if ($sqlErrorCode == 0) {
  echo "Tables updated successfully alhamdulillah.";
} else {
  echo "An error occurred while running the update script.<br/>";
  echo "Error code: $sqlErrorCode<br/>";
  echo "Error text: $sqlErrorText<br/>";
  echo "Statement:<br/> $sqlStmt<br/>";
}
 
?>
<p>Refreshing &hellip;</p>
<p><a href="utilities.php">Back to Utilities page</a></p>
<div id="footer">
<div id="footer-text">
Page generated 2012-12-04 19:41:09 PST, by <a href="http://jemdoc.jaboc.net/">jemdoc</a>.
</div>
</div>
</td>
</tr>
</table>
</body>
</html>
