<?php
session_start();
$page_title = "Manual Match Page";
include "adminheader.php";


include "util.php";

$url = $_SERVER['SCRIPT_NAME'];


if (isset($_POST['submit'])) {
	$eurn = $_POST['eurn'];
	$aurn = $_POST['aurn'];

	if ($eurn > 0 and $aurn > 0) {
		manualMatch($eurn, $aurn, $live, $username);

		echo "
    	<table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        	<tr><td align=center>Match committed. Probably.</td></tr>
		</table>
		<p align=center>
			Go to main <a href=\"/admin/\">admin page</a>
		</p>";
	}
	else echo "
        <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
            <tr><td align=center>Please enter valid URNs</td></tr>
        </table>
        <p align=center>
            Go back to <a href=\"manualMatch.php\">manual match page</a>
        </p>";

	
}
else {

?>

	<form method="post" action="<?php echo $url; ?>">
    <table width=75% align="center" cellpadding="0" cellspacing="0">
		<tr><td colspan=2>
			  <table width="60%" cellpadding=3 cellspacing="1" border=0 align="center">
			  <tr border=0><td colspan=2 border=0>
				Use this page to enter a manual match for two ahadith, for example ones that aren't in order. 
				You will need their URNs (not the hadith numbers, but the URNs that appear at the top of each
				hadith box.<br><br>
				Please double-check the URNs you enter here. Changes are very hard to undo!
			 <tr height=15></tr>

			  </table>
		</td></tr>
		  <tr>
			<td colspan=2 align=center>
				
			English URN:&nbsp;&nbsp;
			<input name="eurn" type="text">
			Arabic URN:&nbsp;&nbsp;
			<input name="aurn" type="text">
			&nbsp;&nbsp;<input type="submit" name="submit" value="Commit match">
			
	
		  </td></tr>
	 </table>

	</form>
<?php

}

include "footer.php";
mysql_close($con);

?>


