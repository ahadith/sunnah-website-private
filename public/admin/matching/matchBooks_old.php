<?php

session_start();

$page_title = "Book Display";
include "adminheader.php";

$con = mysql_connect("localhost", "ilmfruit_ansari", "ansari") or die(mysql_error());
mysql_select_db("ilmfruit_testhadithdb") or die(mysql_error());

include "util.php";

	if (isset($_GET['coll'])) $collection = $_GET['coll'];
	else $collection = "bukhari";

    $debug = false;
    if (isset($_GET['debug'])) $debug = true;

	// For output/debug text printed
	echo "\n<table width=75% align=\"center\" cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>\n";


	if (isset($_GET["ebooknum"]) && is_numeric($_GET["ebooknum"])) $ebooknum = $_GET["ebooknum"];
	else $ebooknum = "1";

	// Get matching Arabic book number
	$abooknum_match_obj = getMatchedArabicBooks(array($ebooknum));
	if ($abooknum_match_obj != NULL) $abooknum = $abooknum_match_obj['abooknums'];
	if ($abooknum != NULL) $abooknum = $abooknum[0];


	if (isset($_GET["abooknum"]) && is_numeric($_GET["abooknum"])) $abooknum = $_GET["abooknum"];
	elseif ($abooknum==NULL) $abooknum = 0;

	$_SESSION['ebooknum'] = $ebooknum;
	$_SESSION['abooknum'] = $abooknum;

	if (isset($_GET['continue']) || isset($_POST['submit_commit']) || isset($_POST['submit_setmatched'])) {
		$unsaved_changes = true;
		echo "Continuing session ... ";
		$eURNs = $_SESSION['eURNs'];
		$aURNs = $_SESSION['aURNs'];
		$prev_eURNs = $_SESSION['prev_eURNs'];
		$prev_aURNs = $_SESSION['prev_aURNs'];
		$_SESSION['prev_eURNs'] = $eURNs;
		$_SESSION['prev_aURNs'] = $aURNs;

		if (isset($_POST['submit_commit'])) {
			if ($ebooknum != 1) {
				if (commitToDB($eURNs, $aURNs, $live, $username)) {
					$unsaved_changes = false;
					echo "(successfully committed changes)<br>";
					changeBookMatchStatus($ebooknum, 1, $live, $username);
				}
				else echo "An error occurred. No changes were committed<br>"; 
			}
			else {
				echo "Book 1 alignment is meant to be didactic, and any changes are not committed. Your alignment is ";
				if (checkBookOneAlignment($eURNs, $aURNs)) echo "correct :)<br>";
				else echo "wrong :(<br>";
			}
		}
		elseif (isset($_POST['submit_setmatched'])) {
			changeBookMatchStatus($ebooknum, 2, $live, $username);
		}
		else echo "<br>";
	}
	else {
		echo "Starting a new session<br>";
		$show_undo = false;
		$unsaved_changes = false;
		$matchstatus = getMatchStatusBukhariEnglish($ebooknum);
		$eURNs_orig = getHadithNumbersForEnglishBook($ebooknum);
    	$aURNs_orig = getHadithNumbersForArabicBook($abooknum);  // use this to initialize matchtable separately.

		if ($matchstatus == 0) {
			$eURNs = $eURNs_orig;
			$aURNs = $aURNs_orig;
		}
		else {
			$eURNs_match = getMatchedEnglishURNs($aURNs_orig);
			$aURNs_match = getMatchedArabicURNs($eURNs_orig);
			//echo print_array($aURNs_match, "matched Arabic URNs")."<br>";
			//echo print_array($aURNs_orig, "retrieved Arabic URNs")."<br>";

			$eURNs = $eURNs_orig; $aURNs = $aURNs_match;
			//echo "Before mixing: ".print_array($eURNs, "eURNs")."   ".print_array($aURNs, "aURNs")."<br>";
			foreach ($aURNs_orig as $aURN) {
				if (array_search($aURN, $aURNs_match) === FALSE) {
					$posn = find_closest_element($aURNs, $aURN);
					array_splice($aURNs, $posn, 0, $aURN);
					array_splice($eURNs, $posn, 0, 0);
				}
			}
			//echo "After mixing: ".print_array($eURNs, "eURNs")."   ".print_array($aURNs, "aURNs")."<br>";

		}
		$_SESSION['eURNs'] = $eURNs;
		$_SESSION['aURNs'] = $aURNs;
	}

	if (isset($_GET['emoveup']) && is_numeric($_GET['emoveup']) && ($_GET['emoveup'] > 0)) {
		$posn = $_GET['emoveup'];//array_search($_GET['emoveup'], $eURNs);
		if ($posn > 0 && $eURNs[$posn-1] == 0) {
			$eURNs = array_merge(array_slice($eURNs, 0, $posn-1), array_slice($eURNs, $posn));
		}			
	}
	if (isset($_GET['amoveup']) && is_numeric($_GET['amoveup']) && ($_GET['amoveup'] > 0)) {
		$posn = $_GET['amoveup'];//array_search($_GET['amoveup'], $aURNs);
		if ($posn > 0 && $aURNs[$posn-1] == 0) {
			$aURNs = array_merge(array_slice($aURNs, 0, $posn-1), array_slice($aURNs, $posn));
		}			
	}
	if (isset($_GET['emovedown']) && is_numeric($_GET['emovedown'])) {
		$posn = $_GET['emovedown'];//array_search($_GET['emovedown'], $eURNs);
		array_splice($eURNs, $posn, 0, 0);
	}
	if (isset($_GET['amovedown']) && is_numeric($_GET['amovedown'])) {
		$posn = $_GET['amovedown'];//array_search($_GET['amovedown'], $aURNs);
		array_splice($aURNs, $posn, 0, 0);
	}

	if (count($eURNs) == 0) $eURNs = array(0);
	if (count($aURNs) == 0) $aURNs = array(0);

	// Pad the shorter one so we have no surprises in the hadithmap
	if (count($eURNs) > count($aURNs)) $aURNs = array_pad($aURNs, count($eURNs), 0);
	if (count($aURNs) > count($eURNs)) $eURNs = array_pad($eURNs, count($aURNs), 0);

	// Get rid of pairs of zeros at the ends
	if ($eURNs[count($eURNs)-1] == 0 && $aURNs[count($aURNs)-1] == 0) {
		$eURNs = array_slice($eURNs, 0, count($eURNs)-1);
		$aURNs = array_slice($aURNs, 0, count($aURNs)-1);
	}

	if (isset($_GET['undo'])) {
		$eURNs = $prev_eURNs;
		$aURNs = $prev_aURNs;
		$_SESSION['eURNs'] = $eURNs;
		$_SESSION['aURNs'] = $aURNs;
		$show_undo = false;
		$unsaved_changes = true;
	}
	else {
		if (isset($_GET['continue'])) $show_undo = true;
		$_SESSION['eURNs'] = $eURNs;
		$_SESSION['aURNs'] = $aURNs;
	}
	
	if ($debug) {
      echo print_array($eURNs, "English URNs")."<br>";
	  echo print_array($aURNs, "Arabic URNs")."<br>";
    }
	$hadithmap = php_zip($eURNs, $aURNs);

    $allEnglishAhadith = getEnglishAhadith($eURNs);
    $allArabicAhadith = getArabicAhadith($aURNs);

	$url = $_SERVER['SCRIPT_NAME']."?coll=".$collection."&ebooknum=".$ebooknum;//."&abooknum=".$abooknum;

	echo "</td></tr></table>\n";
?>

    <table width=75% align="center" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td colspan=2>

                <table width="100%" border=0 cellspacing=0 cellpadding=0>
                    <tr height=50 bgcolor=#000000>
                        <td><div align=right class="nameHeader">Book Display</div></td>
                        <td width="4%"></td>
                    </tr>
<!--                    <tr bgcolor="#DEE4D6" height=15>
                        <td align=center colspan=2 border=0></td>
                    </tr>
-->
                </table>
            
            </td>
        </tr>
	</table>

	<form method="post" action="<?php echo $url ?>">
	<p align=center>
	<?php
		if ($show_undo) echo "&nbsp;|&nbsp;<a href=\"".$url."&continue=true&undo=true\">Undo Last change</a>";
        else echo "&nbsp;<font color=\"gray\">Undo Last change</font>";
	?>
	&nbsp;|&nbsp;<a href="<?php echo $url ?>">Undo all changes since last commit</a>
	&nbsp;|&nbsp;<input type="submit" name="submit_commit" value="Commit current matching">
	&nbsp;|&nbsp;&nbsp;<input type="submit" name="submit_setmatched" value="Mark book as matched" <?php if ($unsaved_changes) echo "disabled"?>>
	</p>
	</form>

	<table width="75%" cellpadding="0" cellspacing="0" align="center" border="1">
				<?php
					$counter = 0;
					foreach ($hadithmap as $pair) {
						echo "<tr><td>";
						echo "<table width=\"100%\" cellpadding=\"5\" cellspacing=\"0\" align=\"center\" border=\"1\">";
						echo displayHadithPairAdmin($allEnglishAhadith[$pair[0]], $allArabicAhadith[$pair[1]], $counter++, $url, $collection); 
						echo "</table></td></tr>
						<tr>
                        	<td height=\"30\" border=\"0\">&nbsp;</td>
                    	</tr>";
					}
				?>							 		
	</table>
<?php 
	//echo "<p align=\"center\"><a href=\"".$url."&done=true"."\">Done</a>"; 
?>

	<form method="post" action="<?php echo $url ?>">
	<p align=center>
	<?php
		if ($show_undo) echo "&nbsp;|&nbsp;<a href=\"".$url."&continue=true&undo=true\">Undo Last change</a>";
        else echo "&nbsp;<font color=\"gray\">Undo Last change</font>";
	?>
	&nbsp;|&nbsp;<a href="<?php echo $url ?>">Undo all changes since last commit</a>
	&nbsp;|&nbsp;<input type="submit" name="submit_commit" value="Commit current matching">
	&nbsp;|&nbsp;&nbsp;<input type="submit" name="submit_setmatched" value="Mark book as matched" <?php if ($unsaved_changes) echo "disabled"?>>
	</p>
	</form>

<?php 

mysql_close($con); 
include "footer.php";

?>
