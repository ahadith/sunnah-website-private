<?php 
if (isset($this->_errorMsg)) echo $this->_errorMsg;
else {
    $entries = $this->_entries;
	$entries_keys = array_keys($entries);
    $collectionName = $this->_collectionName;
	$totalCount=count($entries);
    $splitSize=round($totalCount/2, 0, PHP_ROUND_HALF_UP);
?>

	<div style="padding:0; margin:0" align=center>

	<div class="content collection_intro_short">
		<?php 
			if (strlen($this->_collection->shortintro) > 0) {
				echo $this->_collection->shortintro; 
				echo " <a href=\"/$collectionName/about\">More information</a>\n\n";
			}
		?>
		<br><br>
		<a href="/<?php echo $collectionName; ?>/index">Click here for collection index</a>
	</div>


		<div class="float left_content" align=left>
			<dl>
				<?php
					for ($i = 0; $i < $splitSize; $i++) {
						$entry = $entries[$entries_keys[$i]];
                        echo "<div class=book_title>\n";
						if ($i % 2 == 0) $dd_class = "list_first";
						else $dd_class = "list_second";
						if ($entry->ourBookID == -1) echo "<a href=\"".$entry->collection."/introduction\">\n";
						elseif ($entry->ourBookID == -35 and strcmp($collectionName, "nasai") == 0) echo "<a href=\"".$entry->collection."/35b\">\n";
						else echo "<a href=\"".$entry->collection."/".$entry->ourBookID."\">\n";
    					echo "<dd class=".$dd_class.">\n";
						echo "<div class=english_book_name>";
						if ($entry->ourBookID == -1) echo "&nbsp;&nbsp;&nbsp&nbsp;";
						elseif ($entry->ourBookID == -35 and strcmp($collectionName, "nasai") == 0) echo "35b. ";
						else echo $entry->ourBookID.". ";
						echo $entry->englishBookName."</div>";
						echo "&nbsp;";
						echo "<div class=\"arabic_book_name arabic_basic\">".$entry->arabicBookName."</div> &nbsp;";
						echo '<div style="clear:both"></div>';
						if ($i % 2 == 0) echo "<div class=list_first_bg>&nbsp;</div>";
						echo "</dd></a>\n\t\t\t\t";
                        echo "</div>";
						echo '<div style="clear:both"></div>';
    				}
				?>
			</dl>
		</div>
		<div class="right_content" align=left>
			<dl>
				<?php
					for ($i = $splitSize; $i < $totalCount; $i++) {
						$entry = $entries[$entries_keys[$i]];
                        echo "<div class=book_title>\n";
						if (($i - $splitSize) % 2 == 0) $dd_class = "list_first";
						else $dd_class = "list_second";
						if ($entry->ourBookID == -1) echo "<a href=\"".$entry->collection."/introduction\">\n";
						elseif ($entry->ourBookID == -35 and strcmp($collectionName, "nasai") == 0) echo "<a href=\"".$entry->collection."/35b\">\n";
						else echo "<a href=\"".$entry->collection."/".$entry->ourBookID."\">\n";
    					echo "<dd class=".$dd_class.">\n";
						echo "<div class=english_book_name>";
						if ($entry->ourBookID == -1) echo "&nbsp;&nbsp;&nbsp&nbsp;";
						elseif ($entry->ourBookID == -35 and strcmp($collectionName, "nasai") == 0) echo "35b. ";
						else echo $entry->ourBookID.". ";
						echo $entry->englishBookName."</div>";
						echo "&nbsp;";
						echo "<div class=\"arabic_book_name arabic_basic\">".$entry->arabicBookName."</div>&nbsp;";
						if (($i - $splitSize) % 2 == 0) echo "<div class=list_first_bg>&nbsp;</div>";
						echo "</dd></a>\n\t\t\t\t";
                        echo "</div>";
						echo '<div style="clear:both"></div>';
    				}
				?>
			</dl>
		</div>
		<div class=clear></div>
	</div>

<?php

} // end the main display if no error

?>
