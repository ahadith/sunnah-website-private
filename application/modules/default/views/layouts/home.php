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
 
  <link href="/css/all.css" media="screen" rel="stylesheet" type="text/css" />

  <link rel="shortcut icon" href="/favicon.ico" >

  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
  <script src="/js/jquery.cookie.js"></script>

  <script src="/js/jquery.jcarousel.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/jcskin.css" />
  <script type="text/javascript">

	jQuery(document).ready(function() {

	//$('#ramadancarousel').load('/default/collection/ramadandata');

	//$.get('/default/collection/ramadandata', function(data) {
	//	$("#ramadancarousel").innerHTML(data);
	//});

	$.ajax({
		url: '/default/collection/ramadandata',
		async: false,
		success: function (data) { $("#ramadancarousel").append(data); },
	});

    jQuery('#ramadancarousel').jcarousel({
        size: 13,
		vertical: false,
		visible: 1,
		scroll: 1,
		auto: 15,
		wrap: "circular",
		buttonNextHTML: null,
		buttonPrevHTML: null,
    });
  });
  </script>


  <script src="/js/sunnah.js"></script>
 
  <title>
	<?php echo $this->titleString() ?>
	Sunnah.com - Sayings and Teachings of Prophet Muhammad (صلى الله عليه و سلم)
  </title>
</head>

<body>
<div id="site">

	<div id="header">
    	<div id="toolbar">
       		<div id="toolbarRight">
				<?php $this->renderPartial('/layouts/suite') ?>
	        </div>
    	</div>

		<a href="http://sunnah.com"><div id="banner" class=bannerTop></div></a>
		<div class=clear></div>
	</div>

	<div class=clear></div>
	<div id="topspace"></div>

	<div id=nonheader" style="position: relative; margin: 0 10px 0 30px;">
	<div class="mainContainer"><div id="main">
	        <?php 
				echo "<div class=clear></div>";
				echo $content; 
			?>
	<div class="clear"></div>
    </div><!-- main close -->
	</div> <!-- mainContainer close -->
	<div id=rightPanel>
		<?php $this->renderPartial('/index/ramadancarousel') ?>
	</div>
	<div class="clear"></div>
	</div> <!-- nonheader close -->
    <?php $this->renderPartial('//layouts/footer') ?>
	<div class="clear"></div>

</div><!-- site div close -->
</body>
</html>

