    function openquran(surah, beginayah, endayah) {
        window.open("http://quran.com/"+(surah+1)+"/"+beginayah+"-"+endayah, "quranWindow", "resizable = 1, fullscreen = 1");
    }
    function reportHadith(urn) {
        window.open("/report.php?urn="+urn, "reportWindow", "scrollbars = yes, resizable = 1, fullscreen = 1, location = 0, toolbar = 0, width = 500, height = 700");
    }

	function permalink(link) {
		$(".permalinkboxcontent").load("/permalink_pp.php?link="+link);
		$("#fuzz").show();
	}


  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22385858-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

  // (a) put default input focus on the state field
  // (b) jquery ajax autocomplete implementation
   $(document).ready(function () {  

	$("#fuzz").css("height", $(document).height());

	$(".ppclose").click(function(){  
      $("#fuzz").hide();
	});


	$(window).scroll(function() {
		if ($(window).scrollTop() > 750) $("#back-to-top").addClass('bttenabled');
		else $("#back-to-top").removeClass('bttenabled');

		if ($(window).scrollTop() > 25) { // this number is height of short banner + breadcrumbs - 40
			$("#banner").removeClass('bannerTop');
			$("#banner").addClass('bannerMiddle');
			$("#header").css('position', 'fixed');
			$("#header").css('top', '0');
			$("#topspace").css('display', 'block');
			$("#toolbar").css('display', 'none');
			$("#search").css('bottom', '29px'); // crumbs height + 10 bottom padding
			$("#sidePanel").css({'position': 'fixed', 'top': '65px', 'left': $(".mainContainer").position().left - $("#sidePanel").width() - 55}); // last number is sidePanelContainer padding
		}
		else {
			$("#banner").removeClass('bannerMiddle');
			$("#banner").addClass('bannerTop');
			$("#header").css('position', 'relative');
			$("#topspace").css('display', 'none');
			$("#toolbar").css('display', 'block');
			$("#search").css('bottom', '45px'); // crumbs height + 20 bottom padding
			$("#sidePanel").css('position', 'static');
		}
	});

	if ("searchQuery" in window) {
		$(".searchquery").val(searchQuery);
		$(".searchquery").css('color', '#000');
	}

	$(".indexsearchquery").focus(function() {
		$("#indexsearch").addClass('idxsfocus');
		$("#indexsearch").removeClass('idxsblur');

		if ($(".indexsearchquery").css('color') == 'rgb(187, 187, 187)') {
			$(".indexsearchquery").val('');
			$(".indexsearchquery").css('color', '#000');
		}
	});

	$(".indexsearchquery").blur(function() {
		$("#indexsearch").addClass('idxsblur');
		$("#indexsearch").removeClass('idxsfocus');

		if ($(".indexsearchquery").val() == '') {
			$(".indexsearchquery").val('Search …');
			$(".indexsearchquery").css('color', '#bbb');
		}
	});

	$(".searchquery").focus(function() {
		$("#searchbar").addClass('sfocus');
		$("#searchbar").removeClass('sblur');

		if ($(".searchquery").css('color') == 'rgb(187, 187, 187)') {
			$(".searchquery").val('');
			$(".searchquery").css('color', '#000');
		}
	});

	$(".searchquery").blur(function() {
		$("#searchbar").addClass('sblur');
		$("#searchbar").removeClass('sfocus');

		if ($(".searchquery").val() == '') {
			$(".searchquery").val('Search …');
			$(".searchquery").css('color', '#bbb');
		}
	});

	$(".searchtipslink").click(function() {
		if ($("#searchtips").css('display') == 'none') {
			$("#searchtips").show(400);
		}
		else $("#searchtips").hide(400);
	});

    $(".indexsearchtipslink").click(function() {
        if ($("#indexsearchtips").css('display') == 'none') {
            $("#indexsearchtips").show(400);
        }
        else $("#indexsearchtips").hide(400);
    });


   // tell the autocomplete function to get its data from our php script
  
     var $searchBox = $('#searchBox');

         $searchBox.autocomplete({
        source: "/autocomplete/javaCaller.php",
        minLength: 2,
                //select: {$("searchForm").submit() }
            select: function(e, ui) {
                   $searchBox.val(ui.item.value);
                   $("#searchform").submit();
                },  
        open: function (e, ui) {
                var acData = $(this).data('autocomplete');
                acData
                .menu
                .element
                .find('a')
                .each(function () {
                    var me = $(this);
                    var keywords = acData.term.split(' ').join('|');
                    me.html(me.text().replace(new RegExp("(" + keywords + ")", "gi"), '<b>$1</b>'));
                });
              } 
    
    });

	
	setLangCBs();
	if ("pageType" in window && spshowing) {
		if (langDisplay != 'english') setLanguageDisplay('english', false);
		setLanguageDisplay(langDisplay, true);
	}

/*	if ($("#sidePanel").position()) {
		var top_pos = $("#sidePanel").position().top;
	    $(window).scroll(function() {
    	    if(top_pos >= $(window).scrollTop()) {
        	    if($("#sidePanel").css('position') == 'fixed') {
            	    $("#sidePanel").css('position', 'relative');
	            }
    	    } else { 
        	    if($("#sidePanel").css('position') != 'fixed') {
            	    $("#sidePanel").css({'position': 'fixed', 'top': 0});
	            }
    	    }
    	});
	}
*/
	//$("#sidePanelContainer").css('margin-left', parseInt($("#toolbar").position().left)-parseInt($("#sidePanelContainer").css('width').replace("px", "")));
  });

	//$(window).bind("resize", function(){
		//$("#sidePanelContainer").css('margin-left', parseInt($("#toolbar").position().left)-parseInt($("#sidePanelContainer").css('width').replace("px", "")));
	//});

    var langLoaded = new Object();

    function loadLang(lang, collection, bookID) {
        $.getJSON("/ajax/"+lang+"/"+collection+"/"+bookID, function(data) { 
            $.each(data, function(idx, elt) {
				text = "<div class=\""+lang+"_hadith_full\">";
				if (elt["hadithSanad"]) text = text + "<span class=\""+lang+"_sanad\">"+elt["hadithSanad"]+"</span> ";
				text = text + elt["hadithText"]+"</div>"
				$("#t"+elt["matchingArabicURN"]).append(text);
			});
            langLoaded[lang] = true;
        });
    }

    function toggleLanguageDisplay(lang) {
		setLanguageDisplay(langDisplay, false);
        langDisplay = lang;
        setLanguageDisplay(lang, true);
		setLangCookie();
	}

	function setLanguageDisplay(lang, val) {
		if (val) {
			if (!langLoaded[lang]) loadLang(lang, collection, bookID);
			$("."+lang+"_hadith_full").css('display', 'block');
		}
		else $("."+lang+"_hadith_full").css('display', 'none');
	}

	function setLangCookie() {
		$.cookie('langprefs13', JSON.stringify(langDisplay, null, 2), {path: '/'});
	}

	function setLangCBs() {
		$("#ch_"+langDisplay).prop("checked", true);
	}

    langLoaded['english'] = true;
    langLoaded['indonesian'] = false;
    langLoaded['urdu'] = false;

	if ($.cookie('langprefs13') == null) {
		langDisplay = 'english';
		setLangCookie();
	}
	else {
		langDisplay = JSON.parse($.cookie('langprefs13'));
	}

