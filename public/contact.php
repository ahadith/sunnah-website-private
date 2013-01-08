<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="EN"/>
  <meta name="description" content="Hadith of the Prophet Muhammad (saws) in English and Arabic"/>
  <meta name="keywords" content="hadith, sunnah, bukhari, muslim, sahih, sunan, tirmidhi, nawawi, holy, arabic, iman, islam, Allah, book, english"/>
  <meta name="Charset" content="UTF-8"/> 
  <meta name="Distribution" content="Global"/>
  <meta name="Rating" content="General"/>

  <link href="/css/header.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/banner.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/toolbar.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/index.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/common.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/collection.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/hadith.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/search.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/footer.css" media="screen" rel="stylesheet" type="text/css" />

  <title>Sunnah.com - Sayings and Teachings of Prophet Muhammad (صلى الله عليه و سلم)</title>  <link rel="shortcut icon" href="/favicon.ico" >
  <script type="text/javascript">
  	function openquran(surah, beginayah, endayah) {
    	window.open("http://quran.com/"+(surah+1)+"/"+beginayah+"-"+endayah, "quranWindow", "resizable = 1, fullscreen = 1");
  	}
  	function reportHadith(urn) {
    	window.open("/report.php?urn="+urn, "reportWindow", "scrollbars = yes, resizable = 1, fullscreen = 1, location = 0, toolbar = 0, width = 500, height = 700");
  	}
  </script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22385858-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>
<body>
<div id="site">
	<div id="toolbar"> 
		<div id="toolbarRight"> 
			<a href="http://quran.com">Qur'an</a> |
			<a href="http://corpus.quran.com/wordbyword.jsp">Word by Word</a> | 
			<a href="http://quranicaudio.com">Audio</a> | 
			<span>New: sunnah.com</span> | 
			<a href="http://salah.com">Prayer Times</a> |
			<a href="http://android.quran.com">Android</a> |
			<a href="http://beta.quran.com"><b style="font-weight: normal; padding-right: 18px; position: relative;"><strong>New&nbsp;:</strong>&nbsp;beta.quran.com
				<!-- <img style="position: absolute; top: -6px; right: -12px;" src="http://c222770.r70.cf1.rackcdn.com/labs.png"> -->
				<img style="position: absolute; top: -6px; right: 0px;" src="/images/labs.png">
			</b></a>
		</div>
	</div> 

	
	<a href="http://sunnah.com/"><div id="header"></div></a>
    <div style="width:100%; height:5px; background-color:#867044"></div>

	<link href="/css/nav_menu.css" media="screen" rel="stylesheet" type="text/css" />

<div class="menu">
  <ul>
	<li><a href="/">Home</a></li>
<li><a href="/" target="_self" >Collections</a>
      <ul>
        <li><a href="/bukhari" target="_self">Sahih al-Bukhari</a></li>
        <li><a href="/muslim" target="_self">Sahih Muslim</a></li>
        <li><a href="/nasai" target="_self">Sunan an-Nasa'i*</a></li>
        <li><a href="/tirmidhi" target="_self">Jami` at-Tirmidhi*</a></li>
        <li><a href="/abudawud" target="_self">Sunan Abi Dawud*</a></li>
        <li><a href="/ibnmajah" target="_self">Sunan Ibn Majah*</a></li>
        <li><a href="/malik" target="_self">Muwatta Imam Malik</a></li>
        <li><a href="/nawawi40" target="_self">Imam Nawawi's 40 Hadith</a></li>
        <li><a href="/riyadussaliheen" target="_self">Riyad as-Salihin</a></li>
        <li><a href="/qudsi40" target="_self">40 Hadith Qudsi</a></li>
        <li><a href="/shamail" target="_self">Shama'il Muhammadiyah</a></li>
      </ul></li>
	<li><a href="/about">About</a><ul>
<li><a href="/about">The Website</a>
<li><a href="/support">Support Us</a></li>
<li><a href="/news">News</a></li>
<li><a href="/changelog">Change Log</a></li>
</ul></li><li><span class="selectedMenuItem"><a href="/contact">Contact</a></span></li>

				<div style="float: right; display: inline; padding-right: 10px; padding-top: 2px; vertical-align: center; height: 100%;">
			<form name="searchform" action="/search_redirect.php" method=get style="height: 100%;" id="searchform">
                <input type="text" size="25" class="input_search" name=query value="" id="searchBox"/>
            	<input type="submit" class="search_button" value="Search" />
           	</form>	
		</div>
		        <div class="clear"></div>
	</ul>
</div>

    <div id="wrapper">
        <div class="breadcrumbs">
    <a href="/">Home</a>&nbsp;&gt;&nbsp;Contact</div>

<?php
$url = $_SERVER['SCRIPT_NAME'];

function getIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) $IP=$_SERVER['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $IP=$_SERVER['HTTP_X_FORWARDED_FOR'];
    else $IP=$_SERVER['REMOTE_ADDR'];

    return $IP;
}

if (isset($_POST['submit'])) {
    $contacttext = $_POST['contacttext'];
    $email = $_POST['email'];
    $name = $_POST['name1'];

    $flagError = false;
    if (strlen($contacttext) < 2) $flagError = true;


    if ($flagError) {
        echo "An error occurred. Please try again.";
    }
    else {
          include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
          $securimage = new Securimage();
          if ($securimage->check($_POST['captcha_code']) == false) {
            echo "An error occurred with the captcha. Please try again.";
          }
          else {
            $timestamp = date("H:i:s M d Y", time());
            $fullString = "Message: ".$contacttext."\n";
            $fullString = $fullString."Submitted by $name (".$email.") at $timestamp\n";
            $fullString = $fullString."IP address: ".getIP()."\n";
            $to = "sunnah@iman.net";
            $subject = "[Contact] Sunnah.com - $timestamp";
            $headers = "From: contact@sunnah.com\r\nReply-To: $email";
            mail($to, $subject, $fullString, $headers);

            echo "
    <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr><td align=center>Your message has been sent. Thank you!</td></tr>
    </table>";
          }
    }
}
else {

?>


    <form method="post" name="theform" action="/contact">
    <table width=85% align="center" cellpadding="0" cellspacing="0" border=0>
        <tr><td>
          <table width="70%" cellpadding=3 cellspacing="1" border=0 align="center">
            <tr style="height:30px;"></tr>
            <tr align=center>
                <td border=0 colspan=2>
                We would love to hear any comments, suggestions, or feedback.<br>
                Please enter your message in the box below: <br><br>
                <textarea name=contacttext style="width: 400px; height: 200px; background-color: #eee;"></textarea></td>
            </tr>
            <tr style="height:10px;"></tr>
            <tr>
                <td>Your name:</td>
                <td><input type=text size=30 name=name1 /></td>
            </tr>
            <tr>
                <td>Your e-mail address:</td>
                <td><input type=text size=30 name=email /></td>
            </tr>
            <tr style="height:30px;"></tr>
            <tr align=center>
                <td colspan=2>
                    <img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" /><br>
                    Enter the captcha shown:
                    <a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false">[change]</a>
                    <br>
                    <input type="text" name="captcha_code" size="10" maxlength="6" />
                </td>
            </tr>
         </table>
        </td></tr>
        <tr height=15></tr>
         <tr>
            <td colspan=2>
                        <p align="center"><input type="submit" name="submit" value="Submit"></p>
            </td>
         </tr>
    </table>

    </form>
<?php

}

?>
<br />
<div style="display: none; width:100%; height:2px; background-color:#867044; margin-top: 30px;"></div>
<div class=footer>
<div class=footer_left>Sunnah.com &copy; 2011</div>
<div class=footer_right>
	<a href="/about">About</a> |
	<a href="/contact">Contact</a> |
	<a href="/support">Support</a>
</div>
<div class=footer_center>Sunnah.com supports <a href="http://www.islamic-relief.com/">Islamic Relief</a></div>
<div class=clear />
</div>
<div style="width:100%; height:4px; background-color:#867044; margin-top: 0px; margin-bottom: 0px;"></div>




<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://sunnah.com/piwik/" : "http://sunnah.com/piwik/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://sunnah.com/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>

<script type="text/javascript">
var sc_project=7148282; 
var sc_invisible=1; 
var sc_security="63a57073"; 
</script>

<script type="text/javascript"
src="http://www.statcounter.com/counter/counter.js"></script><noscript><div
class="statcounter"><a title="drupal statistics"
href="http://statcounter.com/drupal/" target="_blank"><img
class="statcounter"
src="http://c.statcounter.com/7148282/0/63a57073/1/"
alt="drupal statistics" ></a></div></noscript>

</body>
</html>

