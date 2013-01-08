<?php
$page_title = "Ilmfruits Hadith Project - Admin Home";

include "setlang.php";
include "adminheader.php";
?>

    <table width=75% align="center" cellpadding="0" cellspacing="0">

        <tr height=50>
          <td>&nbsp;</td>
        </tr>


        <tr height=15>
          <td>&nbsp;</td>
        </tr>

		  <tr>
			  <table width="75%" cellpadding="5" cellspacing="5" border="1" align="center">
					<?php
						if (strcmp($lang, "indonesian") == 0) $urn = 3000010;
						elseif (strcmp($lang, "urdu") == 0) $urn = 4000010;
						else $urn = 10;
						$arabicURN = 100010;
						$eng_hadith_q = mysql_query("SELECT * FROM bukhari_".$lang." WHERE ".$lang."URN = ".$urn)
						  or die(mysql_error());
						$eng_hadith = mysql_fetch_array($eng_hadith_q);
									
						$arb_hadith_q = mysql_query("SELECT * FROM bukhari_arabic WHERE arabicURN = ".$arabicURN)
   	       		  		or die(mysql_error());
						$arb_hadith = mysql_fetch_array($arb_hadith_q);
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


