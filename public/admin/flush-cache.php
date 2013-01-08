<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta name="generator" content="jemdoc, see http://jemdoc.jaboc.net/" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="jemdoc.css" type="text/css" />
<title></title>
</head>
<body>
<table summary="Table for page layout." id="tlayout">
<tr valign="top">
<td id="layout-menu">
<div class="menu-item"><a href="home.php">Admin&nbsp;Home</a></div>
<div class="menu-item"><a href="matching">Hadith&nbsp;(English)</a></div>
<div class="menu-item"><a href="matching/?lang=indonesian">Hadith&nbsp;(Indonesian)</a></div>
<div class="menu-item"><a href="matching/?lang=urdu">Hadith&nbsp;(Urdu)</a></div>
<div class="menu-item"><a href="tasks.php">Ongoing&nbsp;Projects</a></div>
<div class="menu-item"><a href="utilities.php" class="current">Utilities</a></div>
<div class="menu-item"><a href="/">Public&nbsp;Website</a></div>
<div class="menu-item"><a href="logout.php">Logout</a></div>
</td>
<td id="layout-content">
<p><?php include "matching/checklogin.php"; ?> </p>
<h2>Flush Memcached</h2>
<p>Flushing &hellip;</p>
<p><?php
if (isset($_GET['all'])) {
//echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/yiiadmin/flushcache";
$success = file_get_contents("http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/yiiadmin/flushcache");
if (substr($success, 0, 1) == '1') echo "Flushed successfully alhamdulillah.";
else echo "There was an error: $success";
}
elseif (isset($_POST['key'])) {
$success = file_get_contents("http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/default/index/flushcache/key/".rawurlencode(rawurlencode($_POST['key'])));
//echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/default/index/flushcache/key/".rawurlencode($_POST['key']);
if (substr($success, 0, 1) == '1') echo "Deleted key \"".$_POST['key']."\"successfully alhamdulillah.";
else echo "There was an error deleting the key \"".$_POST['key']."\": $success";
}
?> </p>
<p><a href="utilities.php">Back to Utilities page</a></p>
<div id="footer">
<div id="footer-text">
Page generated 2012-12-04 19:41:10 PST, by <a href="http://jemdoc.jaboc.net/">jemdoc</a>.
</div>
</div>
</td>
</tr>
</table>
</body>
</html>
