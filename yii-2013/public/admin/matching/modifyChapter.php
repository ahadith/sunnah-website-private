<?php
$page_title = "Modify Chapter";
include "setlang.php";
include "adminheader.php";

include "util.php";

// incoming GET args: coll=$collection&lang=english&booknum=$ebooknum&babnumber=$echapno&posn=$counter


$ebookID = $_GET['ebooknum'];
$abookID = $_GET['abooknum'];
$pagelang = $_GET['pagelang'];

if (strcmp($lang, "english") == 0 or strcmp($lang, "indonesian") == 0) $bookID = $ebookID;
elseif (strcmp($lang, "arabic") == 0) $bookID = $abookID;

if (isset($_GET['coll'])) $collection = $_GET['coll'];
else $collection = "bukhari";
$babID = $_GET['babid'];
$posn = $_GET['posn'];


$url = $_SERVER['SCRIPT_NAME']."?coll=$collection&lang=$lang&pagelang=$pagelang&ebooknum=$ebookID&abooknum=$abookID&babnumber=$babNumber&posn=$posn";

if (isset($_POST['submit'])) {
	$babName = htmlspecialchars_decode($_POST['babname']);
	$babNumber = $_POST['babnumber'];
	$babID = $_POST['babid'];
	$intro = $_POST['intro'];

	updateChapter($collection, $lang, $bookID, $babID, $babNumber, $babName, $intro, $live, $username);

	header("Location: viewChapters.php?coll=$collection&lang=$pagelang&ebooknum=$ebookID&abooknum=$abookID#$posn");
	echo "
    <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr><td align=center>Changes committed. Probably.</td></tr>
	</table>
	<p align=center>
		Go <a href=\"matchBooks_c.php?coll=".$collection."&ebooknum=".$ebooknum."&continue=true#".$posn."\">back to matching page</a>
	</p>";

	
}
else {

?>

	<form method="post" action="<?php echo $url; ?>">
    <table width=75% align="center" cellpadding="0" cellspacing="0">
		<tr><td colspan=2>
			  <table width="60%" cellpadding=3 cellspacing="1" border=0 align="center">
			  <tr border=0><td colspan=2 border=0>
				Use this page to correct errors in bab names.
			  </td></tr>
			 <tr height=15></tr>
			  </table>
		</td></tr>
		  <tr><td colspan=2>
			  <table width="60%" cellpadding=3 cellspacing="1" border="1" align="center">

					<?php
							$dir = "rtl";
							$chapter = getChapter($collection, $lang, $bookID, $babID);
							if (strcmp($lang, "english") == 0 or strcmp($lang, "indonesian") == 0) $dir = "ltr";
							echo "
   <tr>
      <td width=\"40%\" border=\"1\" valign=\"top\" align=right>".$collection."</td>
      <td width=\"10%\" border=\"1\" valign=\"top\">Collection</td>
    </tr>
    <tr>
      <td width=\"40%\" border=\"1\" valign=\"top\" align=right>".$chapter['bookID']."</td>
      <td width=\"10%\" border=\"1\" valign=\"top\">Book ID</td>
    </tr>
    <tr>
      <td width=\"40%\" border=\"1\" valign=\"top\" align=right>ID: <input type=text size=5 name=babid value=\"".$chapter['babID']."\">  Number: <input type=text size=5 name=babnumber value=\"".$chapter['babNumber']."\"> Name: <input type=text style=\"font-size: 20px;\"size=45 name=babname dir=$dir value=\"".htmlspecialchars($chapter['babName'])."\"></td>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Chapter</td>
    </tr>
    <tr>
      <td width=\"40%\" border=\"1\" valign=\"top\"><textarea class=\"tastylearabic\" name=\"intro\" style=\"width: 500px;\" dir=rtl>".$chapter['intro']."</textarea></td>
      <td width=\"10%\" border=\"1\" valign=\"top\">Chapter Intro</td>
    </tr>";
?>
			  </table>
		  </td></tr>
		<tr height=15></tr>
		<tr><td align=center colspan=2>Modify the chapter above</td></tr>
		<tr height=15>
			<input type=hidden name="urn" value="<?php echo $urn;?>">
		</tr>
		 <tr>
			<td colspan=2>
					    <p align="center"><input type="submit" name="submit" value="Commit changes"></p>
    		</td>
		 </tr>	
	 </table>

	</form>
<?php

}

include "footer.php";
mysql_close($con);

?>


