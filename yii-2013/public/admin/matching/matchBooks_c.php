<?php

session_start();

$page_title = "Match Books";
if (isset($_POST['submit_setmatched']) or isset($_POST['submit_setchecked']) or isset($_POST['submit_setverified']) or isset($_GET['emoveup']) or isset($_GET['emovedown']) or isset($_GET['amoveup']) or isset($_GET['amovedown'])) $delay_headers = true;

include "setlang.php";
include "adminheader.php";

include "util.php";

	if (isset($_GET['coll'])) $collection = $_GET['coll'];
	else $collection = "bukhari";

    $debug = false;
    if (isset($_GET['debug'])) $debug = true;

	if (isset($_GET["ebooknum"]) && is_numeric($_GET["ebooknum"])) $ebooknum = $_GET["ebooknum"];
	else $ebooknum = "1";

	// Get matching Arabic book number
	$abooknum_match_obj = getMatchedArabicBooks($collection, array($ebooknum), $lang);
	if ($abooknum_match_obj != NULL) $abooknum = $abooknum_match_obj['abooknums'];
	if ($abooknum != NULL) $abooknum = $abooknum[0];


	if (isset($_GET["abooknum"]) && is_numeric($_GET["abooknum"])) $abooknum = $_GET["abooknum"];
	elseif ($abooknum==NULL) $abooknum = 0;


    $matchstatus = getMatchStatusEnglish($collection, $ebooknum, $lang);

/*  If Mark Book as matched clicked
      If ebooknum > 1 Mark book as matched
    ElseIf Initialize Matching clicked and ebooknum > 1
      Make URNs and sanitize
      Set session vars
      Commit to DB
    ElseIf any of the move options were clicked
      If session URN variables are set use those
      else grab URNs from database and sanitize

      Make move changes

      Sanitize URNs

      Set session URNs

      If ebooknum > 1 Commit to DB

      Redirect to page without GET vars
    Else
      If matchstatus = 0
        Make URNs and sanitize
        Set session vars
      Else grab URNs from DB or session vars and sanitize
      
      Get all ahadith
    End



*/
	$url = $_SERVER['SCRIPT_NAME']."?coll=".$collection."&lang=".$lang."&ebooknum=".$ebooknum;//."&abooknum=".$abooknum;
    if (isset($_POST['submit_setmatched']) and ($ebooknum != 1 or $collection != "bukhari" or $lang != "english")) {
      changeBookMatchStatus($collection, $lang, $ebooknum, 2, $live, $username);
      header("Location: /admin/matching/".$collection.".php?lang=".$lang); 
    }
    elseif (isset($_POST['submit_setchecked']) and ($ebooknum != 1 or $collection != "bukhari" or $lang != "english")) {
      changeBookMatchStatus($collection, $lang, $ebooknum, 3, $live, $username);
	  echo "Now redirecting to <a href=\"".$url."&writeout"."\">here</a>";
      header("Location: ".$url."&writeout"); 
    }
    elseif (isset($_POST['submit_setverified']) and ($ebooknum != 1 or $collection != "bukhari" or $lang != "english")) {
      changeBookMatchStatus($collection, $lang, $ebooknum, 4, $live, $username);
	  echo "Now redirecting to <a href=\"".$url."&writeout"."\">here</a>";
      header("Location: ".$url."&writeout"); 
    }
    elseif (isset($_POST['submit_initialize']) and ($ebooknum != 1 or $collection != "bukhari" or $lang != "english")) {
		echo "Here 1\n";
        $eURNs = getHadithNumbersForEnglishBook($collection, $ebooknum, $lang);
        $aURNs = getHadithNumbersForArabicBook($collection, $abooknum);  
        $retval = sanitizeURNs($eURNs, $aURNs);
        $eURNs = $retval['eURNs'];
        $aURNs = $retval['aURNs'];
        $_SESSION['eURNs'] = $eURNs;
        $_SESSION['aURNs'] = $aURNs;
        commitToDB($eURNs, $aURNs, $live, $username, FALSE, $lang);
        changeBookMatchStatus($collection, $lang, $ebooknum, 1, $live, $username);
        $allEnglishAhadith = getEnglishAhadith($collection, $eURNs, $lang);
        $allArabicAhadith = getArabicAhadith($collection, $aURNs);
        $hadithmap = php_zip($eURNs, $aURNs);
      	header("Location: ".$url); 
    }
    elseif (isset($_POST['submit_checkbook1']) and ($ebooknum == 1 and $collection=="bukhari" and $lang == "english")) {
      $eURNs = $_SESSION['eURNs'];
      $aURNs = $_SESSION['aURNs'];
      echo "Your Book 1 alignment is ";
      if (checkBookOneAlignment($eURNs, $aURNs)) echo "correct :)<br>";
      else echo "wrong :(<br>";
      $allEnglishAhadith = getEnglishAhadith($collection, $eURNs, $lang);
      $allArabicAhadith = getArabicAhadith($collection, $aURNs);
      $hadithmap = php_zip($eURNs, $aURNs);
    }
    elseif (isset($_GET['emoveup']) or isset($_GET['emovedown']) or isset($_GET['amoveup']) or isset($_GET['amovedown'])) {
        // Grab URNs
        if ((false or $ebooknum==1)and isset($_GET['continue']) and ($_SESSION['eURNs'] != NULL) and (URNinBook($_SESSION['eURNs'][0], $ebooknum, $collection, $lang))) {
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

			/* So that code for older books doesn't break */ 
			if (true || $collection == "bukhari" || $collection == "muslim" || $collection == "malik") {
	            $eURNs = $eURNs_orig; $aURNs = $aURNs_match;
    	        foreach ($aURNs_orig as $aURN) {
        	        if (array_search($aURN, $aURNs_match) === FALSE) {
            	        $posn = find_closest_element($aURNs, $aURN);
                	    array_splice($aURNs, $posn, 0, $aURN);
                    	array_splice($eURNs, $posn, 0, 0);
                	}
            	}
			}
			else {
	            $eURNs = $eURNs_match; $aURNs = $aURNs_orig;
    	        foreach ($eURNs_orig as $eURN) {
        	        if (array_search($eURN, $eURNs_match) === FALSE) {
            	        $posn = find_closest_element($eURNs, $eURN);
                	    array_splice($eURNs, $posn, 0, $eURN);
                    	array_splice($aURNs, $posn, 0, 0);
                	}
            	}
			}

            $retval = sanitizeURNs($eURNs, $aURNs);
            $eURNs = $retval['eURNs'];
            $aURNs = $retval['aURNs'];
        }

        // Make move changes
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

        $retval = sanitizeURNS($eURNs, $aURNs);
        $eURNs = $retval['eURNs'];
        $aURNs = $retval['aURNs'];
        $_SESSION['eURNs'] = $eURNs;
        $_SESSION['aURNs'] = $aURNs;
        if ($ebooknum != 1 or $collection!="bukhari" or $lang != "english") {
          commitToDB($eURNs, $aURNs, $live, $username, FALSE, $lang);
          //if ($matchstatus < 2) changeBookMatchStatus($collection, $ebooknum, 1, $live, $username);
        }
        // Redirect!
        header("Location: ".$url."&continue");
    }
    else {
      if ($matchstatus == 0) {
        $eURNs = getHadithNumbersForEnglishBook($collection, $ebooknum, $lang);
        $aURNs = getHadithNumbersForArabicBook($collection, $abooknum);
        $retval = sanitizeURNS($eURNs, $aURNs);
        $eURNs = $retval['eURNs'];
        $aURNs = $retval['aURNs'];
        $_SESSION['eURNs'] = $eURNs;
        $_SESSION['aURNs'] = $aURNs;
      }
      else {
        if ((false or $ebooknum==1) and $_SESSION['eURNs'] != NULL and isset($_GET['continue']) and (URNinBook($_SESSION['eURNs'][0], $ebooknum, $collection, $lang))) {
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
			
			/* So that code for older books doesn't break */ 
			if (true || $collection == "bukhari" || $collection == "muslim" || $collection == "malik") {
	            $eURNs = $eURNs_orig; $aURNs = $aURNs_match;
    	        foreach ($aURNs_orig as $aURN) {
        	        if (array_search($aURN, $aURNs_match) === FALSE) {
            	        $posn = find_closest_element($aURNs, $aURN);
                	    array_splice($aURNs, $posn, 0, $aURN);
                    	array_splice($eURNs, $posn, 0, 0);
                	}
            	}
			}
			else {
	            $eURNs = $eURNs_match; $aURNs = $aURNs_orig;
    	        foreach ($eURNs_orig as $eURN) {
        	        if (array_search($eURN, $eURNs_match) === FALSE) {
            	        $posn = find_closest_element($eURNs, $eURN);
                	    array_splice($eURNs, $posn, 0, $eURN);
                    	array_splice($aURNs, $posn, 0, 0);
                	}
            	}
			}
            
			$retval = sanitizeURNs($eURNs, $aURNs);
            $eURNs = $retval['eURNs'];
            $aURNs = $retval['aURNs'];
            $_SESSION['eURNs'] = $eURNs;
            $_SESSION['aURNs'] = $aURNs;
        }
      }
      $allEnglishAhadith = getEnglishAhadith($collection, $eURNs, $lang);
      $allArabicAhadith = getArabicAhadith($collection, $aURNs);
      $tagArray = getTagStatus(array_merge($eURNs, $aURNs));
      $hadithmap = php_zip($eURNs, $aURNs);
    }

    $debug = isset($_GET['debug']);
    if ($debug) {
      echo print_array($eURNs, "English URNs")."<br>";
      echo print_array($aURNs, "Arabic URNs")."<br>";
    }

    if ($matchstatus >= 2) {
      $eng_zero_key_indices = array_keys($eURNs, 0);
      $arb_zero_key_indices = array_keys($aURNs, 0);
    }
	if (isset($_GET['writeout'])) {
		commitToDB($eURNs, $aURNs, $live, $username, TRUE, $lang);
	}

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

	<div class="UnmatchedURNs">
		<?php
			if (isset($arb_zero_key_indices) && count($arb_zero_key_indices) > 0) {
				echo "<ul>English";
				for ($i = 0; $i < count($arb_zero_key_indices); $i++) {
					echo "<li><a href=\"#".$arb_zero_key_indices[$i]."\">Unmatched URN: ".$eURNs[$arb_zero_key_indices[$i]]."</a></li>";
			}
				echo "</ul>";
			}
			if (isset($eng_zero_key_indices) && count($eng_zero_key_indices) > 0) {
				echo "<ul>Arabic";
				for ($i = 0; $i < count($eng_zero_key_indices); $i++) {
					echo "<li><a href=\"#".$eng_zero_key_indices[$i]."\">Unmatched URN: ".$aURNs[$eng_zero_key_indices[$i]]."</a></li>";
				}
				echo "</ul>";
			}
		?>
	</div>


	<form method="post" action="<?php echo $url ?>">
	<p align=center>
	<input type="submit" name="submit_initialize" value="Initialize matching" 
	<?php if ($matchstatus != 0 or ($ebooknum == 1 and $collection=="bukhari" and $lang=="english")) echo "disabled" ?>>
    <?php if (($ebooknum != 1 or $collection != "bukhari" or $lang != "english") and $matchstatus == 1) { ?>
	  &nbsp;|&nbsp; <input type="submit" name="submit_setmatched" value="Mark book as matched">
    <?php } if (($ebooknum != 1 or $collection != "bukhari" or $lang != "english") and $matchstatus == 2) { ?>
	  &nbsp;|&nbsp; <input type="submit" name="submit_setchecked" value="Mark book as checked">
    <?php } if (($ebooknum != 1 or $collection != "bukhari" or $lang != "english") and $matchstatus > 1) { ?>
	  &nbsp;|&nbsp; <input type="submit" name="submit_setverified" value="Mark book as verified">
	<?php } if ($ebooknum == 1 and $collection == "bukhari" and $lang == "english") { ?>
	  &nbsp;|&nbsp; <input type="submit" name="submit_checkbook1" value="Check Book 1 matching">
	<?php } ?>
	</p>
	</form>

	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="1">
				<?php
					$counter = 0;
					foreach ($hadithmap as $pair) {
						echo "<tr><td>";
						echo "<table width=\"100%\" cellpadding=\"5\" cellspacing=\"0\" align=\"center\" border=\"1\">";
						if (!array_key_exists($pair[0], $allEnglishAhadith)) $allEnglishAhadith[$pair[0]] = NULL;
                        if (!array_key_exists($pair[1], $allArabicAhadith)) $allArabicAhadith[$pair[1]] = NULL;
						echo displayHadithPairAdmin($lang, $allEnglishAhadith[$pair[0]], $allArabicAhadith[$pair[1]], $counter++, $url, $collection, $tagArray[$pair[0]], $tagArray[$pair[1]]); 
						echo "</table></td></tr>
						<tr>
                        	<td height=\"30\" border=\"0\">&nbsp;</td>
                    	</tr>";
					}
				?>							 		
	</table>
<?php 

mysql_close($con); 
include "footer.php";

?>
