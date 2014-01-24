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
<h1>Utilities Page</h1>
<h3>Hadith Data</h3>
<p><a href="refresh.php">Update production tables</a></p>
<p><a href="update-solr.php">Update Solr index</a></p>
<p><a href="update-mobiledb.php">Refresh mobile app DB</a></p>
<h3>Memcached</h3>
<p><a href="memcached-stats.php">Memcached Stats</a></p>
<p><a href="flush-cache.php?all">Flush Memcached</a> (be careful, this flushes ALL cache data)</p>
<form name=flushcache action="flush-cache.php" method=post>
Or delete a specific key: 
<input type=text name=key>&nbsp;
<input type=submit value="Delete">
</form>
<div id="footer">
<div id="footer-text">
Page generated 2013-12-08 17:13:59 PST, by <a href="http://jemdoc.jaboc.net/">jemdoc</a>.
</div>
</div>
</td>
</tr>
</table>
</body>
</html>
