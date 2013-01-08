    function openquran(surah, beginayah, endayah) {
        window.open("http://quran.com/"+(surah+1)+"/"+beginayah+"-"+endayah, "quranWindow", "resizable = 1, fullscreen = 1");
    }
    function reportHadith(urn) {
        window.open("/report.php?urn="+urn, "reportWindow", "scrollbars = yes, resizable = 1, fullscreen = 1, location = 0, toolbar = 0, width = 500, height = 700");
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
	if ("pageType" in window)
		for (var lang in langDisplay) setLanguageDisplay(lang, langDisplay[lang]);

	if ($("#sidePanel").position()) {
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

	$("#sidePanelContainer").css('margin-left', parseInt($("#toolbar").position().left)-parseInt($("#sidePanelContainer").css('width').replace("px", "")));
  });

	$(window).bind("resize", function(){
		$("#sidePanelContainer").css('margin-left', parseInt($("#toolbar").position().left)-parseInt($("#sidePanelContainer").css('width').replace("px", "")));
	});

    var langLoaded = new Object();

    function loadLang(lang, collection, bookID) {
        $.getJSON("/ajax/"+lang+"/"+collection+"/"+bookID, function(data) { 
            $.each(data, function(idx, elt) {
				text = "<div class=\""+lang+"_hadith_full\">";
				if (elt["hadithSanad"]) text = text + "<span class=\""+lang+"_sanad\">"+elt["hadithSanad"]+"</span> ";
				text = text + elt["hadithText"]+"</div>"
				$("#h"+elt["matchingArabicURN"]).append(text);
			});
            langLoaded[lang] = true;
        });
    }

    function toggleLanguageDisplay(lang) {
        langDisplay[lang] = !langDisplay[lang];
        if (!langDisplay[lang]) setLanguageDisplay(lang, false);
        else setLanguageDisplay(lang, true);
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
		$.cookie('langprefs', JSON.stringify(langDisplay, null, 2), {path: '/'});
	}

	function setLangCBs() {
		for (var lang in langDisplay) $("#ch_"+lang).prop("checked", langDisplay[lang]);
	}

    langLoaded['english'] = true;
    langLoaded['indonesian'] = false;
    langLoaded['urdu'] = false;

	if ($.cookie('langprefs') == null) {
		var langDisplay = new Object();
		langDisplay['english'] = true;
		langDisplay['indonesian'] = false;
		langDisplay['urdu'] = false;
		setLangCookie();
	}
	else {
		langDisplay = JSON.parse($.cookie('langprefs'));
	}

