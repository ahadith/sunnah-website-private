<?php
session_start();
$page_title = "Modify Hadith";
include "setlang.php";
include "adminheader.php";

include "util.php";

$ebooknum = $_GET['ebooknum'];
$referrer = $_SERVER['HTTP_REFERER'];
if (isset($_GET['coll'])) $collection = $_GET['coll'];
else $collection = "bukhari";
$url = $_SERVER['SCRIPT_NAME']."?coll=".$collection."&lang=$lang&ebooknum=".$ebooknum."&eurn=".$_GET['eurn'];

$urn = $_GET['eurn'];


// Code to get URNs

		if (($_SESSION['eURNs'] != NULL) and (URNinBook($_SESSION['eURNs'][0], $ebooknum, $collection, "english"))) {
          $eURNs = $_SESSION['eURNs'];
          $aURNs = $_SESSION['aURNs'];
          //print "URNinBook is true for urn = ".$_SESSION['eURNs'][0]." and ebooknum = ".$ebooknum."\n";
        }
        else {
            //print "URNinBook is false for urn = ".$_SESSION['eURNs'][0]." and ebooknum = ".$ebooknum."\n";
            $eURNs_orig = getHadithNumbersForEnglishBook($collection, $ebooknum, $lang);
            $aURNs_orig = getHadithNumbersForArabicBook($collection, $abooknum);
            $eURNs_match = getMatchedEnglishURNs($aURNs_orig, $lang);
            $aURNs_match = getMatchedArabicURNs($eURNs_orig, $lang);
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

$eurns = $_SESSION['eURNs'];
$posn = array_search($urn, $eurns);


if (isset($_POST['submit'])) {
	$urn = $_POST['urn'];
	$text = $_POST['text'];
	$babName = $_POST['babname'];
	$babNumber = $_POST['babnumber'];
	$comments = $_POST['comments'];
	$grade = $_POST['grade'];
	$hadithNumber = $_POST['hadithnumber'];

	updateHadithText($urn, $hadithNumber, $text, $babName, $babNumber, $collection, $lang, $live, $username, $comments, $grade);

	header("Location: matchBooks_c.php?coll=".$collection."&lang=$lang&ebooknum=".$ebooknum."#".$posn);
/*	echo "
    <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr><td align=center>Changes committed. Probably.</td></tr>
	</table>
	<p align=center>
		Go <a href=\"matchBooks_c.php?coll=".$collection."&ebooknum=".$ebooknum."&continue=true#".$posn."\">back to matching page</a>
	</p>";
*/
	
}
else {

?>
	<form method="post" action="<?php echo $url; ?>">
    <table width=75% align="center" cellpadding="0" cellspacing="0">
		<tr><td colspan=2>
			  <table width="60%" cellpadding=3 cellspacing="1" border=0 align="center">
			  <tr border=0><td colspan=2 border=0>
				Please use this page sparingly and <i>only</i> to correct spelling errors and the like. 
				For more substantial changes please send email to sunnahhadith@gmail.com
				<br><br>
				Please be careful with not deleting the HTML tags. <br>
        (HTML tags are those things between &lt; and &gt; , like &lt;p&gt;. They preserve the spacing and formatting. Don't leave out the nearby and surrounding tags when copying)
			  </td></tr>
			 <tr height=15></tr>
			 <tr><td colspan=2 border=0>
    			<p align=center>
        			Go <a href="matchBooks_c.php?coll=<?php echo $collection;?>&lang=<?php echo $lang;?>&ebooknum=<?php echo $ebooknum;?>&continue=true#<?php echo $posn;?>">back to matching page</a> without modifying
    			</p>
			</td></tr>
			 <tr height=15></tr>

			  </table>
		</td></tr>
		  <tr><td colspan=2>
			  <table width="80%" cellpadding=3 cellspacing="1" border="1" align="center">

					<?php
						if (isset($_GET['eurn']) && is_numeric($_GET['eurn'])) {
							$urn = $_GET['eurn'];
							$hadith = getEnglishHadith($collection, $urn, $lang);
							echo "
   <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>URN</td>
      <td width=\"40%\" border=\"1\" valign=\"top\">".$hadith[$lang.'URN']."</td>
    </tr>
    <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Number</td>
      <td width=\"40%\" border=\"1\" valign=\"top\"><input type=text size=8 name=hadithnumber value=\"".$hadith['hadithNumber']."\">&nbsp;
	  Grade: <input type=text size=25 name=grade value=\"".$hadith['grade']."\"></td>
    </tr>
    <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Book</td>
      <td width=\"40%\" border=\"1\" valign=\"top\">".$hadith['bookName']."(".$hadith['bookNumber'].")</td>
    </tr>
    <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Chapter</td>
      <td width=\"40%\" border=\"1\" valign=\"top\">Number: <input type=text size=5 name=babnumber value=\"".$hadith['babNumber']."\">
	  Name: <input type=text size=45 name=babname value=\"".$hadith['babName']."\"></td>
    </tr>
    <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Text</td>
      <td width=\"40%\" border=\"1\" valign=\"top\"><textarea class=\"tastyle\" name=\"text\" style=\"width: 400px;\">".$hadith['hadithText']."</textarea></td>
    </tr>
    <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Additional Comments</td>
      <td width=\"40%\" border=\"1\" valign=\"top\"><textarea class=\"tastyle\" name=\"comments\" style=\"width: 400px; height: 200px\">".$hadith['comments']."</textarea></td>
    </tr>";
						}
?>
			  </table>
		  </td></tr>
		<tr height=15></tr>
		<tr><td align=center colspan=2>Modify the hadith above</td></tr>
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


