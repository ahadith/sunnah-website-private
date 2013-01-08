<?php
session_start();
$page_title = "Split Hadith";
include "setlang.php";
include "adminheader.php";

include "util.php";

$ebooknum = $_GET['ebooknum'];
if (isset($_GET['coll'])) $collection = $_GET['coll'];
else $collection = "bukhari";
$url = $_SERVER['SCRIPT_NAME']."?coll=".$collection."&lang=$lang&ebooknum=".$ebooknum."&eurn=".$_GET['eurn'];

$urn = $_GET['eurn'];

// Code to get URNs

		if (($_SESSION['eURNs'] != NULL) and (URNinBook($_SESSION['eURNs'][0], $ebooknum, $collection, $lang))) {
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

	$urn1 = $_POST['urn1'];
	$urn2 = $_POST['urn2'];
	$text1 = addslashes($_POST['text1']);
	$text2 = addslashes($_POST['text2']);
	$bookName = addslashes($_POST['bookName']);
	$bookNumber = $_POST['bookNumber'];
	$bookID = $_POST['bookID'];
	$babName = addslashes($_POST['babName']);
	$babNumber = $_POST['babNumber'];
	$volumeNumber = $_POST['volumeNumber'];
	$hadithNumber = $_POST['hadithNumber'];

    if ($bookNumber != 1 or $collection != "bukhari" or $lang != "english") {
  	  addHadith($urn1, $volumeNumber, $bookID, $bookNumber, $bookName, $babNumber, $babName, $hadithNumber, $text1, $collection, $lang, $live, $username);
	  addHadith($urn2, $volumeNumber, $bookID, $bookNumber, $bookName, $babNumber, $babName, $hadithNumber, $text2, $collection, $lang, $live, $username);
	  deleteReferencesToHadith($urn, $collection, $lang, $live, $username, $lang);

  	// Remove the old URN from session URN list and add the two new ones
	// Assuming that they are of equal length.
	//echo "Before changing <br>";
	//echo print_array($_SESSION['eURNs'], "session eURNs");
	$eurns = $_SESSION['eURNs'];
	$aurns = $_SESSION['aURNs'];
	$posn = array_search($urn, $eurns); 
	//echo "posn is ".$posn;
    array_splice($eurns, $posn, 1, array($urn1, $urn2));
    array_splice($aurns, $posn+1, 0, 0); // Comment this line if the second split hadith shouldn't be matched to a blank
    $_SESSION['eURNs'] = $eurns;
    $_SESSION['aURNs'] = $aurns;
	//echo "After changing <br>";
	//echo print_array($_SESSION['eURNs'], "session eURNs");


    	echo "
      <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
          <tr><td align=center>Changes committed. Probably.</td></tr>
      </table>
      <p align=center>
          Go <a href=\"matchBooks_c.php?coll=".$collection."&lang=$lang&ebooknum=".$ebooknum."&continue=true#".$posn."\">back to matching page</a>
      <br>
	  <!--You may have to refresh or go back to the main collection page in order to see the recent change you just made --> </p>";
    }
    else {
      echo "
      <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr><td align=center>Changes to Book 1 are not committed. It is meant to remain as a didactic example.</td></tr>
      </table>
      <p align=center>
        Go <a href=\"matchBooks_c.php?coll=".$collection."&lang=$lang&ebooknum=".$ebooknum."&continue=true\">back to matching page</a>
      <br>";
    }
	//echo $_POST['text1']."<br>".$_POST['text2'];
}
else {

?>

	<form method="post" action="<?php echo $url; ?>">
    <table width=75% align="center" cellpadding="0" cellspacing="0">
		  <tr><td colspan=2>
			  <table width="60%" cellpadding=3 cellspacing="1" border="1" align="center">
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
      <td width=\"40%\" border=\"1\" valign=\"top\">".$hadith['hadithNumber']."&nbsp;</td>
    </tr>
    <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Book</td>
      <td width=\"40%\" border=\"1\" valign=\"top\">".$hadith['bookName']."(".$hadith['bookNumber'].")</td>
    </tr>
    <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Text</td>
      <td width=\"40%\" border=\"1\" valign=\"top\"><pre style=\"white-space: pre-wrap; white-space: -moz-pre-wrap; word-wrap: break-word;\">".htmlspecialchars($hadith['hadithText'])."</pre></td>
    </tr>";
							$urn1 = getNextURN($urn, $collection, $lang);
							$urn2 = getNextURN($urn1, $collection, $lang);
							$bookName = $hadith['bookName'];
							$bookNumber = $hadith['bookNumber'];
							$bookID = $hadith['bookID'];
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
		Please be careful with not breaking the HTML tags. 
		<font size=3>(HTML tags are those things between &lt; and &gt; , like &lt;p&gt;. They preserve the spacing and formatting. Don't leave out the nearby and surrounding tags when copying)</font>


		</td></tr>
		<tr height=15>
			<input type=hidden name="urn" value="<?php echo $urn;?>">
			<input type=hidden name="urn1" value="<?php echo $urn1;?>">
			<input type=hidden name="urn2" value="<?php echo $urn2;?>">
			<input type=hidden name="volumeNumber" value="<?php echo $volumeNumber;?>">
			<input type=hidden name="bookNumber" value="<?php echo $bookNumber;?>">
			<input type=hidden name="bookID" value="<?php echo $bookID;?>">
			<input type=hidden name="bookName" value="<?php echo $bookName;?>">
			<input type=hidden name="babName" value="<?php echo $babName;?>">
			<input type=hidden name="babNumber" value="<?php echo $babNumber;?>">
			<input type=hidden name="hadithNumber" value="<?php echo $hadithNumber;?>">
		</tr>
             <tr><td colspan=2 border=0>
                <p align=center>
                    Go <a href="matchBooks_c.php?coll=<?php echo $collection;?>&lang=<?php echo $lang; ?>&ebooknum=<?php echo $ebooknum;?>&continue=true#<?php echo $posn;?>">back to matching page</a> without splitting
                </p>
            </td></tr>
             <tr height=15></tr>



		 <tr>
			<td>
				<table border=1>				
					<tr>
				      <td width="20%" border="1" valign="top" align=right>URN</td>
				      <td width="80%" border="1" valign="top"><?php echo $urn1; ?></td>
				    </tr>
				    <tr>
				      <td width="20%" border="1" valign="top" align=right>Book</td>
				      <td width="80%" border="1" valign="top"><?php echo $bookName;?>(<?php echo $bookNumber;?>)</td>
				    </tr>
				    <tr>
				      <td width="20%" border="1" valign="top" align=right>Number</td>
				      <td width="80%" border="1" valign="top"><?php echo $hadithNumber;?></td>
				    </tr>
					<tr>
					  <td width="20%" border="1" valign="top" align=right>Text</td>
				      <td width="80%" border="1" valign="top" align=right>
						<textarea name="text1" class="tastyle"></textarea>
					  </td>
					</tr>
				</table>
			</td>
			<td>
				<table border=1>				
					<tr>
				      <td width="20%" border="1" valign="top" align=right>URN</td>
				      <td width="80%" border="1" valign="top"><?php echo $urn2; ?></td>
				    </tr>
				    <tr>
				      <td width="20%" border="1" valign="top" align=right>Book</td>
				      <td width="80%" border="1" valign="top"><?php echo $bookName;?>(<?php echo $bookNumber;?>)</td>
				    </tr>
				    <tr>
				      <td width="20%" border="1" valign="top" align=right>Number</td>
				      <td width="80%" border="1" valign="top"><?php echo $hadithNumber;?></td>
				    </tr>
					<tr>
					  <td width="20%" border="1" valign="top" align=right>Text</td>
				      <td width="80%" border="1" valign="top" align=right>
							<textarea name="text2" class="tastyle"></textarea>
					  </td>
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


