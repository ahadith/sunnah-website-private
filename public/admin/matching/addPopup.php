<?php
session_start();
$page_title = "Add Hadith";

$con = mysql_connect("localhost", "ilmfruit_ansari", "ansari") or die(mysql_error());
mysql_select_db("ilmfruit_testhadithdb") or die(mysql_error());
mysql_query("SET NAMES utf8;"); mysql_query("SET CHARACTER_SET utf8;");

include "setlang.php";
include "util.php";

$url = $_SERVER['SCRIPT_NAME'];
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


<body bgcolor="#DEE4D6" onLoad="document.theform.hadithnumber.focus()">

<?php
if (!isset($_POST['submit'])) {
	if (isset($_GET['coll'])) $collection = $_GET['coll'];
	else $collection = "bukhari";
	$otherurn = $_GET['otherurn'];
	if ($lang == "english" or $lang == "indonesian") {
		$alignment = "left";
		$otheralignment = "right";
		$dirn = "ltr";
		$otherdirn = "rtl";
		$otherlang = "arabic";
	}
	elseif ($lang == "arabic") {
		$alignment = "right";
		$otheralignment = "left";
    	$dirn = "rtl";
		$otherdirn = "ltr";
		$otherlang = "english";
	}
}



if (isset($_POST['submit'])) {
	$collection = $_POST['collection'];
	$lang = $_POST['lang'];
	$newurn = $_POST['newurn'];
	$otherurn = $_POST['otherurn'];
	$volumeNumber = $_POST['volumenumber'];
	$bookID = $_POST['bookid'];
	$bookNumber = $_POST['booknumber'];
	$bookName = addslashes($_POST['bookname']);
	$babNumber = $_POST['babnumber'];
	$babName = addslashes($_POST['babname']);
	$hadithNumber = $_POST['hadithnumber'];
	$hadithText = addslashes($_POST['hadithtext']);
	$grade = addslashes($_POST['grade']);
	$comments = addslashes($_POST['comments']);
	$narrator = addslashes($_POST['narrator']);
	$username = $_COOKIE['ID_ilmfruits_hadith'];

	if (strcmp($collection, "abudawud") == 0) {
		$newurn = getNextURN(800000+10*$hadithNumber-1, $collection, $lang);
	}

	if (strlen($narrator) > 1) $hadithText = "Narrated $narrator:\n$hadithText";

	$flagError = false;
	if ($hadithNumber == '') $flagError = true;


	if ($flagError) {
		echo "An error occurred. Please close this window and try again.";
	}
	else {
		addHadith($newurn, $volumeNumber, $bookID, $bookNumber, $bookName, $babNumber, $babName, $hadithNumber, $hadithText, $collection, $lang, $live, $username, $comments, $grade);
		if ($lang == "english" or $lang == "indonesian") commitToDB(array($newurn), array($otherurn), $live, $username, FALSE, $lang);
		elseif ($lang == "arabic") commitToDB(array($otherurn), array($newurn), $live, $username, FALSE, "english");

		echo "
    <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr><td align=center>Hadith committed.</td></tr>
	</table>
	<p align=center>
                <a href=\"\" onclick=\"window.opener.location.reload(); window.close()\">Close this window</a><br>(the book page will automatically refresh, and the new pair of hadith may appear at a new location)
	</p>";
	}
	
}
else {

	$otherhadith = getHadith($collection, $otherlang, $otherurn);

?>

	<form method="post" name="theform" action="<?php echo $url; ?>">
    <table width=75% align="center" cellpadding="0" cellspacing="0">
		<tr><td colspan=2>
			  <table width="80%" cellpadding=3 cellspacing="1" border=0 align="center">
			  <tr border=0><td colspan=2 border=0 align=center>
				Add text for hadith. <br>
				Please make sure to fill in all applicable fields and verify that the text 
				you entered corresponds to the hadith displayed below. It is OK if some fields
				are blank. If there is no clear narrator or the hadith doesn't start with "Narrated ..."
				then leave the narrator field blank and put everything in the hadith text box.
			  </td></tr>
			 <tr height=15></tr>
			 <tr><td colspan=2 border=0>
    			<p align=center>
        			<a href="#" onclick="window.close()">Close this window</a> without adding a hadith
    			</p>
			</td></tr>
			 <tr height=15></tr>
			 <tr><td colspan=3 border=0>
				<p align=<?php echo $otheralignment; ?>>
					<?php echo $otherhadith['hadithText']; ?>
				</p>
			 </td></tr>
			  </table>
		</td></tr>
		  <tr><td colspan=2>
			  <table width="100%" cellpadding=3 cellspacing="1" border="1" align="center">

					<?php
							if ($lang == "english") $newurn = getNextURN($otherurn-100000-1, $collection, $lang);
							elseif ($lang == "indonesian") $newurn = getNextURN($otherurn-100000-1+3000000, $collection, $lang);
							elseif ($lang == "arabic") $newurn = getNextURN($otherurn+100000-1, $collection, $lang);
							$urndisabled = "";
							if (strcmp($collection, "abudawud") == 0) {
								$newurn = "blank";
								$urndisabled = " disabled";
							}
							$otherbookID = getBookNumber($otherurn, $collection, $otherlang);
							if (strcmp($collection, "nawawi40") and strcmp($collection, "qudsi40")) {
								$bookID = getMatchingBookID($otherbookID, $collection, $otherlang);
								$bookID = $bookID[$lang.'BookID'];
								$bookName = getBookName($collection, $lang, $bookID);
								$bookNumber = getBookNumber2($collection, $lang, $bookID);
							}			
							echo "
   <input type=hidden name=collection value=".$collection.">
   <input type=hidden name=bookid value=".$bookID.">
   <input type=hidden name=lang value=".$lang.">
   <input type=hidden name=otherurn value=".$otherurn.">
   <input type=hidden name=otherbookid value=".$otherbookID.">
   <input type=hidden name=otherlang value=".$otherlang.">


   <tr>
      <td border=\"1\" valign=\"top\" align=right>URN</td>
      <td border=\"1\" valign=\"top\" colspan=3><input name=newurn type=text value=\"".$newurn."\"".$urndisabled." /></td>
    </tr>
    <tr>
      <td border=\"1\" valign=\"top\" align=right>Volume Number</td>
      <td border=\"1\" valign=\"top\" colspan=3><input name=volumenumber type=text value=1 /></td>
    </tr>
    <tr>
      <td border=\"1\" valign=\"top\" align=right>Book Name</td>
      <td border=\"1\" valign=\"top\"><input name=bookname type=text style=\"width:100%\" value=\"".$bookName."\" /></td>
      <td border=\"1\" valign=\"top\" align=right>Number</td>
      <td border=\"1\" valign=\"top\"><input name=booknumber type=text size=4 value=\"".$bookNumber."\" /></td>
    </tr>
    <tr>
      <td border=\"1\" valign=\"top\" align=right>Chapter Name</td>
      <td border=\"1\" valign=\"top\"><input name=babname type=text style=\"width:100%\" /></td>
      <td border=\"1\" valign=\"top\" align=right>Number</td>
      <td border=\"1\" valign=\"top\"><input name=babnumber type=text size=4/></td>
    </tr>
    <tr>
      <td border=\"1\" valign=\"top\" align=right>Hadith Number</td>
      <td border=\"1\" valign=\"top\"><input name=hadithnumber type=text /></td>
      <td border=\"1\" valign=\"top\" align=right>Grade</td>
      <td border=\"1\" valign=\"top\"><input name=grade type=text /></td>
    </tr>
    <tr>
      <td border=\"1\" valign=\"top\" align=right>Narrator</td>
      <td border=\"1\" valign=\"top\"><input name=narrator type=text /></td>
    </tr>
    <tr>
      <td border=\"1\" valign=\"top\" align=right>Text</td>
      <td border=\"1\" valign=\"top\" colspan=3><textarea class=\"tastyle\" name=\"hadithtext\" style=\"width: 400px;\"></textarea></td>
    </tr>
    <tr>
      <td border=\"1\" valign=\"top\" align=right>Additional Comments</td>
      <td border=\"1\" valign=\"top\" colspan=3><textarea class=\"tastyle\" name=\"comments\" style=\"width: 400px; height: 200px\"></textarea></td>
    </tr>";
?>
			  </table>
		  </td></tr>
		<tr height=15></tr>
		 <tr>
			<td colspan=2>
					    <p align="center"><input type="submit" name="submit" value="Add hadith"></p>
    		</td>
		 </tr>
	 </table>

	</form>
<?php

}

include "footer.php";
mysql_close($con);

?>


