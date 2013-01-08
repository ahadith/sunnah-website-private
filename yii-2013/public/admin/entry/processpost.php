<?php

include "../matching/util.php";

function processPost($collection) {
	$con = mysql_connect("localhost", "ilmfruit_ansari", "ansari") or die(mysql_error());
	mysql_select_db("ilmfruit_testhadithdb") or die(mysql_error());
	mysql_query("SET NAMES utf8;"); mysql_query("SET CHARACTER_SET utf8;");

	$bookNumber = $_POST['booknumber'];
	$babNumber = $_POST['chapternumber'];
	$babName = $_POST['chaptername'];

	for ($i = 0; $i < 10; $i++) {
		$hadithNumber = $_POST['hadithnumber'][$i];
		$text = $_POST['hadithtext'][$i];
		if (strlen($hadithNumber) > 0) addHadith(getNextURN((int)$hadithNumber*10 + 2200000 - 1, $collection."vols", "english"), 1, $bookNumber, $bookNumber, "", $babNumber, $babName, $hadithNumber, $text, $collection."vols", "english", 1, "vol");
	}

	mysql_close($con);
	return 1;
}
?>
