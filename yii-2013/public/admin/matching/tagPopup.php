<?php
session_start();
$page_title = "Tag Hadith";

$con = mysql_connect("localhost", "ilmfruit_ansari", "ansari") or die(mysql_error());
mysql_select_db("ilmfruit_testhadithdb") or die(mysql_error());
mysql_query("SET NAMES utf8;"); mysql_query("SET CHARACTER_SET utf8;");

include "util.php";

$url = $_SERVER['SCRIPT_NAME'];
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


<body bgcolor="#DEE4D6" onLoad="document.theform.tag.focus()">

<?php

$lang = $_GET['lang'];
if (isset($_GET['coll'])) $collection = $_GET['coll'];
else $collection = "bukhari";
$urn = $_GET['urn'];


if ($lang == "english") {
	$alignment = "left";
	$dirn = "ltr";
}
elseif ($lang == "arabic") {
	$alignment = "right";
    $dirn = "rtl";
}


if (isset($_POST['submit'])) {
	$urn = $_POST['urn'];
	$tag = $_POST['tag'];
	updateTagText($urn, $tag, $live, $username);

	echo "
    <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr><td align=center>Tag committed.</td></tr>
	</table>
	<p align=center>
                <a href=\"\" onclick=\"window.opener.location.reload(); window.close()\">Close this window</a><br>(the book page will automatically refresh)
	</p>";

	
}
elseif (isset($_POST['deletetag'])) {
	$urn = $_POST['urn'];
	deleteTag($urn, $live, $username);
	echo "
    <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr><td align=center>Tag deleted.</td></tr>
    </table>
    <p align=center>
      <a href=\"\" onclick=\"window.opener.location.reload(); window.close()\">Close this window</a><br>(the book page will automatically refresh)    
    </p>";
}
else {

?>

	<form method="post" name="theform" action="<?php echo $url; ?>">
    <table width=75% align="center" cellpadding="0" cellspacing="0">
		<tr><td colspan=2>
			  <table width="60%" cellpadding=3 cellspacing="1" border=0 align="center">
			  <tr border=0><td colspan=2 border=0 align=center>
				Enter a note to tag this hadith with. You may leave the tag blank and still tag this hadith.
			  </td></tr>
			 <tr height=15></tr>
			 <tr><td colspan=2 border=0>
    			<p align=center>
        			<a href="#" onclick="window.close()">Close this window</a> without tagging
    			</p>
			</td></tr>
			 <tr height=15></tr>

			  </table>
		</td></tr>
		  <tr><td colspan=2>
			  <table width="60%" cellpadding=3 cellspacing="1" border="1" align="center">

					<?php
							$hadith = getHadith($collection, $lang, $urn);
							$tagText = getTag($urn);
							echo "
   <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>URN</td>
      <td width=\"40%\" border=\"1\" valign=\"top\">".$urn."</td>
    </tr>
    <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Number</td>
      <td width=\"40%\" border=\"1\" valign=\"top\">".$hadith['hadithNumber']."&nbsp;</td>
    </tr>
    <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Book</td>
      <td width=\"40%\" border=\"1\" valign=\"top\">".$hadith['bookName']."(".$hadith['bookNumber'].")</td>
    </tr>
	<tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Text</td>
      <td width=\"40%\" border=\"1\" valign=\"top\" align=".$alignment."><font size=5><pre style=\"white-space: pre-wrap;\">".$hadith['hadithText']."</pre></font></td>
    </tr>
    <tr>
      <td width=\"10%\" border=\"1\" valign=\"top\" align=right>Tag</td>
      <td width=\"40%\" border=\"1\" valign=\"top\"><textarea class=\"tastyle\" name=\"tag\" style=\"width: 500px;\">".$tagText."</textarea></td>
    </tr>";
?>
			  </table>
		  </td></tr>
		<tr height=15></tr>
		<tr><td align=center colspan=2>Enter tag above</td></tr>
		<tr height=15>
			<input type=hidden name="urn" value="<?php echo $urn;?>">
		</tr>
		 <tr>
			<td colspan=2>
					    <p align="center"><input type="submit" name="submit" value="Tag this hadith"></p>
    		</td>
		 </tr>
		<?php if ($tagText != NULL and strlen($tagText) > 0) { ?>
		 <tr>
			<td colspan=2>
					    <p align="center"><input type="submit" name="deletetag" value="Delete this tag"></p>
    		</td>
		 </tr>
		 <?php } ?>
	 </table>

	</form>
<?php

}

include "footer.php";
mysql_close($con);

?>


