<?php
session_start();
$page_title = "Merge Hadith Page";
include "adminheader.php";

include "util.php";

$url = $_SERVER['SCRIPT_NAME'];


if (isset($_POST['submit'])) {
	$collection = $_POST['collection'];
	$language = $_POST['language'];
	$urn1 = $_POST['urn1'];
	$urn2 = $_POST['urn2'];

	if ($urn1 > 0 and $urn2 > 0 and strlen($collection) > 0 and strlen($language) > 0) {
		if (mergeHadith($urn1, $urn2, $collection, $language, $live, $username) == 0) {

			echo "
    		<table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        		<tr><td align=center>Merge committed. Probably.</td></tr>
			</table>
			<p align=center>
				Go to main matching <a href=\"/admin/matching/\">admin page</a>
			</p>";
		}
		else {
			echo "
    		<table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        		<tr><td align=center>An error occurred. Please go back and check if you had the correct Collection, Language and URNs.</td></tr>
			</table>
			<p align=center>
				Go to main matching <a href=\"/admin/matching/\">admin page</a>
			</p>";
		}
	}
	else echo "
        <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
            <tr><td align=center>Please enter a valid combination of collection, language and URNs</td></tr>
        </table>
        <p align=center>
            Go back to <a href=\"mergeHadith.php\">merge page</a>
        </p>";

	
}
else {

?>

	<form method="post" action="<?php echo $url; ?>">
    <table width=75% align="center" cellpadding="0" cellspacing="0">
		<tr><td colspan=2>
			  <table width="60%" cellpadding=3 cellspacing="1" border=0 align="center">
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
				<option value="bukhari">Bukhari</option>
				<option value="muslim">Muslim</option>
				<option value="malik">Muwatta Malik</option>
			</select>
			<br>
			<br>
			
			Language:&nbsp;
			<select name="language">
				<option value=""></option>
				<option value="english">English</option>
				<option value="arabic">Arabic</option>
			</select>
			<br>
			<br>
			First hadith URN:&nbsp;&nbsp;
			<input name="urn1" type="text">
			<br>
			<br>
			Second hadith URN:&nbsp;&nbsp;
			<input name="urn2" type="text">
			&nbsp;&nbsp;
			<br>
			<br>
			<input type="submit" name="submit" value="Commit merge">
			
	
		  </td></tr>
	 </table>

	</form>
<?php

}

include "footer.php";
mysql_close($con);

?>


