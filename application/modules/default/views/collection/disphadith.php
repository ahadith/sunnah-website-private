<?php

	if (isset($ourHadithNumber)) {
		if ($ourHadithNumber > 0) $linknum = $ourHadithNumber;
		else $linknum = $counter;
	}
	else $linknum = 1;

	if (isset($arabicEntry->annotations)) $annotation = $arabicEntry->annotations;

	echo "<!-- Begin hadith -->\n\n";
	echo "<div class=hadithEnv id=h".$arabicEntry->arabicURN.">\n";
	echo "<a name=$linknum></a>\n";
	
			echo "<div class=\"english_hadith_full\">";
            if (strpos($englishText, ":") === FALSE) {
            	echo "<div class=text_details>\n
                     ".$englishText."</div><br />\n";
            }
            else {
                echo "<div class=hadith_narrated>".strstr($englishText, ":", true).":</div>";
                echo "<div class=text_details>
                     ".substr(strstr($englishText, ":", false), 1)."</div><br />\n";
            }
            echo "</div>";
            $arabicSanad1 = "";
            $arabicSanad2 = "";
            if (substr_count($arabicText, "\"") == 2) {
                $arabicSanad1 = strstr($arabicText, "\"", true);
                $arabicText = substr(strstr($arabicText, "\"", false), 1);
                $arabicSanad2 = substr(strstr($arabicText, "\"", false), 1);
                $arabicText = "\"".strstr($arabicText, "\"", true)."\"";
            }

            echo "<div class=\"arabic_hadith_full arabic_basic\">";
            echo "<span class=\"arabic_sanad\">".$arabicSanad1."</span>\n";
            echo "<span class=\"arabic_text_details\">".$arabicText."</span>";
            echo "<span class=\"arabic_sanad\">".$arabicSanad2."</span>";
			if (isset($annotation)) echo "<p><span class=arabic_annotation>$annotation</span>";
			echo "</div><br />\n";
			if (!is_null($otherlangs)) {
				foreach ($otherlangs as $langname => $hadith) echo "<div class=$langname>".$hadith."</div>\n<br>\n";
			}
	echo "</div>";

	echo "<!-- End hadith -->\n\n";
?>