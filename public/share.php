<?php
?>

<!--<span style="font-size: 15px;"> Permalink</span><br/>-->
<input class=permalink_box type="text" value="http://sunnah.com<?php echo $_GET['link']; ?>" size=45 /><br>

<div>
	<div class="share_button" style="float: right; padding-right: 0px;">
		<div id="plusone-div" class="g-plusone" data-annotation="none" data-size="small" data-width="120" data-url="http://sunnah.com<?php echo $_GET['link']; ?>"></div>
	</div>

	<div class="share_button" style="float: right;">
		<div class="fb-share-button" data-href="http://sunnah.com<?php echo $_GET['link']; ?>" data-width="35"></div>
	</div>

	<div class="share_button" style="float: right;">
		<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://sunnah.com<?php echo $_GET['link']; ?>" data-text="Hadith" data-via="SunnahCom" data-size="large" data-count="none" data-dnt="true"></a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
	</div>
</div>

