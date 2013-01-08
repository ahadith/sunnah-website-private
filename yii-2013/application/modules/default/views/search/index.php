<?php 

if (isset($this->_viewVars->errorMsg)) echo $this->_viewVars->errorMsg;
else {

	$pageNumber = $this->_pageNumber;
	$resultsPerPage = $this->_resultsPerPage;

	echo $this->_message; 
	if (true) {

	$spellcheck = $this->_spellcheck;
	// "Did you mean" section
	if (!is_null($spellcheck)) {
		$suggestions = $spellcheck['suggestions'];
		//echo $suggestions;
		//print_r($suggestions);
		if (!empty($suggestions)) {
			$collation = $suggestions['collation'];
			$suggest_string = stripslashes(substr(strstr($collation, ":"), 1));
			$atag = "<a href=\"javascript:void(0);\" onclick=\"location.href='/search_redirect.php?query=".rawurlencode($suggest_string)."&didyoumean=true";
			$atag = $atag."&old=".rawurlencode($this->_searchQuery)."';\">";
			echo "<span class=breadcrumbs_search>Did you mean to search for ".$atag.$suggest_string."</a></span> ?
			<br><span class=breadcrumbs_search>We are still working on this feature. Please bear with us if the suggestion doesn't sound right.</span><br>";
		} 
	} 

	$english_hadith = $this->_english_hadith;
	$arabic_hadith = $this->_arabic_hadith;
	$eurns = $this->_eurns;
	$aurns = $this->_aurns;
	$highlighted = $this->_highlighted;
	$language = $this->_language;
	$prefix = strcmp($language, "english")==0 ? "" : "arabic";
	if ($this->_numFound == 0) {
		echo "<p align=center>Sorry, there were no results found.";
		$googlequery = "http://www.google.com/#q=".preg_replace("/ /", "+", $this->_searchQuery)."+site:sunnah.com";
		echo "<br><a href=\"".$googlequery."\">Click here</a> to use Google's site search feature for your query instead.<br><br></p>";
	}

	if ($this->_numFound > 0) {
		$beginResult = ($pageNumber-1)*$resultsPerPage+1;
		$endResult = min($pageNumber*$resultsPerPage, $this->_numFound);
		echo "<div class=\"AllHadith\">\n";
		echo "$beginResult-$endResult of ".$this->_numFound." results:<br><br>";
		//echo $this->paginationControl($this->paginator, 'Sliding', 'index/pagination.phtml');
		echo "<div align=center>";
		$this->widget('CLinkPager', array('pages' => $this->_pages));
		echo "</div><br>";

		if (strcmp($language, "english") == 0) {
			$util = new Util();
			foreach ($this->_pairs as $pair) {
				$eurn = $pair[0]; $aurn = $pair[1];
				$hadith = EnglishHadith::model()->find("englishURN = :eurn", array(':eurn' => $eurn));
				if ($hadith == NULL) continue;
				$book = Book::model()->find("englishBookID = :ebid AND collection = :collection", array(':ebid' => $hadith->bookID, ':collection' => $hadith->collection));
				$ourBookID = $book->ourBookID;

				$collection = $util->getCollection($hadith->collection);
				$hasbooks = $collection->hasbooks;

				echo "<div class=hadithEnv>\n";
				echo "<!-- URN $eurn -->";
				// Print the path of the hadith
				echo "<div class=\"breadcrumbs_search\">\n";
				$e_hadith = $english_hadith[array_search($eurn, $eurns)];
				echo "<a href=\"/".$e_hadith['collection']."\">".$this->_collections[$e_hadith['collection']]['englishTitle']."</a> &gt; ";
				echo "<a href=\"/".$e_hadith['collection']."/".$ourBookID."\">".$e_hadith['bookName']."</a> &gt; ";
				if ($e_hadith['ourHadithNumber'] > 0) {
					if (strcmp($hasbooks, "yes") == 0) $permalink = "/".$e_hadith['collection']."/".$ourBookID."#".$e_hadith['ourHadithNumber'];
					else $permalink = "/".$e_hadith['collection']."#".$e_hadith['ourHadithNumber'];
				}
				else $permalink = "/urn/$eurn";
				echo "<a href=\"$permalink\">Hadith permalink</a></div>";

				if (isset($highlighted[$eurn][$prefix.'hadithText'][0])) 
					$text = $highlighted[$eurn][$prefix.'hadithText'][0];
				else
					$text = "Preview not available. Please click on the link to view the hadith.";
				$text = preg_replace("/<em>/", "<b><i>", $text);
				$text = preg_replace("/<\/em>/", "</b></i>", $text);
				
				echo "<div class=\"search_english_text\">... ".$text." ...</div><br />";

				if ($aurn > 0) {
					$arabicText = $arabic_hadith[array_search($aurn, $aurns)]['hadithText'];
					if (strlen($arabicText) <= 2500) $arabicSnippet = $arabicText;
					else {
						$pos = strpos($arabicText, ' ', 2500);
						if ($pos === FALSE) $arabicSnippet = $arabicText;
						else $arabicSnippet = substr($arabicText, 0, $pos)." ...";
					}

					echo "<div class=\"search_arabic_text arabic_basic\">".$arabicSnippet."</a></div>";
				}
				echo "</div>";
				echo "<div class=clear></div>";
				echo "<div class=hline></div>";
			}
    	}
		elseif (strcmp($language, "arabic") == 0) {
			$util = new Util();
			foreach ($this->_pairs as $pair) {
				$eurn = $pair[0]; $aurn = $pair[1];
				$hadith = ArabicHadith::model()->find("arabicURN = :aurn", array(':aurn' => $aurn));
				$book = Book::model()->find("arabicBookID = :abid AND collection = :collection", array(':abid' => $hadith->bookID, ':collection' => $hadith->collection));
				$ourBookID = $book->ourBookID;
				$collection = $util->getCollection($hadith->collection);
				$hasbooks = $collection->hasbooks;

				echo "<div class=hadithEnv>\n";
				
				// Print the path of the hadith
				echo "<div class=\"breadcrumbs_search\">\n";
				$a_hadith = $arabic_hadith[array_search($aurn, $aurns)];
				$e_hadith = $english_hadith[array_search($aurn, $aurns)];
				echo "<a href=\"/".$a_hadith['collection']."\">".$this->_collections[$a_hadith['collection']]['englishTitle']."</a> &gt; ";
				echo "<a href=\"/".$a_hadith['collection']."/".$ourBookID."\">".$e_hadith['bookName']." - ".$a_hadith['bookName']."</a> &gt; ";
				if ($a_hadith['ourHadithNumber'] > 0) {
					if (strcmp($hasbooks, "yes") == 0) $permalink = "/".$a_hadith['collection']."/".$ourBookID."#".$a_hadith['ourHadithNumber'];
					else $permalink = "/".$a_hadith['collection']."#".$a_hadith['ourHadithNumber'];
				}
				else $permalink = "/urn/$aurn";
				echo "<a href=\"$permalink\">Hadith permalink</a></div>";
				
				if (isset($highlighted[$aurn][$prefix.'hadithText'])) {
					$text = $highlighted[$aurn][$prefix.'hadithText'][0];
					$text = preg_replace("/<em>/", "<b>", $text);
					$text = preg_replace("/<\/em>/", "</b>", $text);
				}
		
				echo "<div class=\"search_arabic_text arabic_basic\" dir=rtl>... ".$text." ...</a></div>";
				
				$englishSnippet = "";
				if (isset($english_hadith[array_search($eurn, $eurns)]['hadithText'])) {
					$englishText = $english_hadith[array_search($eurn, $eurns)]['hadithText'];
					if (strlen($englishText) <= 2500) $englishSnippet = $englishText;
					else {
						$pos = strpos($englishText, ' ', 2500);
						if ($pos === FALSE) $englishSnippet = $englishText;
						else $englishSnippet = substr($englishText, 0, $pos)." ...";
					}
				}
				echo "<div class=\"search_english_text\" >".$englishSnippet."</div>";
				echo "</div>";
				echo "<div class=clear></div>";
				echo "<div class=hline></div>";
			}
    	}

		//echo $this->paginationControl($this->paginator, 'Sliding', 'index/pagination.phtml');
		echo "<div align=center>";
		$this->widget('CLinkPager', array('pages' => $this->_pages));
		echo "</div>";
		echo "</div>";

	}
	
}


} // ending no error if
?>


