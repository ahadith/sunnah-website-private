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
