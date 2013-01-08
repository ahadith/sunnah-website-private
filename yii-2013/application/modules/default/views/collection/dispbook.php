<?php 

function displayBab($chapter) {
	$arabicBabNumber = $chapter->arabicBabNumber;
	$arabicBabName = $chapter->arabicBabName;
	$englishBabNumber = $chapter->englishBabNumber;
	$englishBabName = $chapter->englishBabName;
	$englishIntro = preg_replace("/\n+/", "<br>\n", $chapter->englishIntro);
	$arabicIntro = preg_replace("/\n+/", "<br>\n", $chapter->arabicIntro);

	echo "<div style=\"height: 10px;\"></div>\n";
    echo "<div class=chapter>\n";
    echo "<div class=clear></div><div style=\"height: 5px;\"></div>\n";
	if (!is_null($englishBabName)) {
		if (strcmp(substr($englishBabName, 0, 7), "chapter") != 0) $eprefix = "Chapter: ";
		else $eprefix = "";
		if (strlen($englishBabNumber) > 0 && intval($englishBabNumber) != 0) $babNum = $englishBabNumber;
		else $babNum = $arabicBabNumber;
		if (ctype_upper(substr(trim($englishBabName), 0, 2))) $englishBabName = ucwords(strtolower($englishBabName));
		echo "<div class=echapno>($babNum)</div>";
		echo "<div class=englishchapter>".$eprefix.$englishBabName."</div>\n";
	}
	echo "<div class=achapno>($arabicBabNumber)</div>\n";
	echo "<div class=\"arabicchapter arabic_basic\">$arabicBabName</div>";
	echo "<div class=clear></div><div style=\"height: 10px;\"></div><div class=clear></div>\n";
	echo "</div>\n";
	if (isset($englishIntro) && strlen($englishIntro) > 0) echo "<div class=\"echapintro text_details\" style=\"width: 75%;\">$englishIntro</div>\n";
	if (isset($arabicIntro) && strlen($arabicIntro) > 0) echo "<div class=\"arabic_basic achapintro\">$arabicIntro</div>\n";
	echo "<div class=clear></div>\n";
	echo "\n<div style=\"height: 20px;\"></div>\n";
}

if (isset($this->_errorMsg)) echo $this->_errorMsg;
else {
	$englishEntries = $this->_entries[0];
	$arabicEntries = $this->_entries[1];
	$pairs = $this->_entries[2];
	$totalCount = count($pairs);
	$ourBookID = $this->_ourBookID;
	$collection = $this->_collectionName;
	$collectionType = $this->_collection->type;
	$collectionHasBooks = $this->_collection->hasbooks;
	$collectionHasVolumes = $this->_collection->hasvolumes;
	$collectionHasChapters = $this->_collection->haschapters;
	$status = $this->_book->status;
	$chapters = $this->_chapters;
	if ($chapters) $babIDs = array_keys($chapters);
	if ($this->_ajaxCrawler and count($this->_otherlangs) > 0) {
		$haveotherlangs = true;
		$otherlangs = $this->_otherlangs;
	}
	
	if (strcmp($this->_pageType, "book") == 0) {
		echo "<div class=bookheading><div class=englishbookheading>".$this->_book->englishBookName."</div><div class=arabicbookheading>".$this->_book->arabicBookName."</div></div>";

		echo "<br><div class=breadcrumbs style=\"margin-left: 55px; margin-right: 23%; font-size: 14px; text-align: justify;\">";
		if (strcmp($collectionHasBooks, "yes") == 0) {
			echo "<p align=center><span style=\"font-size: 16px;\">This is ";
			if ($ourBookID > 0) echo "book $ourBookID ";
			else echo "the introduction ";
			echo "of ".$this->_collection->englishTitle.", containing <b>$totalCount</b> hadith.</span></p> ";
		}
		else echo "<p align=center><span style=\"font-size: 16px;\">This is ".$this->_collection->englishTitle.", containing <b>$totalCount</b> hadith.</span></p> ";



		// Blurb about references and verification
		if ($status == 4) {
			echo "<br>The Arabic text and reference numbering in this book has been checked to correspond with standard publications to the best of our ability. ";
			if (strlen($this->_collection->numberinginfodesc) > 0) {
				echo $this->_collection->numberinginfodesc;
				echo " <a style=\"color: #634614;\" href=\"/$collection/about#numbering\">Numbering scheme details</a>";
			}
		}
		echo "</div>\n\n";
		echo "<div class=\"hline\" style=\"width: 71%; margin-left: 6%; height: 4px;\"></div>";
	}

    echo "<a name=\"0\"></a>";
	echo "<div class=AllHadith>\n";
					$oldChapNo = 0;
					for ($i = 0; $i < $totalCount; $i++) {
						$englishEntry = $englishEntries[$pairs[$i][0]];
						$arabicEntry = $arabicEntries[$pairs[$i][1]];

						$englishExists = true;
						$arabicExists = true;

						if ($englishEntry == NULL) {
							$englishEntry = new EnglishHadith;
							$urn = $arabicEntry->arabicURN;
							$englishExists = false;
							$ourHadithNumber = $arabicEntry->ourHadithNumber;
						}
						else {
							$urn = $englishEntry->englishURN;
							$ourHadithNumber = $englishEntry->ourHadithNumber;
						}

						if ($arabicEntry == NULL) {
							$arabicEntry = new ArabicHadith;
							$arabicExists = false;
						}
						else {
							/* Arabic entry is not NULL, so we check for status == 4 and get chapter info */
							if ($status == 4 and strcmp($collectionHasChapters, "yes") == 0) {
								$babID = $arabicEntry->babNumber;
								//$arabicBabNumber = $chapters[$babID]->arabicBabNumber;
								//$arabicBabName = $chapters[$babID]->arabicBabName;
								//$englishBabNumber = $chapters[$babID]->englishBabNumber;
								//$englishBabName = $chapters[$babID]->englishBabName;
								//$englishIntro = $chapters[$babID]->englishIntro;
								//$arabicIntro = $chapters[$babID]->arabicIntro;
								if ($i > 0) $oldebooknum = $ebooknum;
								$ebooknum = $englishEntry->bookNumber;
							}
						}

						if (isset($ebooknum) and $i > 0 and $ebooknum == $oldebooknum+1) {
							echo "</div><div class=bookheading><div class=englishbookheading>".$englishEntry->bookName."</div><div class=arabicbookheading>".$arabicEntry->bookName."</div></div>";
							echo "<div class=\"hline\" style=\"width: 71%; margin-left: 6%; height: 4px;\"></div><div class=AllHadith>";
						}

						if (isset($babID) and $babID != $oldChapNo) {
							if (strcmp($this->_pageType, "book") == 0) {
								// Check if there are any zero-hadith chapters between this one and the previous one
								if ($oldChapNo != 0) $oldChapIdx = array_search($oldChapNo, $babIDs);
								else $oldChapIdx = -1;
								$newChapIdx = array_search($babID, $babIDs);
								for ($j = 0; $j < $newChapIdx - $oldChapIdx - 1; $j++)
									displayBab($chapters[$babIDs[$oldChapIdx+$j+1]]);
							}

							// Now display the current chapter
							displayBab($chapters[$babID]);
							$oldChapNo = $babID;
						}

						if (isset($haveotherlangs) and $arabicExists) {
							$arabicURN = $arabicEntry->arabicURN;
							$otherlangshadith = array();
							foreach ($otherlangs as $langname => $ahadith) {
								foreach ($ahadith as $hadith) 
									if ($hadith->matchingArabicURN == $arabicURN) {
										$otherlangshadith[$langname] = $hadith->hadithText;
										break;
									}
							}
						}
						else $otherlangshadith = NULL;

						echo $this->renderPartial('/collection/disphadith', array(
							'arabicEntry' => $arabicEntry,
							'englishText' => $englishEntry->hadithText,
							'arabicText' => $arabicEntry->hadithText,
							'ourHadithNumber' => $ourHadithNumber, 'counter' => $i+1, 'otherlangs' => $otherlangshadith));

						echo $this->renderPartial('/collection/hadith_reference', array(
							'englishEntry' => $englishExists,
							'arabicEntry' => $arabicExists,
							'values' => array($urn, 
											$englishEntry->volumeNumber, 
											$englishEntry->bookNumber,
											$englishEntry->hadithNumber,
											$arabicEntry->bookNumber,
											$arabicEntry->hadithNumber,
											$ourHadithNumber, $collection, $ourBookID, $collectionHasBooks, $collectionHasVolumes, $status, $this->_collection->englishTitle, $englishEntry->grade1, $arabicEntry->grade1)
                            ));	

						/* Check if the chapter ends here  */
						if ($i+1 < $totalCount) {
	                        $englishEntry = $englishEntries[$pairs[$i+1][0]];
    	                    $arabicEntry = $arabicEntries[$pairs[$i+1][1]];

	                        $englishExists = true;
    	                    $arabicExists = true;

	                        if ($englishEntry == NULL) $englishExists = false;
        	                if ($arabicEntry == NULL) $arabicExists = false;
                        	elseif ($status == 4) $newBabID = $arabicEntry->babNumber;

						}
 
						if (isset($newBabID) and $newBabID != $oldChapNo) 
							echo "<div class=hline style=\"height: 4px;\"></div>";
						elseif (isset($newBabID) && $status == 4) {
							echo "<div class=hline style=\"height: 2px;\"></div>";
						}
						else echo "<div class=hline></div>";
					}
					// Below code for zero-hadith chapters at the end of the book
					if (isset($babID) and strcmp($this->_pageType, "book") == 0 and $oldChapNo != 0) {
						$oldChapIdx = array_search($oldChapNo, $babIDs);
						if ($oldChapIdx < count($babIDs)-1) {
							for ($j = 0; $j < count($babIDs)-$oldChapIdx-1; $j++) {
								displayBab($chapters[$babIDs[$oldChapIdx+$j+1]]);
								echo "<div class=hline style=\"height: 4px;\"></div>";
							}
						}
					}
	echo "</div>";

} // ending the no error if

?>


