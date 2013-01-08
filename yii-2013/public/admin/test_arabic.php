<?php 

  $con = mysql_connect("localhost", "ansari", "ansari") or die(mysql_error());
  mysql_select_db("hadithdb") or die(mysql_error());



  $hadith_q = mysql_query("SELECT hadithText FROM ArabicHadithTable WHERE arabicURN = 100010") or die(mysql_error());
  $hadith = mysql_fetch_array($hadith_q);
  echo $hadith['hadithText'];

  mysql_close($con);
?>
