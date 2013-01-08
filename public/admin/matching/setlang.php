<?php

if (isset($_GET['lang'])) $lang = addslashes($_GET['lang']);
else $lang = "english";
$lang = preg_replace("[^a-z]", "", $lang);

?>
