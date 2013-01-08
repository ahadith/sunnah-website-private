<?php

$page_title = "Book Display";
include "adminheader.php";

include "util.php";

if (isset($_GET['coll'])) $collection = $_GET['coll'];
else $collection = "bukhari";


	if (isset($_GET["ebooknum"]) && is_numeric($_GET["ebooknum"])) {
      $lang = "english";
      $ebooknum = $_GET["ebooknum"];
    }
	elseif (isset($_GET["abooknum"]) && is_numeric($_GET["abooknum"])) {
      $lang = "arabic";
      $abooknum = $_GET["abooknum"];
    }
	else {
      $lang = "english";
      $ebooknum = "1";
    }

	if ($lang == "english")	$urns = getHadithNumbersForEnglishBook($collection, $ebooknum);
    elseif ($lang == "arabic") $urns = getHadithNumbersForArabicBook($collection, $abooknum);

	if (isset($_GET['debug'])) echo print_array($urns, "URNs")."<br>";
?>

	<table width="65%" cellpadding="0" cellspacing="0" align="center" border="0">
				<?php
                    if ($lang == "english") $ahadith = getEnglishAhadith($collection, $urns);
                    elseif ($lang == "arabic") $ahadith = getArabicAhadith($collection, $urns);
					foreach ($urns as $urn) {
						echo "<tr><td>";
						echo "<table width=\"100%\" cellpadding=\"5\" cellspacing=\"0\" align=\"center\" border=\"1\">";
						if ($lang == "english") echo displayEnglishHadith($ahadith[$urn]); 
                        elseif ($lang == "arabic") echo displayArabicHadith($ahadith[$urn]);
						echo "</table></td></tr>
						<tr>
                        	<td height=\"50\" border=\"0\">&nbsp;</td>
                    	</tr>";
					}
				?>							 		
	</table>
<?php 
	//echo "<p align=\"center\"><a href=\"".$url."&done=true"."\">Done</a>"; 
?>

<?php 

mysql_close($con); 
include "footer.php";

?>
