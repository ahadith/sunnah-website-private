<?php
include "setlang.php";
include "adminheader.php";

include "util.php";

$ebooks = getEnglishBooks($collection, $lang);
$abooks_orig = getArabicBooks($collection);
$retval = getMatchedArabicBooks($collection, $ebooks['nums'], $lang);
$abooknums_matched = $retval['abooknums'];
$bookMatchArray = $retval['matched'];
$bookUserArray = $retval['usernames'];
$ebooknums = $ebooks['nums'];
$ebooknames = $ebooks['names'];
$abooknums = $abooknums_matched;
$abooknums_orig = $abooks_orig['nums'];
$abooknames = $abooks_orig['names'];
$ebooknums_orig = $ebooknums;

foreach ($abooknums_orig as $abooknum) {
            if (array_search($abooknum, $abooknums_matched) === FALSE) {
                $posn = find_closest_element($abooknums, $abooknum);
                array_splice($abooknums, $posn, 0, $abooknum);
                array_splice($ebooknums, $posn, 0, 0);
            }
        }

$englishBookCounts = getBookCounts($collection, $lang);
$arabicBookCounts = getBookCounts($collection, "arabic");

$statusCounts = getStatusCounts($collection, $lang);
$overallNumMatched = $statusCounts[2]+$statusCounts[3]+$statusCounts[4];
$overallNumInProgress = $statusCounts[1];
$overallNumUnmatched = $statusCounts[0];
$overallNumTotal = $statusCounts['total'];

$matchedRatio = 0; $unmatchedRatio = 0; $inProgressRatio = 0;

if ($overallNumTotal > 0) {
  $verifiedRatio = round(100*$statusCounts[4]/$overallNumTotal, 2);
  $checkedRatio = round(100*($statusCounts[3]+$statusCounts[4])/$overallNumTotal, 2);
  $matchedRatio = round(100*$overallNumMatched/$overallNumTotal, 2);
  $unmatchedRatio = round(100*$overallNumUnmatched/$overallNumTotal, 2);
  $inProgressRatio = round(100*$overallNumInProgress/$overallNumTotal, 2);
}

?>

<body bgcolor="#DEE4D6">

	<table width="75%" cellpadding="3" cellspacing="0" align="center" border=0>
		<tr><td align=center>
			<b>Overall Status</b><br>
			<table>
				<tr>
					<td><font color="#C68E17"><b>Verified </b></font></td>
					<td>:<font color="#C68E17"><b> <?php echo $statusCounts[4]."/".$overallNumTotal." (".$verifiedRatio."%)";?></b></font></td>
				</tr>
				<tr>
					<td><font color="green"><b>Checked</b></font></td>
					<td>:<font color="green"><b> <?php echo ($statusCounts[3]+$statusCounts[4])."/".$overallNumTotal." (".$checkedRatio."%)";?></b></font></td>
				</tr>
				<tr>
					<td><font color=green>Matched </font></td>
					<td>:<font color=green> <?php echo $overallNumMatched."/".$overallNumTotal." (".$matchedRatio."%)";?></font></td>
				</tr>
				<tr>
					<td><font color=blue>In progress </font></td>
					<td>:<font color=blue> <?php echo $overallNumInProgress."/".$overallNumTotal." (".$inProgressRatio."%)";?><br></font></td>
				</tr>
				<tr>
					<td><font color=red>Unmatched </font></td>
					<td>:<font color=red> <?php echo $overallNumUnmatched."/".$overallNumTotal." (".$unmatchedRatio."%)";?><br></font></td>
				</tr>
			</table>
		</td></tr>
		<tr height=15></tr>
	</table>
	<table width="100%" cellpadding="3" cellspacing="0" align="center" border="1">
		<tr>
			<td align="center">Book</td>
			<td align="center">Book Name</td>
			<td align="center">Book Name</td>
			<td align="center">Book</td>
			<td align="center">Status</td>
			<td align="center">User</td>
			<td align="center">Chapters Link</td>
		</tr>
				<?php
					for ($i = 0; $i < count($ebooknums); $i++) {
						$abookindex = array_search($abooknums[$i], $abooknums_orig);
						$ebookindex = array_search($ebooknums[$i], $ebooknums_orig);
						if ($ebookindex === FALSE) $ebookname = "";
						else $ebookname = $ebooknames[$ebookindex];
						if ($abookindex === FALSE) $abookname = "";
						else $abookname = $abooknames[$abookindex];

						if (!array_key_exists($i, $ebooknums)) $ebooknums[$i] = NULL;
						if (!array_key_exists($i, $abooknums)) $abooknums[$i] = NULL;
						echo displayBookPairAdmin($collection, $lang, 
												  $ebooknums[$i], 
                                                  $ebookname, 
                                                  $englishBookCounts[$ebooknums[$i]], 
												  $abooknums[$i], 
												  $abookname, 
												  $arabicBookCounts[$abooknums[$i]], 
												  $bookMatchArray[$ebooknums[$i]], 
												  $bookUserArray[$ebooknums[$i]]
												 );
					}
				?>							 		
	</table>

<?php 

mysql_close($con); 
include "footer.php";
?>	
