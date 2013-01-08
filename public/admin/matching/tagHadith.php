<?php
session_start();
$page_title = "Tag Hadith";
include "adminheader.php";

include "util.php";

$ebooknum = $_GET['ebooknum'];
$lang = $_GET['lang'];
$referrer = $_SERVER['HTTP_REFERER'];
if (isset($_GET['coll'])) $collection = $_GET['coll'];
else $collection = "bukhari";
$url = $_SERVER['SCRIPT_NAME']."?coll=".$collection."&lang=".$lang."&ebooknum=".$ebooknum."&urn=".$_GET['urn'];


$urn = $_GET['urn'];

// Code to get URNs

		if (($_SESSION['eURNs'] != NULL) and (URNinBook($_SESSION['eURNs'][0], $ebooknum, $collection, "english"))) {
          $eURNs = $_SESSION['eURNs'];
          $aURNs = $_SESSION['aURNs'];
          //print "URNinBook is true for urn = ".$_SESSION['eURNs'][0]." and ebooknum = ".$ebooknum."\n";
        }
        else {
            //print "URNinBook is false for urn = ".$_SESSION['eURNs'][0]." and ebooknum = ".$ebooknum."\n";
            $eURNs_orig = getHadithNumbersForEnglishBook($collection, $ebooknum);
            $aURNs_orig = getHadithNumbersForArabicBook($collection, $abooknum);
            $eURNs_match = getMatchedEnglishURNs($aURNs_orig);
            $aURNs_match = getMatchedArabicURNs($eURNs_orig);
            //Mix the URNs without entries in matchtable
            $eURNs = $eURNs_orig; $aURNs = $aURNs_match;
            foreach ($aURNs_orig as $aURN) {
                if (array_search($aURN, $aURNs_match) === FALSE) {
                    $posn = find_closest_element($aURNs, $aURN);
                    array_splice($aURNs, $posn, 0, $aURN);
                    array_splice($eURNs, $posn, 0, 0);
                }
            }
            $retval = sanitizeURNs($eURNs, $aURNs);
            $eURNs = $retval['eURNs'];
            $aURNs = $retval['aURNs'];
        }
		$_SESSION['eURNs'] = $eURNs;
        $_SESSION['aURNs'] = $aURNs;

// End code to get URNs



if ($lang == "english") {
	$urns = $_SESSION['eURNs'];
	$alignment = "left";
	$dirn = "ltr";
}
elseif ($lang == "arabic") {
	$urns = $_SESSION['aURNs'];
	$alignment = "right";
    $dirn = "rtl";
}
$posn = array_search($urn, $urns);


if (isset($_POST['submit'])) {
	$urn = $_POST['urn'];
	$tag = $_POST['tag'];
	updateTagText($urn, $tag, $live, $username);

	echo "
    <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr><td align=center>Tag committed.</td></tr>
	</table>
	<p align=center>
		Go <a href=\"matchBooks_c.php?coll=".$collection."&ebooknum=".$ebooknum."&continue=true#".$posn."\">back to matching page</a>
	</p>";

	
}
elseif (isset($_POST['deletetag'])) {
	$urn = $_POST['urn'];
	deleteTag($urn, $live, $username);
	echo "
    <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr><td align=center>Tag deleted.</td></tr>
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
			  <tr border=0><td colspan=2 border=0 align=center>
				Enter a note to tag this hadith with. You may leave the tag blank and still tag this hadith.
			  </td></tr>
			 <tr height=15></tr>
			 <tr><td colspan=2 border=0>
    			<p align=center>
        			Go <a href="matchBooks_c.php?coll=<?php echo $collection;?>&ebooknum=<?php echo $ebooknum;?>&continue=true#<?php echo $posn;?>">back to matching page</a> without tagging
    			</p>
			</td></tr>
			 <tr height=15></tr>

			  </table>
		</td></tr>
		  <tr><td colspan=2>
			  <table width="60%" cellpadding=3 cellspacing="1" border="1" align="center">

					<?php
							$hadith = getHadith($collection, $lang, $urn);
							$tagText = getTag($urn);
							echo "
   <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>URN</td>
      <td width=\"40%\" border=\"1\" valign=\"top\">".$urn."</td>
    </tr>
    <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Number</td>
      <td width=\"40%\" border=\"1\" valign=\"top\">".$hadith['hadithNumber']."&nbsp;</td>
    </tr>
    <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Book</td>
      <td width=\"40%\" border=\"1\" valign=\"top\">".$hadith['bookName']."(".$hadith['bookNumber'].")</td>
    </tr>
	<tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Text</td>
      <td width=\"40%\" border=\"1\" valign=\"top\" align=".$alignment."><font size=5><pre style=\"white-space: pre-wrap;\">".$hadith['hadithText']."</pre></font></td>
    </tr>
    <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Tag</td>
      <td width=\"40%\" border=\"1\" valign=\"top\"><textarea class=\"tastyle\" name=\"tag\" style=\"width: 500px;\" dir=".$dirn.">".$tagText."</textarea></td>
    </tr>";
?>
			  </table>
		  </td></tr>
		<tr height=15></tr>
		<tr><td align=center colspan=2>Enter tag above</td></tr>
		<tr height=15>
			<input type=hidden name="urn" value="<?php echo $urn;?>">
		</tr>
		 <tr>
			<td colspan=2>
					    <p align="center"><input type="submit" name="submit" value="Tag this hadith"></p>
    		</td>
		 </tr>
		<?php if ($tagText != NULL and strlen($tagText) > 0) { ?>
		 <tr>
			<td colspan=2>
					    <p align="center"><input type="submit" name="deletetag" value="Delete this tag"></p>
    		</td>
		 </tr>
		 <?php } ?>
	 </table>

	</form>
<?php

}

include "footer.php";
mysql_close($con);

?>


