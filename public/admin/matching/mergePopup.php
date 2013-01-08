<?php
$page_title = "Merge Hadith Page";

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

<body bgcolor="#DEE4D6" onLoad="document.theform.urn2.focus()">

<?php

if (isset($_POST['submit'])) {
	$collection = $_POST['collection'];
	$language = $_POST['language'];
	$urn1 = $_POST['urn1'];
	$urn2 = $_POST['urn2'];
	$pagelang = $_POST['pagelang'];

	if ($urn1 > 0 and $urn2 > 0 and strlen($collection) > 0 and strlen($language) > 0) {
		$retval = mergeHadith($urn1, $urn2, $collection, $language, $live, $username, $pagelang);
		if ($retval == 0) {

			echo "
    		<table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        		<tr><td align=center>Merge committed. </td></tr>
			</table>
			<p align=center>
				<a href=\"\" onclick=\"window.opener.location.reload(); window.close()\">Close this window</a><br>(the book page will automatically refresh)
			</p>";
		}
		else {
			echo "
    		<table width=95% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        		<tr><td align=center>An error occurred. Please go back and check if you had the correct Collection, Language and URNs.</td></tr>
			</table>
			<p align=center>
				Go to main matching <a href=\"/admin/matching/\">admin page</a>
			</p>";
		}
	}
	else echo "
        <table width=95% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
            <tr><td align=center>Please enter a valid combination of collection, language and URNs</td></tr>
        </table>
        <p align=center>
            Go back to <a href=\"mergeHadith.php\">merge page</a>
        </p>";

	
}
else {

if (isset($_GET["coll"])) $collection = $_GET["coll"];
if (isset($_GET["lang"])) $language = $_GET["lang"];
if (isset($_GET["first"])) $first = $_GET["first"];
if (isset($_GET["pagelang"])) $pagelang = $_GET["pagelang"];

?>



	<form method="post" action="<?php echo $url; ?>" name="theform">
    <table width=95% align="center" cellpadding="0" cellspacing="0">
		<tr><td colspan=2>
			  <table width="90%" cellpadding=3 cellspacing="1" border=0 align="center">
			  <tr border=0><td colspan=2 border=0>
				Use this page to merge two ahadith, for example ones that are combined in the other language. 
				You will need their URNs (not the hadith numbers, but the URNs that appear at the top of each
				hadith box.<br><br>
				Please double-check the URNs you enter here. Changes are very hard to undo!
			 <tr height=15></tr>

			  </table>
		</td></tr>
		  <tr>
			<td colspan=2 align=center>

			Collection:&nbsp;
			<select name="collection">
				<option value=""></option>
				<option value="bukhari" <?php if ($collection == "bukhari") {echo "selected";}?>>al-Bukhari</option>
				<option value="muslim" <?php if ($collection == "muslim") {echo "selected";}?>>Muslim</option>
				<option value="malik" <?php if ($collection == "malik") {echo "selected";}?>>Muwatta Malik</option>
				<option value="tirmidhi" <?php if ($collection == "tirmidhi") {echo "selected";}?>>Tirmidhi</option>
				<option value="abudawud" <?php if ($collection == "abudawud") {echo "selected";}?>>Abu Dawud</option>
				<option value="nasai" <?php if ($collection == "nasai") {echo "selected";}?>>an-Nasai</option>
				<option value="ibnmajah" <?php if ($collection == "ibnmajah") {echo "selected";}?>>Ibn Majah</option>
				<option value="riyadussaliheen" <?php if ($collection == "riyadussaliheen") {echo "selected";}?>>Riyad as-Saliheen</option>
			</select>
			<br>
			<br>
			
			Language:&nbsp;
			<select name="language">
				<option value=""></option>
				<option value="english" <?php if ($language == "english") {echo "selected";}?>>English</option>
				<option value="arabic" <?php if ($language == "arabic") {echo "selected";}?>>Arabic</option>
				<option value="indonesian" <?php if ($language == "indonesian") {echo "selected";}?>>Bahasa Indonesia</option>
			</select>
			<br>
			<br>
			First hadith URN:&nbsp;&nbsp;
			<input name="urn1" type="text" value=<?php echo $first; ?>>
			<br>
			<br>
			Second hadith URN:&nbsp;&nbsp;
			<input name="urn2" type="text">
			&nbsp;&nbsp;
			<br>
			<br>
			<input type="submit" name="submit" value="Commit merge">
			<input type="hidden" name="pagelang" value="<?php echo $pagelang; ?>">	
	
		  </td></tr>
	 </table>

	</form>
<?php

}

include "footer.php";
mysql_close($con);

?>


