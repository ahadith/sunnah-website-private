<?php
session_start();
$page_title = "Split Arabic Hadith";
include "adminheader.php";

include "util.php";

$ebooknum = $_GET['ebooknum'];
if (isset($_GET['coll'])) $collection = $_GET['coll'];
else $collection = "bukhari";
$lang = "arabic";
$url = $_SERVER['SCRIPT_NAME']."?coll=".$collection."&ebooknum=".$ebooknum."&aurn=".$_GET['aurn'];

$urn = $_GET['aurn'];

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







$aurns = $_SESSION['aURNs'];
$posn = array_search($urn, $aurns);

if (isset($_POST['submit'])) {
	$urn = $_POST['urn'];

	$urn1 = $_POST['urn1'];
	$urn2 = $_POST['urn2'];
	$text1 = $_POST['text1'];
	$text2 = $_POST['text2'];
	$bookName = $_POST['bookName'];
	$bookID = $_POST['bookID'];
	$bookNumber = $_POST['bookNumber'];
	$babName = $_POST['babName'];
	$babNumber = $_POST['babNumber'];
	$volumeNumber = $_POST['volumeNumber'];
	$hadithNumber = $_POST['hadithNumber'];
	$pagelang = $_POST['pagelang'];

    if ($bookNumber > 1 or $collection != "bukhari") {
  	  addHadith($urn1, $volumeNumber, $bookID, $bookNumber, $bookName, $babNumber, $babName, $hadithNumber, $text1, $collection, $lang, $live, $username);
	  addHadith($urn2, $volumeNumber, $bookID, $bookNumber, $bookName, $babNumber, $babName, $hadithNumber, $text2, $collection, $lang, $live, $username);
	  deleteReferencesToHadith($urn, $collection, $lang, $live, $username, $pagelang);

    // Remove the old URN from session URN list and add the two new ones
    // Assuming that they are of equal length.
    $eurns = $_SESSION['eURNs'];
    $aurns = $_SESSION['aURNs'];
    $posn = array_search($urn, $aurns);
    array_splice($aurns, $posn, 1, array($urn1, $urn2));
    array_splice($eurns, $posn+1, 0, 0);
    $_SESSION['eURNs'] = $eurns;
    $_SESSION['aURNs'] = $aurns;


	  echo "
      <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
          <tr><td align=center>Changes committed. Probably.</td></tr>
      </table>
      <p align=center>
        Go <a href=\"matchBooks_c.php?coll=".$collection."&ebooknum=".$ebooknum."&continue=true#".$posn."\">back to matching page</a>
      <br>
	  You may have to refresh or go back to the main collection page in order to see the recent change you just made</p>";
    }
    else {
      echo "
      <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr><td align=center>Changes to Book 1 are not committed. It is meant to remain as a didactic example.</td></tr>
      </table>
      <p align=center>
        Go <a href=\"matchBooks_c.php?coll=".$collection."&ebooknum=".$ebooknum."&continue=true\">back to matching page</a>
      <br>";
    }

  echo $_POST['text1']."<br>".$_POST['text2'];
}
else {

?>

	<form method="post" action="<?php echo $url; ?>">
    <table width=75% align="center" cellpadding="0" cellspacing="0">
		  <tr><td colspan=2>
			  <table width="60%" cellpadding=3 cellspacing="1" border="1" align="center">
					<?php
						if (isset($_GET['aurn']) && is_numeric($_GET['aurn'])) {
							$urn = $_GET['aurn'];
							$pagelang = $_GET['pagelang'];
							$lang = "arabic";
							$hadith = getArabicHadith($collection, $urn);
							echo "
   <tr>
      <td width=\"40%\" border=\"1\" valign=\"top\" align=right>".$hadith['arabicURN']."</td>
      <td width=\"10%\" border=\"1\" valign=\"top\">URN</td>
    </tr>
    <tr>
      <td width=\"40%\" border=\"1\" valign=\"top\" align=right>".$hadith['hadithNumber']."&nbsp;</td>
      <td width=\"10%\" border=\"1\" valign=\"top\">Number</td>
    </tr>
    <tr>
      <td width=\"40%\" border=\"1\" valign=\"top\" align=right>(".$hadith['bookNumber'].")<font size=5>".$hadith['bookName']."</font></td>
      <td width=\"10%\" border=\"1\" valign=\"top\">Book</td>
    </tr>
    <tr>
      <td width=\"40%\" border=\"1\" valign=\"top\" align=right>(".$hadith['babNumber'].")<font size=5>".$hadith['babName']."</font></td>
      <td width=\"10%\" border=\"1\" valign=\"top\">Bab</td>
    </tr>
    <tr>
      <td width=\"40%\" border=\"1\" valign=\"top\" align=right><font size=5><pre style=\"white-space: pre-wrap;\">".$hadith['hadithText']."</pre></font></td>
      <td width=\"10%\" border=\"1\" valign=\"top\">Text</td>
    </tr>";
							$urn1 = getNextURN($urn, $collection, $lang);
							$urn2 = getNextURN($urn1, $collection, $lang);
							$bookName = $hadith['bookName'];
							$bookID = $hadith['bookID'];
							$bookNumber = $hadith['bookNumber'];
							$babName = $hadith['babName'];
							$babNumber = $hadith['babNumber'];
							$hadithNumber = $hadith['hadithNumber'];
							$volumeNumber = $hadith['volumeNumber'];
						}
?>
			  </table>
		  </td></tr>
		<tr height=15></tr>
		<tr><td align=center colspan=2>Copy from above and paste the component ahadith into the textboxes below<br>
        Please be careful with not breaking the HTML tags. <br>
        (HTML tags are those things between &lt; and &gt; , like &lt;p&gt;. They preserve the spacing and formatting. Don't leave out the nearby and surrounding tags when copying)
		</td></tr>
		<tr height=15>
			<input type=hidden name="urn" value="<?php echo $urn;?>">
			<input type=hidden name="urn1" value="<?php echo $urn1;?>">
			<input type=hidden name="urn2" value="<?php echo $urn2;?>">
			<input type=hidden name="volumeNumber" value="<?php echo $volumeNumber;?>">
			<input type=hidden name="bookID" value="<?php echo $bookID;?>">
			<input type=hidden name="bookNumber" value="<?php echo $bookNumber;?>">
			<input type=hidden name="bookName" value="<?php echo $bookName;?>">
			<input type=hidden name="babNumber" value="<?php echo $babNumber;?>">
			<input type=hidden name="babName" value="<?php echo $babName;?>">
			<input type=hidden name="hadithNumber" value="<?php echo $hadithNumber;?>">
			<input type=hidden name="pagelang" value="<?php echo $pagelang;?>">
		</tr>

             <tr><td colspan=2 border=0>
                <p align=center>
                    Go <a href="matchBooks_c.php?coll=<?php echo $collection;?>&ebooknum=<?php echo $ebooknum;?>&continue=true#<?php echo $posn;?>">back to matching page</a> without splitting
                </p>
            </td></tr>
             <tr height=15></tr>



		 <tr>
			<td>
				<table border=1>				
					<tr>
				      <td width="80%" border="1" valign="top" align=right><?php echo $urn1; ?></td>
				      <td width="20%" border="1" valign="top">URN</td>
				    </tr>
				    <tr>
				      <td width="80%" border="1" valign="top" align=right>(<?php echo $bookNumber;?>) <font size=5><?php echo $bookName;?> </font></td>
				      <td width="20%" border="1" valign="top">Book</td>
				    </tr>
				    <tr>
				      <td width="80%" border="1" valign="top" align=right>(<?php echo $babNumber;?>) <font size=5><?php echo $babName;?></font></td>
				      <td width="20%" border="1" valign="top">Bab</td>
				    </tr>
				    <tr>
				      <td width="80%" border="1" valign="top" align=right><?php echo $hadithNumber;?></td>
				      <td width="20%" border="1" valign="top">Number</td>
				    </tr>
					<tr>
				      <td width="80%" border="1" valign="top" align=right>
						<textarea name="text1" class="tastylearabic" align=right dir=rtl></textarea>
					  </td>
					  <td width="20%" border="1" valign="top">Text</td>
					</tr>
				</table>
			</td>
			<td>
				<table border=1>				
					<tr>
				      <td width="80%" border="1" valign="top" align=right><?php echo $urn2; ?></td>
				      <td width="20%" border="1" valign="top">URN</td>
				    </tr>
				    <tr>
				      <td width="80%" border="1" valign="top" align=right>(<?php echo $bookNumber;?>) <font size=5><?php echo $bookName;?> </font></td>
				      <td width="20%" border="1" valign="top">Book</td>
				    </tr>
				    <tr>
				      <td width="80%" border="1" valign="top" align=right>(<?php echo $babNumber;?>) <font size=5><?php echo $babName;?></font></td>
				      <td width="20%" border="1" valign="top">Bab</td>
				    </tr>
				    <tr>
				      <td width="80%" border="1" valign="top" align=right><?php echo $hadithNumber;?></td>
				      <td width="20%" border="1" valign="top">Number</td>
				    </tr>
					<tr>
				      <td width="80%" border="1" valign="top" align=right>
							<textarea name="text2" class="tastylearabic" align=right dir=rtl></textarea>
					  </td>
					  <td width="20%" border="1" valign="top">Text</td>
					</tr>
				</table>
				
			</td>
		 </tr>
		 <tr height=15></tr>
		 <tr>
			<td colspan=2>
					    <p align="center"><input type="submit" name="submit" value="Commit changes"></p>
    				</form>
			</td>
		 </tr>	
	 </table>

			</form>
<?php

}

include "footer.php";
mysql_close($con);

?>


