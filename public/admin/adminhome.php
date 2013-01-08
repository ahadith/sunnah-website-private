<?php
$page_title = "Ilmfruits Hadith Project - Admin Home";
include "matching/adminheader.php";


?>

    <table width=75% align="center" cellpadding="0" cellspacing="0">

        <tr height=50>
          <td>&nbsp;</td>
        </tr>

        <tr>
          <td align=center> <a href="manualMatch.php">Enter matched pair manually</a></td>
        </tr>

		<tr height=15></tr>

        <tr>
          <td align=center> <a href="mergeHadith.php">Merge two ahadith</a></td>
        </tr>

        <tr height=15>
          <td>&nbsp;</td>
        </tr>

		  <tr>
			  <table width="75%" cellpadding="5" cellspacing="5" border="1" align="center">
					<?php
						if (isset($_GET["eurn"]) && is_numeric($_GET["eurn"])) $englishURN = $_GET["eurn"];
						else $englishURN = 10;
						
						if (isset($_GET["aurn"]) && is_numeric($_GET["aurn"])) $arabicURN = $_GET["aurn"];
						elseif ($englishURN != 10) {
							$urn_query = mysql_query("SELECT arabicURN FROM matchtable WHERE englishURN = ".$englishURN)
							  or die(mysql_error());
							$arabic_urn_a = mysql_fetch_array($urn_query);
							$arabicURN = $arabic_urn_a['arabicURN'];
						}
						else $arabicURN = 10;
						if ($englishURN != 10) {
							$eng_hadith_q = mysql_query("SELECT * FROM bukhari_english WHERE englishURN = ".$englishURN)
							  or die(mysql_error());
							$eng_hadith = mysql_fetch_array($eng_hadith_q);
									
							if (!is_null($arabicURN)) {
								$arb_hadith_q = mysql_query("SELECT * FROM bukhari_arabic WHERE arabicURN = ".$arabicURN)
							  		or die(mysql_error());
								$arb_hadith = mysql_fetch_array($arb_hadith_q);
							}
						}
						else {
							$eng_hadith['hadithText'] = "
<p> 
 
     Narrated 'Umar bin Al-Khattab:
<p> 
 
     I heard Allah's Apostle saying, \"The reward of deeds depends upon the 
     intentions and every person will get the reward according to what he 
     has intended. So whoever emigrated for worldly benefits or for a woman
     to marry, his emigration was for what he emigrated for.\"
<p>"; 
							$arb_hadith['hadithText'] = "
حَدَّثَنَا الْحُمَيْدِيُّ عَبْدُ اللَّهِ بْنُ الزُّبَيْرِ، قَالَ حَدَّثَنَا سُفْيَانُ، قَالَ حَدَّثَنَا يَحْيَى بْنُ سَعِيدٍ الأَنْصَارِيُّ، قَالَ أَخْبَرَنِي مُحَمَّدُ بْنُ إِبْرَاهِيمَ التَّيْمِيُّ، أَنَّهُ سَمِعَ عَلْقَمَةَ بْنَ وَقَّاصٍ اللَّيْثِيَّ، يَقُولُ سَمِعْتُ عُمَرَ بْنَ الْخَطَّابِ ـ رضى الله عنه ـ عَلَى الْمِنْبَرِ قَالَ سَمِعْتُ رَسُولَ اللَّهِ صلى الله عليه وسلم يَقُولُ ‏\"‏ إِنَّمَا الأَعْمَالُ بِالنِّيَّاتِ، وَإِنَّمَا لِكُلِّ امْرِئٍ مَا نَوَى، فَمَنْ كَانَتْ هِجْرَتُهُ إِلَى دُنْيَا يُصِيبُهَا أَوْ إِلَى امْرَأَةٍ يَنْكِحُهَا فَهِجْرَتُهُ إِلَى مَا هَاجَرَ إِلَيْهِ ‏\"‏";
						}
?>
			 		<tr>
						<td width="50%" border="1"><?php echo $eng_hadith['hadithText']; ?></td>
			 			<td width="50%" border="1" align=right><font name="times new roman(arabic)" size="5"><?php echo $arb_hadith['hadithText']; ?></font></td>
					</tr>
			  </table>
		  </tr>
	 </table>

<?php

include "footer.php";
mysql_close($con);

?>


