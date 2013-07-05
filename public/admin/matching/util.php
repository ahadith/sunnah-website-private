<?php

//mysql_connect("localhost", "ilmfruit_ansari", "ansari") or die(mysql_error());
//mysql_select_db("ilmfruit_testhadithdb") or die(mysql_error());

$live = true;

function getHadith($collection, $lang, $urn) {
	$db_name = $collection."_".$lang;
    if (!is_null($urn) && is_numeric($urn)) {
        if ($urn > 0) {
            $hadith_q = mysql_query("SELECT * FROM ".$db_name." WHERE ".$lang."URN = ".$urn)
                or die(mysql_error());
            $hadith = mysql_fetch_array($hadith_q);
            return $hadith;
        }
        else return NULL;
    }
    else return NULL;
}

function getEnglishHadith($collection, $eurn, $lang = "english") {
	if (!is_null($eurn) && is_numeric($eurn)) {
		if ($eurn > 0) {
			$eng_hadith_q = mysql_query("SELECT * FROM ".$collection."_".$lang." WHERE ".$lang."URN = ".$eurn)
    			or die(mysql_error());
    		$eng_hadith = mysql_fetch_array($eng_hadith_q);
			return $eng_hadith;
		}
		else return NULL;
	}
	else return NULL;
}

function getEnglishAhadith($collection, $eurns, $lang = "english") {
  
  $eurns_string = "(";
  foreach ($eurns as $eurn) {
    if (!is_null($eurn) && is_numeric($eurn) && $eurn > 0) $eurns_string = $eurns_string.$eurn.",";
  }
  $eurns_string = substr($eurns_string, 0, -1).")";
  if (strlen($eurns_string) > 1) {
    $eng_hadith_q = mysql_query("SELECT * FROM ".$collection."_".$lang." WHERE ".$lang."URN in ".$eurns_string)
      or die(mysql_error());
    while ($eng_hadith = mysql_fetch_array($eng_hadith_q)) $ahadith[$eng_hadith[$lang.'URN']] = $eng_hadith;
  	return $ahadith;
  }
  else return NULL;
}

function getArabicHadith($collection, $aurn) {
	if (!is_null($aurn) && is_numeric($aurn)) {
    	$arb_hadith_q = mysql_query("SELECT * FROM ".$collection."_arabic WHERE arabicURN = ".$aurn)
        	or die(mysql_error());
        $arb_hadith = mysql_fetch_array($arb_hadith_q);
		return $arb_hadith;
    }
	else return NULL;
}

function getArabicAhadith($collection, $aurns) {

  $aurns_string = "(";
  foreach ($aurns as $aurn) {
    if (!is_null($aurn) && is_numeric($aurn) && $aurn > 0) $aurns_string = $aurns_string.$aurn.",";
  }
  if (substr($aurns_string, -1, 1) == ',') $aurns_string = substr($aurns_string, 0, -1);
  $aurns_string = $aurns_string.")";
  if (count($aurns) > 0 && strlen($aurns_string) > 2) {
    $arb_hadith_q = mysql_query("SELECT * FROM ".$collection."_arabic WHERE arabicURN in ".$aurns_string)
      or die(mysql_error());
    while ($arb_hadith = mysql_fetch_array($arb_hadith_q)) $ahadith[$arb_hadith['arabicURN']] = $arb_hadith;
  	return $ahadith;
  }
  else return NULL;
}

function getHadithNumbersForEnglishBook($collection, $ebooknum, $lang = "english") {
	$hadithnums = array();
	if (!is_null($ebooknum) && is_numeric($ebooknum)) {
		$hadithnums_q = mysql_query("SELECT ".$lang."URN from ".$collection."_".$lang." WHERE bookID = ".$ebooknum." order by ".$lang."URN")
			or die(mysql_error());
		while ($row = mysql_fetch_array($hadithnums_q)) {
			$hadithnums[] = $row[$lang.'URN'];
		}
		return $hadithnums;
	}
	else return array();
}

function getURNs_search($language) {
	if ($language == "english") {
		$final_array = array();
		$collections = array("bukhari", "muslim");
		foreach ($collections as $collection) {
			$db_name = $collection."_english";
			$query = "SELECT ".$language."URN from ".$db_name." WHERE bookID != 0 and bookID in (select ".$language."BookID from ".$collection."bookmatch where ".$language."matchstatus > 1)";
			$hadithnums_q = mysql_query($query) or die(mysql_error().$query);
        	while ($row = mysql_fetch_array($hadithnums_q)) {
            	$hadithnums[] = $row['englishURN'];
        	}
        	$final_array = array_merge($final_array, $hadithnums);
		}
		return $final_array;
	}
}

function getHadithNumbersForArabicBook($collection, $abooknum) {
	if (!is_null($abooknum) && is_numeric($abooknum)) {
		$hadithnums_q = mysql_query("SELECT arabicURN from ".$collection."_arabic WHERE bookID = ".$abooknum." order by arabicURN")
			or die(mysql_error());
		while ($row = mysql_fetch_array($hadithnums_q)) {
			$hadithnums[] = $row['arabicURN'];
		}
		return $hadithnums;
	}
	else return NULL;
}


function getMatchedArabicURNs($eURNs, $lang = "english") {
	$aURNs = $eURNs;
	$counter = 0;
	foreach ($eURNs as $eURN) {
		$urn_query = mysql_query("SELECT arabicURN FROM ".$lang."matchtable WHERE ".$lang."URN = ".$eURN)
        	or die(mysql_error());
        $arabic_urn_a = mysql_fetch_array($urn_query);
        $aURN = $arabic_urn_a['arabicURN'];
		if ($aURN != NULL) $aURNs[$counter++] = $aURN;
		else $aURNs[$counter++] = 0;
	}
	return $aURNs;
}

function getMatchedEnglishURNs($aURNs, $lang = "english") {
	$eURNs = $aURNs;
	$counter = 0;
	foreach ($aURNs as $aURN) {
		$urn_query = mysql_query("SELECT ".$lang."URN FROM ".$lang."matchtable WHERE arabicURN = ".$aURN)
        	or die(mysql_error());
        $english_urn_a = mysql_fetch_array($urn_query);
        $eURN = $english_urn_a[$lang.'URN'];
		if ($eURN != NULL) $eURNs[$counter++] = $eURN;
		else $eURNs[$counter++] = 0;
	}
	return $eURNs;
}

function getChapters($collection, $lang, $bookID) {
	$query = "SELECT * from ".$lang."Chapters where collection = '".addslashes($collection)."' and bookID = $bookID order by babID";
	$q = mysql_query($query) or die(mysql_error().$query);
	while ($row = mysql_fetch_array($q)) {
		$chapters[] = $row;
	}
	return $chapters;
}

function getChapter($collection, $lang, $bookID, $babID) {
	$query = "SELECT * from ".$lang."Chapters where collection = '".addslashes($collection)."' and bookID = $bookID  and babID = $babID";
	$q = mysql_query($query) or die(mysql_error().$query);
	while ($row = mysql_fetch_array($q)) {
		$chapter = $row;
	}
	return $chapter;
}

function getBookNumber($urn, $collection, $lang) {
    $db_name = $collection."_".$lang;
    $booknum = 0;
    if ($urn > 0) {
      $book_query = mysql_query("SELECT bookNumber, bookID FROM ".$db_name." WHERE ".$lang."URN = ".$urn)
          or die(mysql_error());
      $book_query_a = mysql_fetch_array($book_query);
      //$booknum = $book_query_a['bookNumber'];
      $booknum = $book_query_a['bookID'];
    }
    return $booknum;
}

function getMatchingBookID($bookID, $collection, $lang) {
    $db_name = $collection."bookmatch";
    $matchingbookID = 0;
    if ($bookID != 0) {
      $book_query = mysql_query("SELECT * FROM ".$db_name." WHERE ".$lang."BookID = ".$bookID)
          or die(mysql_error());
      $matchingbookID = mysql_fetch_array($book_query);
    }
    return $matchingbookID;
}

function getEnglishBooks($collection, $lang = "english") {
	$ebooks_q = mysql_query("SELECT * from ".$collection.$lang."book where bookID != 0 order by bookID") or die(mysql_error());
    $nums = array();
    $names = array();
	while ($row = mysql_fetch_array($ebooks_q)) {
		$nums[] = $row['bookID'];
		$names[] = $row['bookName'];
	}
	$ebooks['nums'] = $nums;
	$ebooks['names'] = $names;
	return $ebooks;
}

function getBookName($collection, $language, $bookID) {
    $book_q = mysql_query("SELECT bookName from ".$collection.$language."book where bookID = ".$bookID) or die(mysql_error());
    while ($row = mysql_fetch_array($book_q)) {
        $bookName = $row['bookName'];
    }
    return $bookName;
}

function getBookNumber2($collection, $language, $bookID) {
    $book_q = mysql_query("SELECT bookNum from ".$collection.$language."book where bookID = ".$bookID) or die(mysql_error());
    while ($row = mysql_fetch_array($book_q)) {
        $bookNumber = $row['bookNum'];
    }
    return $bookNumber;
}


function getArabicBooks($collection) {
	$abooks_q = mysql_query("SELECT * from ".$collection."arabicbook where bookID != 0 order by bookID") or die(mysql_error());
	while ($row= mysql_fetch_array($abooks_q)) {
		$nums[] = $row['bookID'];
		$names[] = $row['bookName'];
	}
	$abooks['nums'] = $nums;
	$abooks['names'] = $names;
	return $abooks;
}

function getMatchedArabicBooks($collection, $ebooknums, $lang = "english") {
	$abooknums = $ebooknums;
	$counter = 0;
	foreach ($ebooknums as $ebooknum) {
		$urn_query = mysql_query("SELECT arabicBookID, ".$lang."matchstatus, ".$lang."username FROM ".$collection."bookmatch WHERE ".$lang."BookID = ".$ebooknum)
        	or die(mysql_error());
        $abooknum_q = mysql_fetch_array($urn_query);
        $abooknum = $abooknum_q['arabicBookID'];
		if ($abooknum != NULL) {
			$abooknums[$counter++] = $abooknum;
			$matched[$ebooknum] = $abooknum_q[$lang.'matchstatus'];
			if ($abooknum_q[$lang.'username'] != NULL) $usernames[$ebooknum] = $abooknum_q[$lang.'username'];
			else $usernames[$ebooknum] = "";
		}
		else $abooknums[$counter++] = 0;
	}
	$retval['abooknums'] = $abooknums;
	$retval['matched'] = $matched;
	$retval['usernames'] = $usernames;
	return $retval;
}

function getMatchStatusEnglish($collection, $ebooknum, $lang = "english") {
	$query = mysql_query("select ".$lang."matchstatus from ".$collection."bookmatch where ".$lang."BookID = ".$ebooknum)
		or die(mysql_error());
	$query = mysql_fetch_array($query);
	if ($query == NULL) return 0;
	else return $query[$lang.'matchstatus'];
}

function getBookCounts($collection, $language) {
	$query = mysql_query("SELECT bookID, count(hadithNumber) from ".$collection."_".$language." group by bookID")
		or die(mysql_error());
	while ($row = mysql_fetch_array($query)) {
		$counts[$row['bookID']] = $row['count(hadithNumber)'];
	}
	return $counts;
}

function php_zip($enumbers, $anumbers) {
	return array_map(NULL, $enumbers, $anumbers);
}

function commitToDB($enumbers, $anumbers, $live, $username, $hnumbers = FALSE, $lang = "english") {

	//$live indicates whether we want changed to be committed or not.
	$hadithmap = php_zip($enumbers, $anumbers);
	$english_nums = "("; // Could streamline this to use the implode function
	$arabic_nums = "(";
	foreach ($hadithmap as $pair) {
		if ($pair[0] > 0) {
			$english_nums = $english_nums.$pair[0].",";
		}
		if ($pair[1] > 0) {
			$arabic_nums = $arabic_nums.$pair[1].",";
		}
	}
	$english_nums = substr($english_nums, 0, -1).")";
	$arabic_nums = substr($arabic_nums, 0, -1).")";
	
    $deleteQuery1 = "DELETE FROM ".$lang."matchtable WHERE ".$lang."URN in ".$english_nums;
    $deleteQuery2 = "DELETE FROM ".$lang."matchtable WHERE arabicURN in ".$arabic_nums;
	if ($live && strlen($english_nums) > 1) $delete_q = mysql_query($deleteQuery1) or die(mysql_error());
	if ($live && strlen($arabic_nums) > 1) $delete_q = mysql_query($deleteQuery2) or die(mysql_error());
	
	$values_string = "";
	$counter = 1;
	foreach ($hadithmap as $pair) {
		if ($pair[0] == NULL) $pair[0] = 0;
		if ($pair[1] == NULL) $pair[1] = 0;
		if ($pair[0] > 0 || $pair[1] > 0) {
			if ($hnumbers == TRUE) 
				$values_string = $values_string."(".$pair[0].",".$pair[1].", $counter),";
			else
				$values_string = $values_string."(".$pair[0].",".$pair[1]."),";
		}
		$counter++;
	}
	$values_string = substr($values_string, 0, -1);
    if ($hnumbers == TRUE) {$insertQuery = "INSERT INTO ".$lang."matchtable(".$lang."URN, arabicURN, ourHadithNumber) VALUES ".$values_string;}
    else $insertQuery = "INSERT INTO ".$lang."matchtable(".$lang."URN, arabicURN) VALUES ".$values_string;
	if ($live) $insert_q = mysql_query($insertQuery)
		or die(mysql_error()."INSERT INTO ".$lang."matchtable VALUES ".$values_string);

	$queryData = $deleteQuery1.";\n".$deleteQuery2.";\n".$insertQuery.";\n";
	appendSQL($queryData, $live, $username);    

	return 1;
}

function modifyDB($query, $live, $username) {
	if ($live) $mod_q = mysql_query($query) or die(mysql_error().": ".$query);
	appendSQL($query.";\n", $live, $username);
	return 0;
}

function appendSQL($queryData, $live, $username) {
      $timestamp = date("H:i:s M d Y", time());
	  if ($live) $liveval = "true";
	  else $liveval = "false";
      $fullString = "/* Committed by ".$username." at ".$timestamp." (live = ".$liveval.")*/\n".$queryData."\n";
      $cumulativeFile = fopen("/var/www/hadith/yii/public/admin/matching/matchdata/all.sql", 'a');
      fwrite($cumulativeFile, $fullString);
      fclose($cumulativeFile);

      // Email the queries to sunnahhadith@gmail.com to keep track
      $to = "sunnah@iman.net";
      $subject = "[Matching] Commit by ".$username;
      $headers = "From: matching@sunnah.com";
      mail($to, $subject, $fullString, $headers);
}

function changeBookMatchStatus($collection, $lang, $ebooknum, $newstatus, $live, $username) {
	if ($newstatus == 1) $update_q_str = "UPDATE ".$collection."bookmatch set ".$lang."matchstatus=".$newstatus.", ".$lang."username='".$username."' where ".$lang."BookID = ".$ebooknum;
	else $update_q_str = "UPDATE ".$collection."bookmatch set ".$lang."matchstatus=".$newstatus." where ".$lang."BookID = ".$ebooknum;
	return modifyDB($update_q_str, $live, $username);
}

function displayBookPairAdmin($collection, $lang, $ebooknum, $ebookname, $ebookcount, $abooknum, $abookname, $abookcount, $matched, $user) {

    if ($matched == 2) $matchedText = "<font color=\"green\">Matched</font>";
    elseif ($matched == 3) $matchedText = "<font color=\"green\"><b>Checked</b></font>";
    elseif ($matched == 4) $matchedText = "<font color=\"#C68E17\"><b>Verified</b></font>";
	elseif ($matched == 1) $matchedText = "<font color=\"blue\">In progress</font>";
	else $matchedText =  "<font color=\"red\">Unmatched</font>";
	
	$aligndirn = "left";
	if (strcmp($lang, "urdu") == 0) $aligndirn = "right";

	if (is_null($ebookcount)) $ebookcount = 0;
	if (is_null($abookcount)) $abookcount = 0;
	if ($ebooknum != 0 && $abooknum != 0) {
		$rowsHTML = "
				<tr>
					<td width=\"4%\" align=\"center\">".round($ebooknum-0.5, 0)."</td>
					<td align=$aligndirn><a href=\"matchBooks_c.php?coll=".$collection."&lang=".$lang."&ebooknum=".$ebooknum."\"><span class=\"".$lang."Hadith_old\">".$ebookname." </span></a>&nbsp;(&nbsp;".$ebookcount."&nbsp;)&nbsp;</td>
					<td align=\"right\"><a href=\"matchBooks_c.php?coll=".$collection."&lang=".$lang."&ebooknum=".$ebooknum."\">&nbsp;(".$abookcount.") <span class=\"arabicHadith_old\">".$abookname."&nbsp;</span></a></td>
					<td width=\"5%\" align=\"center\">".round($abooknum-0.5, 0)."</td>
					<td align=center>".$matchedText."</td>
					<td align=center>".$user."&nbsp; </td>
					<td align=center><a href=\"viewChapters.php?coll=$collection&lang=$lang&ebooknum=$ebooknum&abooknum=$abooknum\">Chapters</a></td>
			    </tr>";
	}
	elseif ($ebooknum == 0) {
		$rowsHTML = "
				<tr>
					<td width=\"4%\" align=\"center\">&nbsp;</td>
					<td>&nbsp;</td>
					<td align=\"right\"><a href=\"viewSingleBook.php?coll=".$collection."&abooknum=".$abooknum."\">&nbsp;(".$abookcount.") <span class=\"arabicHadith_old\">".$abookname."</span></a></td>
					<td width=\"5%\" align=\"center\">".round($abooknum,0)."</td>
					<td>&nbsp;</td>
					<td> &nbsp;</td>
			    </tr>";
	}
	elseif ($abooknum == 0) {
		$rowsHTML = "
				<tr>
					<td width=\"4%\" align=\"center\">".round($ebooknum,0)."</td>
					<td><a href=\"viewSingleBook.php?coll=".$collection."&lang=".$lang."&ebooknum=".$ebooknum."\">".$ebookname." (".$ebookcount.")</a></td>
					<td align=\"right\">&nbsp;</td>
					<td width=\"5%\" align=\"center\"><font size=\"5\">&nbsp;</font></td>
					<td>&nbsp;</td>
					<td> &nbsp;</td>
			    </tr>";
	}
	return $rowsHTML;
}

function displayBookPair($collection, $ebooknum, $ebookname, $ebookcount, $abooknum, $abookname, $abookcount, $matched) {

	if ($ebooknum != 0 && $abooknum != 0 && $matched == 2 && $ebooknum > 0) {
		$rowsHTML = "
				<tr>
					<td width=\"4%\" align=\"center\">".round($ebooknum-0.5, 0)."</td>
					<td><a href=\"viewBook.php?coll=".$collection."&ebooknum=".$ebooknum."\">".$ebookname." (".$ebookcount.")</a></td>
					<td align=\"right\"><a href=\"viewBook.php?coll=".$collection."&ebooknum=".$ebooknum."\">&nbsp;(".$abookcount.") <span class=\"arabicHadith_old\">".$abookname."&nbsp;</span></a></td>
					<td width=\"5%\" align=\"center\">".round($abooknum-0.5, 0)."</td>
			    </tr>";
		return $rowsHTML;
	}
	elseif ($ebooknum != 0 && $abooknum != 0) {
		$rowsHTML = "
				<tr>
					<td width=\"4%\" align=\"center\">".round($ebooknum-0.5, 0)."</td>
					<td>".$ebookname." (".$ebookcount.")</td>
					<td align=\"right\">&nbsp;(".$abookcount.") <span class=\"arabicHadith_old\">".$abookname."&nbsp;</span></td>
					<td width=\"5%\" align=\"center\">".round($abooknum-0.5, 0)."</td>
			    </tr>";
		return $rowsHTML;
	}
	else return "";
}
function displayEnglishHadith($eng_hadith) {
  $rowsHTML = "
    <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Eng. URN</td>
      <td width=\"40%\" border=\"1\" valign=\"top\">".$eng_hadith['englishURN']."</td>
    </tr>
    <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Number</td>
      <td width=\"40%\" border=\"1\" valign=\"top\">".$eng_hadith['hadithNumber']."&nbsp;</td>
    </tr>
    <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Book</td>
      <td width=\"40%\" border=\"1\" valign=\"top\">".$eng_hadith['bookName']."(".$eng_hadith['bookNumber'].")</td>
    </tr>
    <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Text</td>
      <td width=\"40%\" border=\"1\" valign=\"top\"><font name=\"Verdana\" size=\"4\">".$eng_hadith['hadithText']."</td>
    </tr>
    ";
    return $rowsHTML;
}

function displayArabicHadith($hadith) {
	if (isset($hadith['annotations'])) $ahadithText = $hadith['hadithText']."<br><br>".$hadith['annotations'];
	else $ahadithText = $hadith['hadithText'];

  $rowsHTML = "
    <tr>
      <td width=\"40%\" border=\"1\" valign=\"top\" align=right>".$hadith['arabicURN']."</td>
      <td width=\"10%\" border=\"1\" valign=\"top\">Arb. URN</td>
    </tr>
    <tr>
      <td width=\"40%\" border=\"1\" valign=\"top\" align=right>".$hadith['hadithNumber']."&nbsp;</td>
      <td width=\"10%\" border=\"1\" valign=\"top\">Number</td>
    </tr>
    <tr>
      <td width=\"40%\" border=\"1\" valign=\"top\" align=right>(".$hadith['bookNumber'].") <font size=5>".$hadith['bookName']."</font></td>
      <td width=\"10%\" border=\"1\" valign=\"top\">Book</td>
    </tr>
    <tr>
      <td width=\"40%\" border=\"1\" valign=\"top\" align=right>(".$hadith['babNumber'].") <font size=5>".$hadith['babName']."</font></td>
      <td width=\"10%\" border=\"1\" valign=\"top\">Bab</td>
    </tr>
    <tr>
      <td width=\"40%\" border=\"1\" valign=\"top\" align=right><span class=\"arabicHadith_old\">".$ahadithText."</span></td>
      <td width=\"10%\" border=\"1\" valign=\"top\">Text</td>
    </tr>
    ";
    return $rowsHTML;
}

function displayChapterPair($collection, $ebooknum, $abooknum, $achap, $echap, $counter, $lang = "english") {

	if ($echap == NULL) $echapno = $achap['babID'];
	else $echapno = $echap['babID'];

	$englishModifyLink = " (<a href=\"modifyChapter.php?coll=$collection&lang=$lang&pagelang=$lang&ebooknum=$ebooknum&abooknum=$abooknum&babid=$echapno&posn=$counter\">Modify</a>) ";
	$arabicModifyLink = " (<a href=\"modifyChapter.php?coll=$collection&lang=arabic&pagelang=$lang&ebooknum=$ebooknum&abooknum=$abooknum&babid=".$achap['babID']."&posn=$counter\">Modify</a>) ";
	if (strlen($achap['babName']) == 200) $arabicModifyLink .= "Potentially incomplete";
	if (strlen($echap['babName']) >= 87 and strlen($echap['babName']) <= 100) $englishModifyLink .= "Potentially incomplete";
	$rowsHTML =  "
                    <tr><a name=\"$counter\">
						<td width=\"10%\" border=\"1\" valign=\"top\" align=right>".$echap['babNumber']."(ID: ".$echap['babID'].")</td>
						<td width=\"40%\" border=\"1\" valign=\"top\">".$echap['babName'].$englishModifyLink."</td>
						<td width=\"40%\" border=\"1\" valign=\"bottom\" align=\"right\"><span class=\"achap\" dir=\"rtl\">".$achap['babName']."</span>&nbsp;<br>".$arabicModifyLink."</td>
						<td width=\"10%\" border=\"1\" valign=\"top\"><font size=5>".$achap['babNumber']."</font></td>
                    </tr>
                    <tr>
						<td width=\"10%\" border=\"1\" valign=\"top\" align=right>Intro</td>
						<td width=\"40%\" border=\"1\" valign=\"top\"><span class=\"englishHadith_old\">".$echap['intro']."</span></font></td>

						<td width=\"40%\" border=\"1\" valign=\"top\" align=\"right\"><div class=\"achap\">".$achap['intro']."</div></td>
						<td width=\"10%\" border=\"1\" valign=\"top\">Intro</td>
                    </tr>";
	return $rowsHTML;

}

function displayHadithPairAdmin($lang, $eng_hadith, $arb_hadith, $idx, $url, $collection, $tag_e, $tag_a) {

	$aligndirn = "left";
	if (strcmp($lang, "urdu") == 0) $aligndirn = "right";

    if ($idx > 0) $idxm1 = $idx - 1;
    else $idxm1 = 0;
    $idxp1 = $idx + 1;

    if (is_null($tag_e)) { $underlineTag_e = ""; $underlineCloseTag_e = ""; $tagTableText_e = "";}
    else { $underlineTag_e = ""; $underlineCloseTag_e = "*"; $tagTableText_e = "Tag";}

    if (is_null($tag_a)) { $underlineTag_a = ""; $underlineCloseTag_a = ""; $tagTableText_a = "";}
    else { $underlineTag_a = ""; $underlineCloseTag_a = "*"; $tagTableText_a = "Tag";}

	if ($arb_hadith == NULL) $babText = "<font size=\"5\">&nbsp;</font>";
	else $babText = "(".round($arb_hadith['babNumber']-0.5, 0).") <font size=\"5\">".$arb_hadith['babName']."</font>";

	if ($eng_hadith == NULL) $chapterText = "&nbsp;";
	else $chapterText = "(".$eng_hadith['babNumber'].") ".$eng_hadith['babName'];

	if ($arb_hadith == NULL) $arabicBookText = "UNMATCHED<font size=\"5\">&nbsp;</font>";
	else $arabicBookText = "(".$arb_hadith['bookNumber'].") <font size=\"5\">".$arb_hadith['bookName']."</font>";
	
	if ($eng_hadith != NULL) $englishBookText = $eng_hadith['bookName']." (".$eng_hadith['bookNumber'].")";
	else $englishBookText = "UNMATCHED&nbsp; ";

	if (isset($eng_hadith['annotations'])) $ehadithText = $eng_hadith['hadithText']."<br><br>".$eng_hadith['annotations'];
	else $ehadithText = $eng_hadith['hadithText'];
	if (!empty($eng_hadith['comments'])) $ehadithText = $eng_hadith['hadithText']."<p>Comments: ".$eng_hadith['comments'];
	else $ehadithText = $eng_hadith['hadithText'];
	if (!empty($eng_hadith['hadithSanad'])) $ehadithText = $eng_hadith['hadithSanad'].$eng_hadith['hadithText'];
	
	if (isset($arb_hadith['annotations'])) $ahadithText = $arb_hadith['hadithText']."<br><br>".$arb_hadith['annotations'];
	else $ahadithText = $arb_hadith['hadithText'];

	$changeOptionsTextEnglish = "<b>".$underlineTag_e.$eng_hadith[$lang.'URN'].$underlineCloseTag_e."</b> <font size=2> (<a href=\"".$url."&emoveup=".$idx."&continue=true#".$idxm1."\">Move up</a> <a href=\"".$url."&emovedown=".$idx."&continue=true#".$idxp1."\">| Move down</a>";
    if ($eng_hadith[$lang.'URN'] == 0) $changeOptionsTextEnglish = $changeOptionsTextEnglish." | <a href=\"javascript:void(0)\" onclick=\"addPopup('".$lang."', ".$arb_hadith['arabicURN'].")\">Add Text</a>)</font>";//$changeOptionsTextEnglish = $changeOptionsTextEnglish." | <font color=\"gray\">Modify</font> | <font color=\"gray\">Split</font> | <font color=\"gray\">Merge</font> | <font color=\"gray\">Tag</font>)</font>";
	else $changeOptionsTextEnglish = $changeOptionsTextEnglish." | <a href=\"modifyEnglishHadith.php?coll=".$collection."&lang=$lang&ebooknum=".$eng_hadith['bookID']."&eurn=".$eng_hadith[$lang.'URN']."\">Modify</a> | <a href=\"splitEnglishHadith.php?coll=".$collection."&lang=$lang&ebooknum=".$eng_hadith['bookID']."&eurn=".$eng_hadith[$lang.'URN']."\">Split</a> | <a href=\"javascript:void(0)\" onclick=\"mergePopup('".$lang."&pagelang=".$lang."', ".$eng_hadith[$lang.'URN'].")\">Merge</a> | <a href=\"javascript:void(0)\" onclick=\"tagPopup('".$lang."', ".$eng_hadith[$lang.'URN'].")\">Tag</a>)</font>";

	$changeOptionsTextArabic = "<font size=2>(<a href=\"".$url."&amoveup=".$idx."&continue=true#".$idxm1."\">Move up</a> | <a href=\"".$url."&amovedown=".$idx."&continue=true#".$idxp1."\">Move down</a>";
    if ($arb_hadith['arabicURN'] == 0) $changeOptionsTextArabic = $changeOptionsTextArabic." | <font color=\"gray\">Modify</font> | <font color=\"gray\">Split</font> | <font color=\"gray\">Tag</font>)</font> ";
	else $changeOptionsTextArabic = $changeOptionsTextArabic." | <a href=\"modifyArabicHadith.php?coll=".$collection."&ebooknum=".$eng_hadith['bookID']."&aurn=".$arb_hadith['arabicURN']."\">Modify</a> | <a href=\"splitArabicHadith.php?coll=".$collection."&ebooknum=".$eng_hadith['bookID']."&pagelang=$lang&aurn=".$arb_hadith['arabicURN']."\">Split</a> | <a href=\"javascript:void(0)\" onclick=\"mergePopup('arabic&pagelang=$lang', ".$arb_hadith['arabicURN'].")\">Merge</a> | <a href=\"javascript:void(0)\" onclick=\"tagPopup('arabic', ".$arb_hadith['arabicURN'].")\">Tag</a>)</font> ";

	if (strcmp($lang, "english")) $changeOptionsTextArabic = "";
	$changeOptionsTextArabic = $changeOptionsTextArabic."<b>".$underlineTag_a.$arb_hadith['arabicURN'].$underlineCloseTag_a."</b>";

	$number = $arb_hadith['hadithNumber'];
	if (isset($arb_hadith['fabNumber'])) $number = "(MFAB) ".$arb_hadith['fabNumber'];

	$rowsHTML =  "
                    <tr>
						<td width=\"10%\" border=\"1\" valign=\"top\" align=right><a name=\"".$idx."\">Eng. URN</a></td>
						<td width=\"40%\" border=\"1\" valign=\"top\">".$changeOptionsTextEnglish."</td>
						<td width=\"40%\" border=\"1\" valign=\"top\" align=\"right\">".$changeOptionsTextArabic."</td>
						<td width=\"10%\" border=\"1\" valign=\"top\"><a>Arb. URN</a</a></td>
                    </tr>
                    <tr>
						<td width=\"10%\" border=\"1\" valign=\"top\" align=right>Volume</td>
						<td width=\"40%\" border=\"1\" valign=\"top\">".$eng_hadith['volumeNumber']."&nbsp;</td>
						<td width=\"40%\" border=\"1\" valign=\"top\" align=\"right\">&nbsp;".$arb_hadith['volumeNumber']."</td>
						<td width=\"10%\" border=\"1\" valign=\"top\">Volume</td>
                    </tr>
                    <tr>
						<td width=\"10%\" border=\"1\" valign=\"top\" align=right>Book</td>
						<td width=\"40%\" border=\"1\" valign=\"top\">".$englishBookText."</td>
						<td width=\"40%\" border=\"1\" valign=\"top\" align=\"right\">".$arabicBookText."</td>
						<td width=\"10%\" border=\"1\" valign=\"top\">Book</td>
                    </tr>
                    <tr>
						<td width=\"10%\" border=\"1\" valign=\"top\" align=right>Number</td>
						<td width=\"40%\" border=\"1\" valign=\"top\">".$eng_hadith['hadithNumber']."&nbsp;</td>
						<td width=\"40%\" border=\"1\" valign=\"top\" align=\"right\">".$number."&nbsp;</td>
						<td width=\"10%\" border=\"1\" valign=\"top\">Number</td>
                    </tr>
                    <tr>
						<td width=\"10%\" border=\"1\" valign=\"top\" align=right>Chapter</td>
						<td width=\"40%\" border=\"1\" valign=\"top\">".$chapterText."</td>
						<td width=\"40%\" border=\"1\" valign=\"bottom\" align=\"right\">".$babText."</td>
						<td width=\"10%\" border=\"1\" valign=\"top\">Bab</td>
                    </tr>
                    <tr>
						<td width=\"10%\" border=\"1\" valign=\"top\" align=right>Text</td>
						<td width=\"40%\" border=\"1\" valign=\"top\" align=$aligndirn><span class=\"".$lang."Hadith_old\">".$ehadithText."</span></font></td>
						<td width=\"40%\" border=\"1\" valign=\"top\" align=\"right\"><span class=\"arabicHadith_old\">".$ahadithText."</span></td>
						<td width=\"10%\" border=\"1\" valign=\"top\">Text</td>
                    </tr>";
    if (!(is_null($tag_e)) or !(is_null($tag_a))) {
      $rowsHTML = $rowsHTML."
                    <tr>
                        <td width=\"10%\" border=\"1\" valign=\"top\" align=right>".$tagTableText_e."</td>
                        <td width=\"40%\" border=\"1\" valign=\"top\"><p>".$tag_e."</p></td>
                        <td width=\"40%\" border=\"1\" valign=\"top\" align=\"right\"><p>".$tag_a."</p></td>
                        <td width=\"10%\" border=\"1\" valign=\"top\">".$tagTableText_a."</td>
                    </tr>";
    }
    if ((isset($eng_hadith['grade']) && !(empty($eng_hadith['grade']))) or (isset($arb_hadith['grade']) && !(empty($arb_hadith['grade'])))) {
      $rowsHTML = $rowsHTML."
                    <tr>
                        <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Grade</td>
                        <td width=\"40%\" border=\"1\" valign=\"top\"><p>".$eng_hadith['grade']."</p></td>
                        <td width=\"40%\" border=\"1\" valign=\"top\" align=\"right\"><p>".$arb_hadith['grade']."</p></td>
                        <td width=\"10%\" border=\"1\" valign=\"top\">Grade</td>
                    </tr>";
    }
    if ((isset($eng_hadith['albanigrade']) && !(empty($eng_hadith['albanigrade']))) or (isset($arb_hadith['albanigrade']) && !(empty($arb_hadith['albanigrade'])))) {
      $rowsHTML = $rowsHTML."
                    <tr>
                        <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Grade (Albani)</td>
                        <td width=\"40%\" border=\"1\" valign=\"top\"><font size=4>".$eng_hadith['albanigrade']."</font></td>
                        <td width=\"40%\" border=\"1\" valign=\"top\" align=\"right\"><font size=6>".$arb_hadith['albanigrade']."</font></td>
                        <td width=\"10%\" border=\"1\" valign=\"top\">Grade (Albani)</td>
                    </tr>";
    }
	return $rowsHTML;
}

function displayHadithPair_nodiv($eng_hadith, $arb_hadith, $idx) {

	if ($arb_hadith == NULL) $babText = "<font size=\"5\">&nbsp;</font>";
	else $babText = "(".$arb_hadith['babNumber'].") <font size=\"5\">".$arb_hadith['babName']."</font>";

	if ($eng_hadith == NULL or $eng_hadith['babNumber'] == NULL) $chapterText = "&nbsp;";
	else $chapterText = "(".$eng_hadith['babNumber'].") ".$eng_hadith['babName'];

	if ($arb_hadith == NULL) $arabicBookText = "<font size=\"5\">&nbsp;</font>";
	else $arabicBookText = "(".$arb_hadith['bookNumber'].") <font size=\"5\">".$arb_hadith['bookName']."</font>";
	
	if ($eng_hadith != NULL) $englishBookText = $eng_hadith['bookName']." (".$eng_hadith['bookNumber'].")";
	else $englishBookText = "&nbsp; ";

	$rowsHTML =  "
                    <tr>
						<td width=\"10%\" border=\"1\" valign=\"top\" align=right>Volume</td>
						<td width=\"40%\" border=\"1\" valign=\"top\">".$eng_hadith['volumeNumber']."&nbsp;</td>
						<td width=\"40%\" border=\"1\" valign=\"top\" align=\"right\">&nbsp;".$arb_hadith['volumeNumber']."</td>
						<td width=\"10%\" border=\"1\" valign=\"top\">Volume</td>
                    </tr>
                    <tr>
						<td width=\"10%\" border=\"1\" valign=\"top\" align=right>Book</td>
						<td width=\"40%\" border=\"1\" valign=\"top\">".$englishBookText."</td>
						<td width=\"40%\" border=\"1\" valign=\"top\" align=\"right\">".$arabicBookText."</td>
						<td width=\"10%\" border=\"1\" valign=\"top\">Book</td>
                    </tr>
                    <tr>
						<td width=\"10%\" border=\"1\" valign=\"top\" align=right>Number</td>
						<td width=\"40%\" border=\"1\" valign=\"top\">".$eng_hadith['hadithNumber']."&nbsp;</td>
						<td width=\"40%\" border=\"1\" valign=\"top\" align=\"right\">&nbsp;".$arb_hadith['hadithNumber']."</td>
						<td width=\"10%\" border=\"1\" valign=\"top\">Number</td>
                    </tr>
                    <tr>
						<td width=\"10%\" border=\"1\" valign=\"top\" align=right>Chapter</td>
						<td width=\"40%\" border=\"1\" valign=\"top\">".$chapterText."</td>
						<td width=\"40%\" border=\"1\" valign=\"bottom\" align=\"right\">".$babText."</td>
						<td width=\"10%\" border=\"1\" valign=\"top\">Bab</td>
                    </tr>
                    <tr>
						<td width=\"10%\" border=\"1\" valign=\"top\" align=right>Text</td>
						<td width=\"40%\" border=\"1\" valign=\"top\"><span class=\"".$lang."Hadith_old\">".$eng_hadith['hadithText']."</span></font></td>

						<td width=\"40%\" border=\"1\" valign=\"top\" align=\"right\"><span class=\"arabicHadith_old\">".$arb_hadith['hadithText']."</span></td>
						<td width=\"10%\" border=\"1\" valign=\"top\">Text</td>
                    </tr>";
	return $rowsHTML;
}

function displayHadithPair_div($eng_hadith, $arb_hadith, $idx) {

    if ($eng_hadith['volumeNumber'] != "") $metadata_english = "Volume ".$eng_hadith['volumeNumber']." | ";
    $metadata_english = $metadata_english.$eng_hadith['bookName']." (".$eng_hadith['bookNumber'].") | ";
    $metadata_english = $metadata_english."Hadith #".$eng_hadith['hadithNumber'];
    if ($eng_hadith['babName'] != "") 
      $metadata_english = $metadata_english."<br>Chapter ".$eng_hadith['babNumber']." <span class=\"Chapter\">(".$eng_hadith['babName'].") </span>";

    /* Get rid of links in chapter names */
    $arb_hadith['babName'] = preg_replace('/\<.*?\>/', '', $arb_hadith['babName']);
    $arb_hadith['babName'] = preg_replace('/\<A.*$/', '', $arb_hadith['babName']);

    $metadata_arabic = "<span class=\"Book\">".$arb_hadith['bookName']."</span> (".$arb_hadith['bookNumber'].") | ";
    $metadata_arabic = $metadata_arabic."Hadith #".$arb_hadith['hadithNumber'];
    if ($arb_hadith['babName'] != "") 
      $metadata_arabic = $metadata_arabic."<br> <span class=\"Chapter\">".$arb_hadith['babName']."</a></span> (".$arb_hadith['babNumber'].")";


    if ($eng_hadith != NULL) {
	  $rowsHTML =  "
                    <div class=\"HadithPair\">
                      <div class=\"EnglishHadith\">
						<a name=\"".$eng_hadith['englishURN']."\"></a>
                        <div class=\"metadata\">".$metadata_english."</div><br>
			  		    <span class=\"HadithOptions\"><a href=\"#".$eng_hadith['englishURN']."\">Permalink</a> | Report Error</span>
                        <div class=\"text\">".$eng_hadith['hadithText']."</div>
                      </div>";
      }
      else $rowsHTML = "
                    <div class=\"HadithPair\">
                      <div class=\"EnglishHadith\">
                        <div class=\"metadata\">&nbsp;</div><br>
                        <span class=\"HadithOptions\">&nbsp;</span>
                        <div class=\"text\">&nbsp;</div>
                      </div>";


    if ($arb_hadith != NULL) {
      $rowsHTML =  $rowsHTML."
					  <div class=\"ArabicHadith\">
						<a name=\"".$arb_hadith['arabicURN']."\"></a>
                        <div class=\"metadata\">".$metadata_arabic."</div><br>
					    <span class=\"HadithOptions\"><a href=\"#".$arb_hadith['arabicURN']."\">Permalink</a> | Report Error</span>
                        <p><div class=\"text\">".$arb_hadith['hadithText']."&nbsp;</div></p>
                      </div>
					";
      }
      else $rowsHTML = $rowsHTML."
                      <div class=\"ArabicHadith\">
                        <div class=\"metadata\">&nbsp;</div><br>
                        <span class=\"HadithOptions\">&nbsp;</span>
                        <div class=\"text\">&nbsp;</div>
                      </div>
                    ";
  
    $rowsHTML = $rowsHTML."
                    <div class=\"bottomOptions\">
                      <div class=\"leftOptions\"><a href=\"#top\">Top of Page</a></div>
                      <div class=\"rightOptions\"><a href=\"/".$eng_hadith['collection'].".php\">Back to Collection Home</a></div>
                    </div>
                  </div>
    ";  


	return $rowsHTML;
}

function displayHadithPair_div2($eng_hadith, $arb_hadith, $idx) {

    if ($eng_hadith['volumeNumber'] != "") $metadata_english = "Volume ".$eng_hadith['volumeNumber']." | ";
    $metadata_english = $metadata_english.$eng_hadith['bookName']." (".$eng_hadith['bookNumber'].") | ";
    $metadata_english = $metadata_english."Hadith #".$eng_hadith['hadithNumber'];
    if ($eng_hadith['babName'] != "") 
      $metadata_english = $metadata_english."<br>Chapter ".$eng_hadith['babNumber']." <span class=\"Chapter\">(".$eng_hadith['babName'].") </span>";

    /* Get rid of links in chapter names */
    $arb_hadith['babName'] = preg_replace('/\<.*?\>/', '', $arb_hadith['babName']);
    $arb_hadith['babName'] = preg_replace('/\<A.*$/', '', $arb_hadith['babName']);

    $metadata_arabic = "<span class=\"Book\">".$arb_hadith['bookName']."</span> (".$arb_hadith['bookNumber'].") | ";
    $metadata_arabic = $metadata_arabic."Hadith #".$arb_hadith['hadithNumber'];
    if ($arb_hadith['babName'] != "") 
      $metadata_arabic = $metadata_arabic."<br> <span class=\"Chapter\">".$arb_hadith['babName']."</a></span> (".$arb_hadith['babNumber'].")";


    if ($eng_hadith != NULL) {
	  $rowsHTML =  "
                    <div class=\"HadithPair\">
                      <div class=\"EnglishHadith\">
						<a name=\"".$eng_hadith['englishURN']."\"></a>
                        <div class=\"metadata\">".$metadata_english."</div><br>
			  		    <span class=\"HadithOptions\"><a href=\"#".$eng_hadith['englishURN']."\">Permalink</a> | Report Error</span>
                        <div class=\"text\">".$eng_hadith['hadithText']."</div>
                      </div>";
      }
      else $rowsHTML = "
                    <div class=\"HadithPair\">
                      <div class=\"EnglishHadith\">
                        <div class=\"metadata\">&nbsp;</div><br>
                        <span class=\"HadithOptions\">&nbsp;</span>
                        <div class=\"text\">&nbsp;</div>
                      </div>";


    if ($arb_hadith != NULL) {
      $rowsHTML =  $rowsHTML."
					  <div class=\"ArabicHadith\">
						<a name=\"".$arb_hadith['arabicURN']."\"></a>
                        <div class=\"metadata\">".$metadata_arabic."</div><br>
					    <span class=\"HadithOptions\"><a href=\"#".$arb_hadith['arabicURN']."\">Permalink</a> | Report Error</span>
                        <p><div class=\"text\">".$arb_hadith['hadithText']."&nbsp;</div></p>
                      </div>
					";
      }
      else $rowsHTML = $rowsHTML."
                      <div class=\"ArabicHadith\">
                        <div class=\"metadata\">&nbsp;</div><br>
                        <span class=\"HadithOptions\">&nbsp;</span>
                        <div class=\"text\">&nbsp;</div>
                      </div>
                    ";
  
    $rowsHTML = $rowsHTML."
                    <div class=\"bottomOptions\">
                      <div class=\"leftOptions\"><a href=\"#top\">Top of Page</a></div>
                      <div class=\"rightOptions\"><a href=\"/".$eng_hadith['collection'].".php\">Back to Collection Home</a></div>
                    </div>
                  </div>
    ";  


	return $rowsHTML;
}

function getNextURN($urn, $collection, $lang) {
	$db_name = $collection."_".$lang;
	$k = 1;
	$row = -1;
	while ($row != NULL) {
		$newurn = $urn + $k;
		$query = "select ".$lang."URN from ".$db_name." where ".$lang."URN = ".$newurn;
		$mysqlq = mysql_query($query) or die(mysql_error().": ".$query);
		$row = mysql_fetch_array($mysqlq);
		$row = $row[$lang."URN"];
		$k = $k+1;
	}
	return $newurn;
}

function print_array($arr, $name) {
	$str = $name.": (";
	foreach ($arr as $val) $str = $str.$val.", ";
	$str = $str.")";
	return $str;
}

function find_closest_element($arr, $val) {
	$last = 0;
	for ($counter = 0; $counter < count($arr); $counter++) {
		$cand = $arr[$counter];
		if ($cand > 0 && $cand < $val) $last = $counter;
		elseif ($cand > $val) return $counter;
	}
	return $counter;
}


function checkBookOneAlignment($eURNs, $aURNs) {
	$eURNs_correct = array(10,20,30,0,40,50,60);
	$aURNs_correct = array(10,20,30,40,50,60,70);

	$ematch = FALSE;
	$amatch = FALSE;

	if (count($eURNs) == count($eURNs_correct) && array_diff_assoc($eURNs, $eURNs_correct) == NULL) $ematch = TRUE;
	if (count($aURNs) == count($aURNs_correct) && array_diff_assoc($aURNs, $aURNs_correct) == NULL) $amatch = TRUE;
	
	if ($ematch && $amatch) return 1;
	else return 0;
}

function getStatusCounts($collection, $lang) {

	$retval[1] = NULL; $retval[2] = NULL;
	$query = "select ".$lang."matchstatus, count(*) from ".$collection."bookmatch, ".$collection."_".$lang." where (".$collection."bookmatch.".$lang."BookID = ".$collection."_".$lang.".bookID) group by ".$lang."matchstatus";
	$mysqlq = mysql_query($query) or die(mysql_error());
    while ($row = mysql_fetch_array($mysqlq)) {
		if ($row[$lang.'matchstatus'] == 0 or $row[$lang.'matchstatus'] == NULL) $retval[0] = $row['count(*)'];
		else $retval[$row[$lang.'matchstatus']] = $row['count(*)'];
	}

	$query = "select count(*) from ".$collection."_".$lang." where bookID != 0";
	$mysqlq = mysql_query($query) or die(mysql_error());
	$result = mysql_fetch_array($mysqlq);
	$retval['total'] = $result['count(*)'];

	if ($retval[1] == NULL) $retval[1] = 0;
	if ($retval[2] == NULL) $retval[2] = 0;
	if ($retval[3] == NULL) $retval[3] = 0;
	if ($retval[4] == NULL) $retval[4] = 0;
	$retval[0] = $retval['total'] - $retval[1] - $retval[2] - $retval[3] - $retval[4];

  	return $retval;
}

function updateChapter($collection, $lang, $bookID, $babID, $babNumber, $babName, $intro, $live, $username) {
	if (!get_magic_quotes_gpc()) {
		$intro_1 = addslashes($intro);
		$babName = addslashes($babName);
	}
	else {
		$intro_1 = $comments;
	}

	if (strlen($babName) < 1) $babName = "NULL";
	else $babName = "'".$babName."'";
	if (is_null($intro_1) || strlen($intro_1) < 1) $intro_s = "NULL";
	else $intro_s = "'".$intro_1."'";
	if (strlen($babNumber) < 1) return NULL;

	$db_name = $lang."Chapters";
	$query = "insert into $db_name (collection, bookID, babID, babNumber, babName, intro) values ('$collection', $bookID, $babID, '$babNumber', $babName, $intro_s) on duplicate key update babName = $babName, intro = $intro_s";
	return modifyDB($query, $live, $username);
}

function updateHadithText($urn, $hadithNumber, $text, $babName, $babNumber, $collection, $lang, $live, $username, $comments = NULL, $grade = NULL, $annotations = NULL) {
	if (!get_magic_quotes_gpc()) {
		$comments_1 = addslashes($comments);
		$grade_1 = addslashes($grade);
		$babName = addslashes($babName);
		$annotations_1 = addslashes($annotations);
	}
	else {
		$comments_1 = $comments;
		$grade_1 = $grade;
		$annotations_1 = $annotations;
	}

	if (strlen($babName) < 1) $babName = "NULL";
	else $babName = "'".$babName."'";
	if (is_null($comments_1) || strlen($comments_1) < 1) $comments_s = "NULL";
	else $comments_s = "'".$comments_1."'";
	if (is_null($grade_1) || strlen($grade_1) < 1) $grade_s = "NULL";
	else $grade_s = "'".$grade_1."'";
	if (strlen($babNumber) < 1) $babNumber = "NULL";

	$annotation_condition = "";
	if (!is_null($annotations_1) && strlen($annotations_1) > 0)
		$annotation_condition = ", annotations = '".$annotations_1."'";

	$db_name = $collection."_".$lang;
	if (!get_magic_quotes_gpc()) $hadithText = addslashes($text);
    else $hadithText = $text;
    $hadithText = str_replace("\r", "", $hadithText);
	$query = "update ".$db_name." set hadithText = '".$hadithText."', hadithNumber = ".$hadithNumber.", babName = ".$babName.", comments = ".$comments_s.", grade = ".$grade_s.", babNumber = ".$babNumber.$annotation_condition." where ".$lang."URN = ".$urn;
	return modifyDB($query, $live, $username);
}

function getTagStatus($urns) {
  $urns_string = "(";
  foreach ($urns as $urn) {
    if (!is_null($urn) && is_numeric($urn) && $urn > 0) $urns_string = $urns_string.$urn.",";
  }
  $urns_string = substr($urns_string, 0, -1).")";
  if (count($urns) > 0) {
    $query = "SELECT * FROM tagTable WHERE URN in ".$urns_string;
    $tags_q = mysql_query($query)
      or die(mysql_error().$query);
    while ($tag = mysql_fetch_array($tags_q)) $tags[$tag['URN']] = $tag['tagText'];
  	if (isset($tags)) return $tags;
  }
  return NULL;
}

function getTag($urn){
	if (is_numeric($urn) and ($urn > 0)) {
		$query = "select tagText from tagTable where URN = ".$urn;
		$mysqlq = mysql_query($query) or die(mysql_error());
	    $result = mysql_fetch_array($mysqlq);
    	$tag = $result['tagText'];
		return $tag;
	}
	else return NULL;
}

function updateTagText($urn, $tag, $live, $username) {
	if (!get_magic_quotes_gpc()) $tagText = addslashes($tag);
	else $tagText = $tag;
	if (is_numeric($urn) and ($urn > 0)) {
		$query = "insert into tagTable(URN, tagText) values (".$urn.",'".$tagText."')";
		$query = $query." on duplicate key update tagText = '".$tagText."'";
		return modifyDB($query, $live, $username);
	}
}

function deleteTag($urn, $live, $username) {
	if (is_numeric($urn) and ($urn > 0)) {
		$query = "delete from tagTable where URN = ".$urn;
		return modifyDB($query, $live, $username);
	}
}

function deleteReferencesToHadith($urn, $collection, $lang, $live, $username, $matchlang="") {
	$db_name = $collection."_".$matchlang;
	// Delete mentions of this URN from matchtable
	$deleteQuery = "DELETE FROM ".$matchlang."matchtable WHERE ".$lang."URN = ".$urn;
	modifyDB($deleteQuery, $live, $username);

	$db_name = $collection."_".$lang;
	// Set the book number of this hadith to 0 so that it's not retrieved anymore
	$updateQuery = "UPDATE ".$db_name." set bookID = 0 where ".$lang."URN = ".$urn;
	modifyDB($updateQuery, $live, $username);
}

function manualMatch($eurn, $aurn, $live, $username) {
	if ($eurn > 0 and $aurn > 0) {
		$deleteQuery = "delete from matchtable where (englishURN = ".$eurn." or arabicURN = ".$aurn.")";
		$insertQuery = "insert into matchtable (englishURN, arabicURN) values (".$eurn.",".$aurn.")";
		modifyDB($deleteQuery, $live, $username);
		modifyDB($insertQuery, $live, $username);
	}
}

function addHadith($urn, $volumeNumber, $bookID, $bookNumber, $bookName, $babNumber, $babName, $hadithNumber, $text, $collection, $lang, $live, $username, $comments = NULL, $grade = NULL) {
	$db_name = $collection."_".$lang;
    $hadithText = $text;
	$hadithText = str_replace("\r", "", $hadithText);

	if (strcmp($collection, "nawawi40") == 0 or strcmp($collection, "qudsi40") == 0) {$bookID = "1"; $bookNumber = "1";}

	$bookNameText = $bookName;
	if (is_null($babNumber) || strlen($babNumber) < 1) $babNumber = "NULL";
	if (is_null($comments) || strlen($comments) < 1) $commentsSQL = "NULL";
	else $commentsSQL = "'".$comments."'";
	if (is_null($grade) || strlen($grade) < 1) $gradeSQL = "NULL";
	else $gradeSQL = "'".$grade."'";

	if ($lang == "english" || $lang == "arabic" || $lang == "indonesian") {
		$valuesString = "('".$collection."',".$urn.",".$volumeNumber.",".$bookID.",".$bookNumber.",'".$bookNameText."',".$babNumber.",'".$babName."',".$hadithNumber.",".$gradeSQL.",'".$hadithText."',".$commentsSQL.")";
		$insertQuery = "insert into ".$db_name." (collection, ".$lang."URN, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, grade, hadithText, comments) values ".$valuesString;
		$retval = modifyDB($insertQuery, $live, $username);
	}
	return $retval;
}

function sanitizeURNs($eurns, $aurns) {
    $eURNs = $eurns;
    $aURNs = $aurns;

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

    $retval['eURNs'] = $eURNs;
    $retval['aURNs'] = $aURNs;
    return $retval;
}

function URNinBook($urn, $booknum, $collection, $lang) {
	if (!($urn > 0)) return FALSE;
	$db_name = $collection."_".$lang;
	$query = "select bookNumber, bookID from ".$db_name." where ".$lang."URN = ".$urn;
    $mysqlq = mysql_query($query) or die(mysql_error());
    $result = mysql_fetch_array($mysqlq);
	//print "URNinBook output: result and ebooknum are ".$result['bookNumber']." and ".
	if ($result['bookID'] == $booknum) return TRUE;
	else return FALSE;
}

function mergeHadith($urn1, $urn2, $collection, $lang, $live, $username, $pagelang = "") {
	$db_name = $collection."_".$lang;
	$hadith1 = getHadith($collection, $lang, $urn1);
	$hadith2 = getHadith($collection, $lang, $urn2);

	if ($hadith1 == NULL or $hadith2 == NULL) return 1;

	$newurn = getNextURN($urn1, $collection, $lang);
	$newText = addslashes($hadith1['hadithText'].$hadith2['hadithText']);
	$newComments = "";
	if (strlen($hadith1['comments']) > 0) $newComments .= $hadith1['comments']."  ";
	if (strlen($hadith2['comments']) > 0) $newComments .= $hadith2['comments'];
	$newComments = addslashes($newComments);
	$volumeNumber = $hadith1['volumeNumber'];
	$bookID = $hadith1['bookID'];
	$bookNumber = $hadith1['bookNumber'];
	$bookName = addslashes($hadith1['bookName']);
	$babNumber = $hadith1['babNumber'];
	$babName = addslashes($hadith1['babName']);
	$hadithNumber = $hadith1['hadithNumber'];
	$grade = $hadith1['grade'];
	addHadith($newurn, $volumeNumber, $bookID, $bookNumber, $bookName, $babNumber, $babName, $hadithNumber, $newText, $collection, $lang, $live, $username, $newComments, $grade);

	deleteReferencesToHadith($urn1, $collection, $lang, $live, $username, $pagelang);	
	deleteReferencesToHadith($urn2, $collection, $lang, $live, $username, $pagelang);

    //echo "here";
	return 0;
}

?>
