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
<h2>Memcached Stats</h2>
<p><?php
function printDetails($status) { 
echo "<table border='1'>"; 
echo "<tr><td>Memcache Server version:</td><td> ".$status['version']."</td></tr>";
echo "<tr><td>Process id of this server process </td><td>".$status ["pid"]."</td></tr>"; 
echo "<tr><td>Number of seconds this server has been running </td><td>".$status ["uptime"]."</td></tr>"; 
echo "<tr><td>Accumulated user time for this process </td><td>".$status ["rusage_user_seconds"]." seconds</td></tr>"; 
echo "<tr><td>Accumulated system time for this process </td><td>".$status ["rusage_system_seconds"]." seconds</td></tr>"; 
echo "<tr><td>Total number of items currently stored by this server</td><td>".$status ["curr_items"]."</td></tr>"; 
echo "<tr><td>Total number of items stored by this server ever since it started </td><td>".$status ["total_items"]."</td></tr>"; 
echo "<tr><td>Number of open connections </td><td>".$status ["curr_connections"]."</td></tr>"; 
echo "<tr><td>Total number of connections opened since the server started running </td><td>".$status ["total_connections"]."</td></tr>"; 
echo "<tr><td>Number of connection structures allocated by the server </td><td>".$status ["connection_structures"]."</td></tr>"; 
echo "<tr><td>Cumulative number of retrieval requests </td><td>".$status ["cmd_get"]."</td></tr>"; 
echo "<tr><td> Cumulative number of storage requests </td><td>".$status ["cmd_set"]."</td></tr>"; 
$percCacheHit=((real)$status ["get_hits"]/ (real)$status ["cmd_get"] *100); 
$percCacheHit=round($percCacheHit,3); 
$percCacheMiss=100-$percCacheHit; 
echo "<tr><td>Number of keys that have been requested and found present </td><td>".$status ["get_hits"]." ($percCacheHit%)</td></tr>"; 
echo "<tr><td>Number of items that have been requested and not found </td><td>".$status ["get_misses"]."($percCacheMiss%)</td></tr>"; 
$MBRead= (real)$status["bytes_read"]/(1024*1024); 
echo "<tr><td>Total number of bytes read by this server from network </td><td>".$MBRead." MB</td></tr>"; 
$MBWrite=(real) $status["bytes_written"]/(1024*1024) ; 
echo "<tr><td>Total number of bytes sent by this server to network </td><td>".$MBWrite." MB</td></tr>"; 
$MBSize=(real) $status["limit_maxbytes"]/(1024*1024) ; 
echo "<tr><td>Number of bytes this server is allowed to use for storage.</td><td>".$MBSize." MBs</td></tr>"; 
echo "<tr><td>Number of valid items removed from cache to free memory for new items.</td><td>".$status ["evictions"]."</td></tr>";
echo "</table>"; 
}
function printShortDetails($status) { 
echo "<table border='1'>"; 
$percCacheHit=((real)$status ["get_hits"]/ (real)$status ["cmd_get"] *100); 
$percCacheHit=round($percCacheHit,3); 
$percCacheMiss=100-$percCacheHit; 
echo "<tr><td>Hits</td><td>".$status ["get_hits"]." ($percCacheHit%)</td></tr>"; 
echo "<tr><td>Misses</td><td>".$status ["get_misses"]."($percCacheMiss%)</td></tr>"; 
echo "<tr><td>Number of items in cache</td><td>".$status ["curr_items"]."</td></tr>"; 
echo "<tr><td>Size of items in cache</td><td>".round($status['bytes']/(1024*1024), 2)." MB</td></tr>"; 
$num_days = floor($status ["uptime"]/86400);
$num_hours = round(($status ["uptime"] % 86400) / 3600);
echo "<tr><td>Memcached server uptime </td><td>".$num_days." days ".$num_hours." hours</td></tr>"; 
echo "<tr><td>Get requests </td><td>".$status ["cmd_get"]."</td></tr>"; 
echo "<tr><td> Set requests </td><td>".$status ["cmd_set"]."</td></tr>"; 
echo "<tr><td>Evictions.</td><td>".$status ["evictions"]."</td></tr>";
echo "</table>"; 
}
function getMemcacheKeys($memcache) {
$list = array();
$allSlabs = $memcache->getExtendedStats('slabs');
$items = $memcache->getExtendedStats('items');
foreach($allSlabs as $server => $slabs) {
foreach($slabs AS $slabId => $slabMeta) {
$cdump = $memcache->getExtendedStats('cachedump',(int)$slabId);
foreach($cdump AS $keys => $arrVal) {
if (!is_array($arrVal)) continue;
foreach($arrVal AS $k => $v) {                   
echo $k .'<br>';
}
}
}
}   
}
$memcache_obj = new Memcached(); 
$memcache_obj->addServer('localhost', 7630); 
$status = $memcache_obj->getStats();
$status = $status['localhost:7630'];
echo "<br><p>Short version: <br>";
printShortDetails($status);
//echo "<br>All keys:<br>";
//getMemcacheKeys($memcache_obj);
echo "<br><br><p>Long version: <br>";
printDetails($status);
//echo print_r($status);
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
