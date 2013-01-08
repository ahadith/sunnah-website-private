<?php 
	$collections = $this->collections; 
	$num_collections = count($collections);
	$splitSize=round($num_collections/2, 0, PHP_ROUND_HALF_UP);
?>

	<div align=center style="font-size: 20px; font-variant: small-caps; font-family: Arial;">
		The Hadith of the Prophet Muhammad (صلى الله عليه و سلم) at your fingertips
	</div>
    <div align=center style="font-size: 16px; font-variant: small-caps; font-family: Arial;">
        in Arabic, English, Bahasa Indonesia*, and Urdu*
    </div>
	<div class=title align=center style="font-size: 15px;">
	</div>


	<div style="margin:auto; text-align:center; padding-top:10px; border: 0px solid;">
	<!--	<div class="title" style="padding-bottom:12px; font-size: 20px;">Search in collections</div> -->
	<!--<div class="title" style="padding-bottom:12px; font-size: 14px;">Please bear with us today
while we finish moving to a new design.</div> -->

            <div>
			 	<form name="searchform" action="/search_redirect.php" method=get id="searchform">
                	<input type="text" size="30" class="input_search" style="height: 28px; font-size: 18px;" name=query id="searchBox" />
                    <input type="submit" class="search_button" style="height: 30px; font-size: 14px; width: 200px;" value="Search" />
                </form>
				<span class=collection_intro_short style="margin-left: -200px; text-decoration: underline;"> <a href="/searchtips" style="color: black;">Search Tips</a> </span>
            </div>
            <div class="title" style="padding:15px 0 10px 0; font-size: 17px;">
				Browse collections
				<br>
				<span style="font-size: 14px;">(Current hadith count: <b><?php echo $this->_hadithCount; ?></b>)</span>
			</div>
            <div align=center><div style="width: 93%;">
            <div class="collection_titles separator" style="border: 0px solid; padding-right: 6px;">
				<?php 
					for ($i = 0; $i < $splitSize; $i++)  {
						$collection = $collections[$i]; ?>
						<a href="/<?php echo $collection['name']; ?>" style="display: inline;">
						  <dd style="display: inline;">
							<div class=english_collection_title><?php echo $collection['englishTitle']; ?>
								<?php if (strcmp($collection['status'], "incomplete") == 0) echo "*"?>
							</div>
							&nbsp;
							<div class="arabic_collection_title"><?php echo $collection['arabicTitle']; ?></div>
						  </dd>
                        </a>
                        <div class=collection_annotation><?php echo $collection['annotation']; ?>&nbsp;</div>
                        <div style="clear:both"></div>
				<?php
					} ?>
			</div><!-- end collection titles 1 -->
            <div class="collection_titles" style="float: right;">
				<?php 
					for ($i = $splitSize; $i < $num_collections; $i++) {
						$collection = $collections[$i]; ?>
						<a href="/<?php echo $collection['name']; ?>" style="display: inline;">
						  <dd style="display: inline;">
							<div class=english_collection_title><?php echo $collection['englishTitle']; ?>
								<?php if (strcmp($collection['status'], "incomplete") == 0) echo "*"?>
							</div>
							&nbsp;
							<div class="arabic_collection_title"><?php echo $collection['arabicTitle']; ?></div>
						  </dd>
                        </a>
                        <div class=collection_annotation><?php echo $collection['annotation']; ?>&nbsp;</div>
                        <div style="clear:both"></div>
				<?php
					} ?>
			</div><!-- end collection titles 2 -->
			</div></div> <!-- end center div and width div -->
			<div style="clear: both;"></div>
			<font size=2>	*: in progress</font>
	</div>
	<div style="clear: both;"></div>
