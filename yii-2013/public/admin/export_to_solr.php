<?php 

  $con = mysql_connect("localhost", "webread") or die(mysql_error());
  mysql_select_db("hadithdb") or die(mysql_error());
  mysql_query("SET NAMES utf8;"); mysql_query("SET CHARACTER_SET utf8;");

  $totalString = "";
  if (ob_get_level() == 0) ob_start();

  $outfile = fopen("arabicHadith.xml", 'w');
  echo "Reading Arabic hadith ... "; flush(); ob_flush();
  $hadith_q = mysql_query("SELECT * FROM ArabicHadithTable") or die(mysql_error());
  fwrite($outfile, "<add>\n");
  $totalString .= "<add>\n";
  $counter = 0;
  while ($hadith = mysql_fetch_array($hadith_q)) {

	$hadithText = $hadith['hadithText'];
	$hadithText = preg_replace("/<A.*?>/", "", $hadithText);
	$hadithText = preg_replace("/<A.*?$/", "", $hadithText);
	$hadithText = preg_replace("/<\/[aA]>/", "", $hadithText);
	$hadithText = preg_replace("/<\/bdo>/", "", $hadithText);
	$hadithText = preg_replace("/<\/?c_[qs].*?>/", "", $hadithText);
	$hadithText = preg_replace("/<\/?font.*?>/", "", $hadithText);
	$hadithText = preg_replace("/<\/?IMG.*?>/", "", $hadithText);
	$hadithText = preg_replace("/<\/?c.*?$/", "", $hadithText);
	$hadithText = preg_replace("/<\/?b.*?$/", "", $hadithText);

	$hadithText = $hadith['hadithText'];
	$hadithText = strip_tags($hadithText);
	$hadithText = preg_replace("/\&nbsp;/", " ", $hadithText);

    $fullString = "  <doc>\n";
    $fullString = $fullString."    <field name=\"URN\">".$hadith['arabicURN']."</field>\n";
    $fullString = $fullString."    <field name=\"arabichadithText\">".$hadithText."</field>\n";
    $fullString = $fullString."  </doc>\n";
    fwrite($outfile, $fullString);
	$totalString .= $fullString;
	$counter++;
  }
  fwrite($outfile, "</add>");
  $totalString .= "</add>";
  fclose($outfile);
  echo "done ($counter hadith)\n<br>"; flush(); ob_flush();

  $outfile = fopen("englishHadith.xml", 'w');
  echo "Reading English hadith ... "; flush(); ob_flush();
  $hadith_q = mysql_query("SELECT * FROM EnglishHadithTable") or die(mysql_error());
  $totalString2 = "<add>\n";
  fwrite($outfile, "<add>\n");
  $counter = 0;
  while ($hadith = mysql_fetch_array($hadith_q)) {
    $hadithText = $hadith['hadithText'];
    $hadithText = preg_replace("/<\/?.*?>/", "", $hadithText);
	$hadithText = htmlspecialchars($hadithText);


    $fullString = "  <doc>\n";
    $fullString = $fullString."    <field name=\"URN\">".$hadith['englishURN']."</field>\n";
    $fullString = $fullString."    <field name=\"hadithText\">".$hadithText."</field>\n";
    $fullString = $fullString."  </doc>\n";
    fwrite($outfile, $fullString);
	$totalString2 .= $fullString;
	$counter++;
  }
  fwrite($outfile, "</add>");
  $totalString2 .= "</add>";
  fclose($outfile);
  echo "done ($counter hadith)\n<br>"; flush(); ob_flush();

  $url = "http://localhost:7641/solr/update";
  $post_string = $totalString2;

  //$header = array("Content-Type:text/xml");
  $header = array("Content-type:text/xml; charset=utf-8");

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt($ch, CURLOPT_USERPWD, "ansari:ansari");
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
  curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

  echo "Clearing index ...<br>\n"; flush(); ob_flush();
  curl_setopt($ch, CURLOPT_POSTFIELDS, "<delete><query>*:*</query></delete>");
  $data = curl_exec($ch);
  if (curl_errno($ch)) print "curl_error:" . curl_error($ch);
  
  echo "POSTing English hadith ...<br>\n"; flush(); ob_flush();
  curl_setopt($ch, CURLOPT_POSTFIELDS, $totalString2);
  $data = curl_exec($ch);
  if (curl_errno($ch)) print "curl_error:" . curl_error($ch);
  
  echo "POSTing Arabic hadith ...<br>\n"; flush(); ob_flush();
  curl_setopt($ch, CURLOPT_POSTFIELDS, $totalString);
  $data = curl_exec($ch);
  if (curl_errno($ch)) print "curl_error:" . curl_error($ch);
  

  echo "Committing ...<br>\n"; flush(); ob_flush();
  curl_setopt($ch, CURLOPT_POSTFIELDS, "<commit />");
  $data = curl_exec($ch);
  if (curl_errno($ch)) print "curl_error:" . curl_error($ch);
  else {  
           curl_close($ch);
           print "<br>\n\ncURL exited successfully\n";
  } 

?>
