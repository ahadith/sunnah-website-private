<?php

class CollectionController extends Controller
{
	protected $_collection;
	protected $_book;
	protected $_entries;
	protected $_chapters;
	protected $_collectionName;
	protected $_ourBookID;
	protected $_otherlangs;
	protected $_ajaxCrawler = false;

	public function filters() {
		return array(
			array(
				'COutputCache',
	            'duration'=>Yii::app()->params['cacheTTL'],
    	        'varyByParam'=>array('id', 'collectionName', 'ourBookID', 'urn', 'hadithNumbers', 'lang', '_escaped_fragment_'),
			),
		);
	}

    public function actionAjaxHadith($collectionName, $ourBookID, $lang) {
        $this->_book = $this->util->getBook($collectionName, $ourBookID);
		if ($this->_book) {
			$this->_entries = $this->_book->fetchLangHadith($lang);
			echo json_encode($this->_entries);
		}
	}
	
	public function actionIndex($collectionName)
	{
        $this->_collectionName = $collectionName;
		$this->_collection = $this->util->getCollection($collectionName);
        if ($this->_collection) {
        	$this->_entries = $this->util->getBook($collectionName);
        }
        if (is_null($this->_collection) || count($this->_entries) == 0) {
            $this->_errorMsg = "There is no such collection on our website. Click <a href=\"/\">here</a> to go to the home page.";
        	$this->render('index');
            return;
        }

        $this->pathCrumbs($this->_collection->englishTitle, "/$collectionName");
		$this->_pageType = "collection";
        $this->render('index');
    }
    
    public function actionAbout($collectionName) {
		$this->_collection = $this->util->getCollection($collectionName);
    	$this->_collectionName = $collectionName;
        $this->_pageType = "about";
        $this->pathCrumbs("About", "");
        $this->pathCrumbs($this->_collection->englishTitle, "/$collectionName");
        $this->_viewVars->aboutInfo = $this->_collection->about;
        $this->render('about');
    }

	public function actionColindex($collectionName) {
		$this->_collection = $this->util->getCollection($collectionName);
    	$this->_collectionName = $collectionName;
        $this->_pageType = "about";
        $this->pathCrumbs("Index", "");
        $this->pathCrumbs($this->_collection->englishTitle, "/$collectionName");
        $this->_viewVars->books = $this->util->getBook($collectionName);
        $this->render('colindex');
	}
    
    public function actionDispbook($collectionName, $ourBookID, $hadithNumbers = NULL, $_escaped_fragment_ = "default") {
    	$this->_collectionName = $collectionName;
        if (!(is_null($hadithNumbers))) $hadithRange = addslashes($hadithNumbers);
        else $hadithRange = NULL;
		$this->_collection = $this->util->getCollection($collectionName);
        if (is_null($hadithRange)) $this->_pageType = "book";
        else {
            $this->_pageType = "hadith";
            $this->pathCrumbs('Hadith', "");
        }
        $this->_ourBookID = $ourBookID;
		$this->_book = $this->util->getBook($collectionName, $ourBookID);
        if ($this->_book) $this->_entries = $this->_book->fetchHadith($hadithRange);

		if (strcmp($_escaped_fragment_, "default") != 0) {
			if ($this->_book->indonesianBookID > 0) $this->_otherlangs['indonesian'] = $this->_book->fetchLangHadith("indonesian");
			if ($this->_book->urduBookID > 0) $this->_otherlangs['urdu'] = $this->_book->fetchLangHadith("urdu");
			if (count($this->_otherlangs) > 0) $this->_ajaxCrawler = true;
		}

        if (!isset($this->_entries) || count($this->_entries) == 0) {
            $this->_errorMsg = "You have entered an incorrect URL. Please use the menu above to navigate the website.";
        	$this->render('dispbook');        
            return;
        }

		if ($this->_book->status > 3) {
			$this->_chapters = array();
			$retval = $this->util->getChapterDataForBook($collectionName, $ourBookID);
			foreach ($retval as $chapter) $this->_chapters[$chapter->babID] = $chapter;
		}

        if (strlen($this->_book->englishBookName) > 0) {
			if (intval($ourBookID) == -1) $lastlink = "introduction";
			elseif (intval($ourBookID) == -35) $lastlink = "35b";
			else $lastlink = $ourBookID;
            $this->pathCrumbs($this->_book->englishBookName, "/".$collectionName."/".$lastlink);
        }
        $this->pathCrumbs($this->_collection->englishTitle, "/$collectionName");
        $this->render('dispbook');        
	}
	
	public function actionUrn($urn) {
        $englishHadith = NULL; $arabicHadith = NULL;
        if (is_numeric($urn)) {
            $lang = "english";
            $englishHadith = $this->util->getHadith($urn, "english");
            if (is_null($englishHadith) || $englishHadith === false) {
                $lang = "arabic";
                $arabicHadith = $this->util->getHadith($urn, $lang);
                if ($arabicHadith) $englishHadith = $this->util->getHadith($arabicHadith->matchingEnglishURN, "english");
            }
            else $arabicHadith = $this->util->getHadith($englishHadith->matchingArabicURN, "arabic");

			if (is_null($englishHadith) && is_null($arabicHadith)) {
				throw new CHttpException(404, 'The URL you have entered appears to be invalid.');
			}

            if (strcmp($lang, "english") == 0) {
            	$this->_collectionName = $englishHadith->collection;
            	$this->_book = $this->util->getBookByLanguageID($this->_collectionName, $englishHadith->bookID, "english");
            	$this->_ourBookID = $this->_book->ourBookID;
            }
            else if (!(is_null($arabicHadith))) {
            	$this->_collectionName = $arabicHadith->collection;
        		$this->_book = $this->util->getBookByLanguageID($this->_collectionName, $arabicHadith->bookID, "arabic");
            	$this->_ourBookID = $this->_book->ourBookID;
        	}
            
        	$this->_collection = $this->util->getCollection($this->_collectionName);
        }

        $this->_viewVars->englishEntry = $englishHadith;
        $this->_viewVars->arabicEntry = $arabicHadith;
        $this->_viewVars->pageType = "hadith";
        $this->pathCrumbs('Hadith', "");
        if (strlen($this->_book->englishBookName) > 0) {
            $this->pathCrumbs($this->_book->englishBookName." - <span class=arabic_text>".$this->_book->arabicBookName.'</span>', "/".$this->_collectionName."/".$this->_ourBookID);
        }
        $this->pathCrumbs($this->_collection->englishTitle, "/$this->_collectionName");
        $this->render('urn');
	}
}
