<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php if (isset($this->_book) and ($this->_book->indonesianBookID > 0 or $this->_book->urduBookID > 0)) echo "<meta name=\"fragment\" content=\"!\">\n"; ?>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="EN"/>
  <meta name="description" content="Hadith of the Prophet Muhammad (saws) in English and Arabic"/>
  <meta name="keywords" content="hadith, sunnah, bukhari, muslim, sahih, sunan, tirmidhi, nawawi, holy, arabic, iman, islam, Allah, book, english"/>
  <meta name="Charset" content="UTF-8"/> 
  <meta name="Distribution" content="Global"/>
  <meta name="Rating" content="General"/>
 
  <!---<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" /> -->
  <link href="/css/header.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/banner.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/toolbar.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/index.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/common.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/collection.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/hadith.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/search.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/footer.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/nav_menu.css" media="screen" rel="stylesheet" type="text/css" />

  <link rel="shortcut icon" href="/favicon.ico" >

  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
  <script src="/js/jquery.cookie.js"></script>

  <?php if (isset($this->_book)) { ?>
	<script>
	    var collection = '<?php echo $this->_collectionName; ?>';
	    var bookID = '<?php echo $this->_ourBookID; ?>';
		var pageType = 'hadithtext';
	</script>
  <?php } ?>

  <script src="/js/sunnah.js"></script>
 
  <title>
	<?php echo $this->titleString() ?>
	Sunnah.com - Sayings and Teachings of Prophet Muhammad (صلى الله عليه و سلم)
  </title>
</head>


<body>
<div id="site">
	<div id="topStuff">
    <div id="toolbar">
        <div id="toolbarRight">
            <a href="http://quran.com">Qur'an</a> |
            <a href="http://corpus.quran.com/wordbyword.jsp">Word by Word</a> |
            <a href="http://quranicaudio.com">Audio</a> |
            <span>sunnah.com</span> |
            <a href="http://salah.com">Prayer Times</a> |
            <a href="http://android.quran.com">Android</a> |
            <a href="http://beta.quran.com"><b style="font-weight: normal; padding-right: 18px; position: relative;"><strong>New&nbsp;:</strong>&nbsp;beta.quran.com
                <!-- <img style="position: absolute; top: -6px; right: -12px;" src="http://c222770.r70.cf1.rackcdn.com/labs.png"> -->
                <img style="position: absolute; top: -6px; right: -10px;" src="/images/labs.png">
            </b></a>
        </div>
    </div>

    <a href="http://sunnah.com/"><div id="header"></div></a>
    <div style="width:960px; margin-left: auto; height:5px; background-color:#867044;"></div>

    <?php $this->renderPartial('/layouts/nav_menu') ?>

	</div> <!-- end topStuff -->

	<div id="sidePanelContainer">
	<div style="height: 1px;"></div>
	<div id="sidePanel">
	<?php if (isset($this->_book)) {
		$langarray = array();
		if ($this->_book->indonesianBookID > 0) $langarray[] = 'indonesian';
		if ($this->_book->urduBookID > 0) $langarray[] = 'urdu';
    	if (count($langarray) > 0) $this->renderPartial('/layouts/side_panel', array('langarray' => $langarray));
	 } ?>
    </div>
	</div>

    <div id="wrapper">
        <?php echo $this->pathCrumbs("Home", "/"); ?>
        <?php echo $content; ?>
    </div> <!-- wrapper close -->
	<div style="clear: both;"></div>

    <?php $this->renderPartial('//layouts/footer') ?>


</div><!-- site div close -->
</body>
</html>

