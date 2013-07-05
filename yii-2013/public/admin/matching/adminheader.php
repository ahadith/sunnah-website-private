<?php
include "checklogin.php";

if (!isset($delay_headers)) {

?>


<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
    <title><?php echo $page_title; ?></title>
    <link href="style.css" rel="stylesheet" type="text/css" />

  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-22385858-1']);
    o_gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

  </script>
</head>


<body bgcolor="#DEE4D6">

<div class="contentPaneOuter">
<div class="contentPane">


<style media="all" type="text/css">@import "menu_style.css";</style>
<div class="menu">
  <ul>
    <li><a href="/admin/matching/?lang=<?php echo $lang;?>">Home</a></li>
    <li><a href="/admin/">AdminHome</a></li>
    <li><a href="/admin/matching/?lang=<?php echo $lang;?>" target="_self" >Collections</a>
      <ul>
        <li><a href="bukhari.php?lang=<?php echo $lang;?>" target="_self">Saḥīḥ al-Bukhārī</a></li>
        <li><a href="muslim.php?lang=<?php echo $lang;?>" target="_self">Saḥīḥ Muslim</a></li>
        <li><a href="malik.php?lang=<?php echo $lang;?>" target="_self">Muwaṭṭa Imām Mālik</a></li>
        <li><a href="tirmidhi.php?lang=<?php echo $lang;?>" target="_self">Sunan at-Tirmidhi</a></li>
        <li><a href="abudawud.php?lang=<?php echo $lang;?>" target="_self">Sunan Abi Dawud</a></li>
        <li><a href="nasai.php?lang=<?php echo $lang;?>" target="_self">Sunan An-Nasai</a></li>
        <li><a href="ibnmajah.php?lang=<?php echo $lang;?>" target="_self">Sunan Ibn Majah</a></li>
        <li><a href="nawawi40.php?lang=<?php echo $lang;?>" target="_self">Imam Nawawi's 40 Hadith</a></li>
        <li><a href="riyadussaliheen.php?lang=<?php echo $lang;?>" target="_self">Riyad-us-Saliheen</a></li>
        <li><a href="shamail.php?lang=<?php echo $lang;?>" target="_self">Shamail Muhammadiyah</a></li>
        <li><a href="qudsi.php?lang=<?php echo $lang;?>" target="_self">40 Hadith Qudsi</a></li>
        <li><a href="bulugh.php?lang=<?php echo $lang;?>" target="_self">Bulugh al-Maram</a></li>
        <li><a href="adab.php?lang=<?php echo $lang;?>" target="_self">Al-Adab al-Mufrad</a></li>
        <li><a href="hisn.php?lang=<?php echo $lang;?>" target="_self">Hisn al-Muslim</a></li>
      </ul>
    <li><a href="howto.php?lang=<?php echo $lang;?>">Howto</a></li>
    <li><a href="about.php?lang=<?php echo $lang;?>">About</a></li>
    <li><a href="/admin/logout.php">Logout</a></li>
    </li>
  </ul>
</div>

	<hr width="75%">

    <div class="PageTitleOuter">
        <div class="PageTitle">
            <?php echo $page_title; ?>
        </div>
    </div>


<?php

}

?>
