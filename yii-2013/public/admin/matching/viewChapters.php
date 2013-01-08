<?php

$page_title = "Book Chapters";
include "setlang.php";
include "adminheader.php";

include "util.php";

	if (isset($_GET['coll'])) $collection = $_GET['coll'];
	else $collection = "bukhari";

	if (isset($_GET["ebooknum"]) && is_numeric($_GET["ebooknum"])) $ebooknum = $_GET["ebooknum"];
	else $ebooknum = "1";

	if (isset($_GET["abooknum"]) && is_numeric($_GET["abooknum"])) $abooknum = $_GET["abooknum"];
	else $abooknum = "1";

	$url = $_SERVER['SCRIPT_NAME']."?coll=".$collection."&lang=$lang&ebooknum=".$ebooknum;//."&abooknum=".$abooknum;

	$echaps = getChapters($collection, $lang, $ebooknum); 
	$achaps = getChapters($collection, "arabic", $abooknum); 

?>

<script type="text/javascript">
  function mergePopup(lang, urn) {
    window.open("mergePopup.php?coll="+<?php echo "'".$collection."'"; ?>+"&lang="+lang+"&first="+urn, "myWindow", "status = 0, height = 600, width = 500, resizable = 1, fullscreen = 1");
  }
  
  function tagPopup(lang, urn) {
    window.open("tagPopup.php?coll="+<?php echo "'".$collection."'"; ?>+"&lang="+lang+"&urn="+urn, "myWindow", "status = 0, height = 600, width = 800, resizable = 1, fullscreen = 1");
  }
  
  function addPopup(lang, otherurn) {
    window.open("addPopup.php?coll="+<?php echo "'".$collection."'"; ?>+"&lang="+lang+"&otherurn="+otherurn, "myWindow", "scrollbars = yes, 	status = 0, height = 600, width = 800, resizable = 1, fullscreen = 1");
  }
</script>


	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="1">
				<?php
					$counter = 0;
					foreach ($achaps as $achap) {
						echo "<tr><td>";
						echo "<table width=\"100%\" cellpadding=\"5\" cellspacing=\"0\" align=\"center\" border=\"1\">";
						echo displayChapterPair($collection, $ebooknum, $abooknum, $achap, $echaps[$counter], $counter+1, $lang);
						echo "</table></td></tr>
						<tr>
                        	<td height=\"30\" border=\"0\">&nbsp;</td>
                    	</tr>";
						$counter++;
					}
				?>							 		
	</table>

<?php 

mysql_close($con); 
include "footer.php";

?>
