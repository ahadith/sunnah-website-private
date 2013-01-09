update ilmfruit_testhadithdb.bukhari_arabic set collection = 'bukhari' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.bukhari_english set collection = 'bukhari' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.bukhari_indonesian set collection = 'bukhari' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.bukhari_urdu set collection = 'bukhari' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.muslim_arabic set collection = 'muslim' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.muslim_english set collection = 'muslim' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.malik_arabic set collection = 'malik' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.malik_english set collection = 'malik' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.riyadussaliheen_arabic set collection = 'riyadussaliheen' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.riyadussaliheen_english set collection = 'riyadussaliheen' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.tirmidhi_arabic set collection = 'tirmidhi' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.tirmidhi_english set collection = 'tirmidhi' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.abudawud_arabic set collection = 'abudawud' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.abudawud_english set collection = 'abudawud' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.abudawud_indonesian set collection = 'abudawud' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.nasai_arabic set collection = 'nasai' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.nasai_english set collection = 'nasai' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.nasai_indonesian set collection = 'nasai' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.qudsi40_arabic set collection = 'qudsi40' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.qudsi40_english set collection = 'qudsi40' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.shamail_arabic set collection = 'shamail' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.shamail_english set collection = 'shamail' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.ibnmajah_arabic set collection = 'ibnmajah' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.ibnmajah_english set collection = 'ibnmajah' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.adab_arabic set collection = 'adab' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.adab_english set collection = 'adab' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.bulugh_arabic set collection = 'bulugh' WHERE collection IS NULL or collection = '';
update ilmfruit_testhadithdb.bulugh_english set collection = 'bulugh' WHERE collection IS NULL or collection = '';

/* Update BookData for evolving books  */;
delete from hadithdb.BookData where collection = "nasai"; 
insert into hadithdb.BookData (collection, englishBookID, englishBookNumber, englishBookName, arabicBookID, arabicBookNumber, arabicBookName, ourBookID, status) select "nasai" as collection, neb.bookID as englishBookID, neb.bookNum as englishBookNumber, neb.bookName as englishBookName, nab.bookID as arabicBookID, nab.bookNum as arabicBookNumber, nab.bookName as arabicBookName, nab.bookID as ourBookID, bm.englishmatchstatus as status from ilmfruit_testhadithdb.nasaienglishbook as neb, ilmfruit_testhadithdb.nasaiarabicbook as nab, ilmfruit_testhadithdb.nasaibookmatch as bm where neb.bookID = bm.englishBookID and nab.bookID = bm.arabicBookID and bm.englishmatchstatus > 1;
delete from hadithdb.BookData where collection = "tirmidhi";
insert into hadithdb.BookData (collection, englishBookID, englishBookNumber, englishBookName, arabicBookID, arabicBookNumber, arabicBookName, ourBookID, status) select "tirmidhi" as collection, neb.bookID as englishBookID, neb.bookNum as englishBookNumber, neb.bookName as englishBookName, nab.bookID as arabicBookID, nab.bookNum as arabicBookNumber, nab.bookName as arabicBookName, nab.bookID as ourBookID, bm.englishmatchstatus as status from ilmfruit_testhadithdb.tirmidhienglishbook as neb, ilmfruit_testhadithdb.tirmidhiarabicbook as nab, ilmfruit_testhadithdb.tirmidhibookmatch as bm where neb.bookID = bm.englishBookID and nab.bookID = bm.arabicBookID and bm.englishmatchstatus > 1;
delete from hadithdb.BookData where collection = "shamail"; 
insert into hadithdb.BookData (collection, englishBookID, englishBookNumber, englishBookName, arabicBookID, arabicBookNumber, arabicBookName, ourBookID) select "shamail" as collection, neb.bookID as englishBookID, neb.bookNum as englishBookNumber, neb.bookName as englishBookName, nab.bookID as arabicBookID, nab.bookNum as arabicBookNumber, nab.bookName as arabicBookName, nab.bookID as ourBookID from ilmfruit_testhadithdb.shamailenglishbook as neb, ilmfruit_testhadithdb.shamailarabicbook as nab, ilmfruit_testhadithdb.shamailbookmatch as bm where neb.bookID = bm.englishBookID and nab.bookID = bm.arabicBookID and bm.englishmatchstatus > 1;
delete from hadithdb.BookData where collection = "abudawud"; 
insert into hadithdb.BookData (collection, englishBookID, englishBookNumber, englishBookName, arabicBookID, arabicBookNumber, arabicBookName, ourBookID, status) select "abudawud" as collection, neb.bookID as englishBookID, neb.bookNum as englishBookNumber, neb.bookName as englishBookName, nab.bookID as arabicBookID, nab.bookNum as arabicBookNumber, nab.bookName as arabicBookName, nab.bookID as ourBookID, bm.englishmatchstatus as status from ilmfruit_testhadithdb.abudawudenglishbook as neb, ilmfruit_testhadithdb.abudawudarabicbook as nab, ilmfruit_testhadithdb.abudawudbookmatch as bm where neb.bookID = bm.englishBookID and nab.bookID = bm.arabicBookID and bm.englishmatchstatus > 1;
delete from hadithdb.BookData where collection = "ibnmajah"; 
insert into hadithdb.BookData (collection, englishBookID, englishBookNumber, englishBookName, arabicBookID, arabicBookNumber, arabicBookName, ourBookID, status) select "ibnmajah" as collection, neb.bookID as englishBookID, neb.bookNum as englishBookNumber, neb.bookName as englishBookName, nab.bookID as arabicBookID, nab.bookNum as arabicBookNumber, nab.bookName as arabicBookName, nab.bookID as ourBookID, bm.englishmatchstatus as status from ilmfruit_testhadithdb.ibnmajahenglishbook as neb, ilmfruit_testhadithdb.ibnmajaharabicbook as nab, ilmfruit_testhadithdb.ibnmajahbookmatch as bm where neb.bookID = bm.englishBookID and nab.bookID = bm.arabicBookID and bm.englishmatchstatus > 1;
delete from hadithdb.BookData where collection = "adab";
insert into hadithdb.BookData (collection, englishBookID, englishBookNumber, englishBookName, arabicBookID, arabicBookNumber, arabicBookName, ourBookID, status) select "adab" as collection, neb.bookID as englishBookID, neb.bookNum as englishBookNumber, neb.bookName as englishBookName, nab.bookID as arabicBookID, nab.bookNum as arabicBookNumber, nab.bookName as arabicBookName, nab.bookID as ourBookID, bm.englishmatchstatus as status from ilmfruit_testhadithdb.adabenglishbook as neb, ilmfruit_testhadithdb.adabarabicbook as nab, ilmfruit_testhadithdb.adabbookmatch as bm where neb.bookID = bm.englishBookID and nab.bookID = bm.arabicBookID and bm.englishmatchstatus > 1;
delete from hadithdb.BookData where collection = "bulugh";
insert into hadithdb.BookData (collection, englishBookID, englishBookNumber, englishBookName, arabicBookID, arabicBookNumber, arabicBookName, ourBookID, status) select "bulugh" as collection, neb.bookID as englishBookID, neb.bookNum as englishBookNumber, neb.bookName as englishBookName, nab.bookID as arabicBookID, nab.bookNum as arabicBookNumber, nab.bookName as arabicBookName, nab.bookID as ourBookID, bm.englishmatchstatus as status from ilmfruit_testhadithdb.bulughenglishbook as neb, ilmfruit_testhadithdb.bulugharabicbook as nab, ilmfruit_testhadithdb.bulughbookmatch as bm where neb.bookID = bm.englishBookID and nab.bookID = bm.arabicBookID and bm.englishmatchstatus > 1;

/* When adding collections below make sure the field order in the union'ed tables is the same!!! */;
UPDATE hadithdb.BookData bd INNER JOIN (
	SELECT bm.collection, arabicBookID, indonesianBookID, bookName, bookNum, indonesianmatchstatus
	FROM (
		SELECT arabicBookID, indonesianBookID, indonesianmatchstatus,  'bukhari' AS collection FROM ilmfruit_testhadithdb.bukharibookmatch UNION 
		SELECT arabicBookID, indonesianBookID, indonesianmatchstatus,  'nasai' AS collection FROM ilmfruit_testhadithdb.nasaibookmatch UNION 
		SELECT arabicBookID, indonesianBookID, indonesianmatchstatus ,  'abudawud' AS collection FROM ilmfruit_testhadithdb.abudawudbookmatch
	) bm
	INNER JOIN (
		SELECT * ,  'bukhari' AS collection FROM ilmfruit_testhadithdb.bukhariindonesianbook UNION 
		SELECT * ,  'nasai' AS collection FROM ilmfruit_testhadithdb.nasaiindonesianbook UNION 
		SELECT * ,  'abudawud' AS collection FROM ilmfruit_testhadithdb.abudawudindonesianbook
	) ib 
ON bm.collection = ib.collection AND bm.indonesianBookID = ib.bookID
) ibook 
ON bd.collection = ibook.collection
AND ibook.arabicBookID = bd.arabicBookID
SET bd.indonesianBookID = ibook.indonesianBookID,
bd.indonesianBookName = ibook.bookName,
bd.indonesianBookNum = ibook.bookNum 
WHERE ibook.indonesianmatchstatus >1;

UPDATE hadithdb.BookData bd INNER JOIN (
	SELECT bm.collection, arabicBookID, urduBookID, bookName, bookNum, urdumatchstatus
	FROM (
		SELECT arabicBookID, urduBookID, urdumatchstatus,  'bukhari' AS collection FROM ilmfruit_testhadithdb.bukharibookmatch
	) bm
	INNER JOIN (
		SELECT *,  'bukhari' AS collection FROM ilmfruit_testhadithdb.bukhariurdubook
	) ib 
ON bm.collection = ib.collection AND bm.urduBookID = ib.bookID
) ibook 
ON bd.collection = ibook.collection
AND ibook.arabicBookID = bd.arabicBookID
SET bd.urduBookID = ibook.urduBookID,
bd.urduBookName = ibook.bookName,
bd.urduBookNum = ibook.bookNum 
WHERE ibook.urdumatchstatus >1;



delete from hadithdb.EnglishHadithTable;
insert into hadithdb.EnglishHadithTable (englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade1, comments) select  englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade, comments from ilmfruit_testhadithdb.muslim_english where bookID > 0;
insert into hadithdb.EnglishHadithTable (englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade1, comments) select englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade, comments from ilmfruit_testhadithdb.bukhari_english where bookID > 0;
insert into hadithdb.EnglishHadithTable (englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade1, comments) select englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade, comments from ilmfruit_testhadithdb.malik_english where bookID > 0;
insert into hadithdb.EnglishHadithTable (englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade1, comments) select englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade, comments from ilmfruit_testhadithdb.nawawi40_english where bookID > 0;
insert into hadithdb.EnglishHadithTable (englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade1, comments) select englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade, comments from ilmfruit_testhadithdb.tirmidhi_english where bookID in (SELECT englishBookID FROM ilmfruit_testhadithdb.tirmidhibookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1);
insert into hadithdb.EnglishHadithTable (englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade1, comments) select englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade, comments from ilmfruit_testhadithdb.riyadussaliheen_english where bookID in (SELECT englishBookID FROM ilmfruit_testhadithdb.riyadussaliheenbookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1);
insert into hadithdb.EnglishHadithTable (englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade1, comments) select englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade, comments from ilmfruit_testhadithdb.qudsi40_english where bookID in (SELECT englishBookID FROM ilmfruit_testhadithdb.qudsi40bookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1);
insert into hadithdb.EnglishHadithTable (englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade1, comments) select englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade, comments from ilmfruit_testhadithdb.nasai_english where bookID in (SELECT englishBookID FROM ilmfruit_testhadithdb.nasaibookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1);
insert into hadithdb.EnglishHadithTable (englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade1, comments) select englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade, comments from ilmfruit_testhadithdb.shamail_english where bookID in (SELECT englishBookID FROM ilmfruit_testhadithdb.shamailbookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1);
insert into hadithdb.EnglishHadithTable (englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade1, comments) select englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, albanigrade, comments from ilmfruit_testhadithdb.abudawud_english where bookID in (SELECT englishBookID FROM ilmfruit_testhadithdb.abudawudbookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1);
insert into hadithdb.EnglishHadithTable (englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade1, comments) select englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade, comments from ilmfruit_testhadithdb.ibnmajah_english where bookID in (SELECT englishBookID FROM ilmfruit_testhadithdb.ibnmajahbookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1);
insert into hadithdb.EnglishHadithTable (englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade1, comments) select englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, albanigrade, comments from ilmfruit_testhadithdb.adab_english where bookID in (SELECT englishBookID FROM ilmfruit_testhadithdb.adabbookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1);
insert into hadithdb.EnglishHadithTable (englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade1, comments) select englishURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade, comments from ilmfruit_testhadithdb.bulugh_english where bookID in (SELECT englishBookID FROM ilmfruit_testhadithdb.bulughbookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1);




delete from hadithdb.ArabicHadithTable;
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText from ilmfruit_testhadithdb.muslim_arabic where bookID in (SELECT arabicBookID FROM ilmfruit_testhadithdb.muslimbookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1 and englishmatchstatus <4);
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, fabNumber, hadithText from ilmfruit_testhadithdb.muslim_arabic where bookID in (SELECT arabicBookID FROM ilmfruit_testhadithdb.muslimbookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus = 4);
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText from ilmfruit_testhadithdb.bukhari_arabic where bookID in (SELECT arabicBookID FROM ilmfruit_testhadithdb.bukharibookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1 and englishmatchstatus <4);
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, fabNumber, hadithText from ilmfruit_testhadithdb.bukhari_arabic where bookID in (SELECT arabicBookID FROM ilmfruit_testhadithdb.bukharibookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus = 4);
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText from ilmfruit_testhadithdb.malik_arabic where bookID > 0;
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText from ilmfruit_testhadithdb.nawawi40_arabic where bookID > 0;
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText from ilmfruit_testhadithdb.tirmidhi_arabic where bookID in (SELECT arabicBookID FROM ilmfruit_testhadithdb.tirmidhibookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1 and englishmatchstatus < 4);
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, fabNumber, hadithText from ilmfruit_testhadithdb.tirmidhi_arabic where bookID in (SELECT arabicBookID FROM ilmfruit_testhadithdb.tirmidhibookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus = 4);
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText from ilmfruit_testhadithdb.riyadussaliheen_arabic where bookID in (SELECT arabicBookID FROM ilmfruit_testhadithdb.riyadussaliheenbookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1);
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText from ilmfruit_testhadithdb.qudsi40_arabic where bookID in (SELECT arabicBookID FROM ilmfruit_testhadithdb.qudsi40bookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1);
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText from ilmfruit_testhadithdb.nasai_arabic where bookID in (SELECT arabicBookID FROM ilmfruit_testhadithdb.nasaibookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1 and englishmatchstatus <4);
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, fabNumber, hadithText from ilmfruit_testhadithdb.nasai_arabic where bookID in (SELECT arabicBookID FROM ilmfruit_testhadithdb.nasaibookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus = 4);
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText from ilmfruit_testhadithdb.shamail_arabic where bookID in (SELECT arabicBookID FROM ilmfruit_testhadithdb.shamailbookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1);
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade1) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, albanigrade from ilmfruit_testhadithdb.abudawud_arabic where bookID in (SELECT arabicBookID FROM ilmfruit_testhadithdb.abudawudbookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1);
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText from ilmfruit_testhadithdb.ibnmajah_arabic where bookID in (SELECT arabicBookID FROM ilmfruit_testhadithdb.ibnmajahbookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus >1 and englishmatchstatus <4);
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, fabNumber, hadithText from ilmfruit_testhadithdb.ibnmajah_arabic where bookID in (SELECT arabicBookID FROM ilmfruit_testhadithdb.ibnmajahbookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus = 4);
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade1) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, fabNumber, hadithText, albanigrade from ilmfruit_testhadithdb.adab_arabic where bookID in (SELECT arabicBookID FROM ilmfruit_testhadithdb.adabbookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus > 1);
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, annotations) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, annotations from ilmfruit_testhadithdb.bulugh_arabic where bookID in (SELECT arabicBookID FROM ilmfruit_testhadithdb.bulughbookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus > 1 and englishmatchstatus < 4);
insert into hadithdb.ArabicHadithTable (arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, annotations) select arabicURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, fabNumber, hadithText, annotations from ilmfruit_testhadithdb.bulugh_arabic where bookID in (SELECT arabicBookID FROM ilmfruit_testhadithdb.bulughbookmatch WHERE englishmatchstatus IS NOT NULL AND englishmatchstatus = 4);


delete from hadithdb.IndonesianHadithTable;
insert into hadithdb.IndonesianHadithTable (indonesianURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade, comments) select indonesianURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade, comments from ilmfruit_testhadithdb.bukhari_indonesian where bookID in (SELECT indonesianBookID FROM ilmfruit_testhadithdb.bukharibookmatch WHERE indonesianmatchstatus IS NOT NULL AND indonesianmatchstatus > 1);
insert into hadithdb.IndonesianHadithTable (indonesianURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade, comments) select indonesianURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade, comments from ilmfruit_testhadithdb.abudawud_indonesian where bookID in (SELECT indonesianBookID FROM ilmfruit_testhadithdb.abudawudbookmatch WHERE indonesianmatchstatus IS NOT NULL AND indonesianmatchstatus > 1);
insert into hadithdb.IndonesianHadithTable (indonesianURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade, comments) select indonesianURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithText, grade, comments from ilmfruit_testhadithdb.nasai_indonesian where bookID in (SELECT indonesianBookID FROM ilmfruit_testhadithdb.nasaibookmatch WHERE indonesianmatchstatus IS NOT NULL AND indonesianmatchstatus > 1);

delete from hadithdb.UrduHadithTable;
insert into hadithdb.UrduHadithTable (urduURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithSanad, hadithText, grade, comments) select urduURN, collection, volumeNumber, bookID, bookNumber, bookName, babNumber, babName, hadithNumber, hadithSanad, hadithText, grade, comments from ilmfruit_testhadithdb.bukhari_urdu where bookID in (SELECT urduBookID FROM ilmfruit_testhadithdb.bukharibookmatch WHERE urdumatchstatus IS NOT NULL AND urdumatchstatus > 1);


delete from hadithdb.matchtable;
insert into hadithdb.matchtable (arabicURN, englishURN, ourHadithNumber) select arabicURN, englishURN, ourHadithNumber from ilmfruit_testhadithdb.englishmatchtable;
update hadithdb.matchtable mt inner join ilmfruit_testhadithdb.indonesianmatchtable imt on mt.arabicURN = imt.arabicURN set mt.indonesianURN = imt.indonesianURN;
update hadithdb.matchtable mt inner join ilmfruit_testhadithdb.urdumatchtable umt on mt.arabicURN = umt.arabicURN set mt.urduURN = umt.urduURN;


delete from hadithdb.ChapterData;
insert into hadithdb.ChapterData (collection, englishBookID, arabicBookID, babID, arabicBabNumber, arabicBabName, arabicIntro) select ac.collection as collection, bd.englishBookID as englishBookID, bd.arabicBookID as arabicBookID, ac.babID as babID, ac.babNumber as arabicBabNumber, ac.babName, ac.intro as arabicIntro from hadithdb.BookData as bd, ilmfruit_testhadithdb.arabicChapters as ac where ac.collection = bd.collection and ac.bookID = bd.arabicBookID and bd.status > 3;
update hadithdb.ChapterData 
inner join (
  select collection, bookiD, babID, babNumber, babName, intro from ilmfruit_testhadithdb.englishChapters
) as myt
set hadithdb.ChapterData.englishBabNumber = myt.babNumber, hadithdb.ChapterData.englishBabName = myt.babName, hadithdb.ChapterData.englishIntro = myt.intro
where myt.babID = hadithdb.ChapterData.babID and myt.collection =  hadithdb.ChapterData.collection and myt.bookID = hadithdb.ChapterData.englishBookID;

update hadithdb.EnglishHadithTable eht join hadithdb.matchtable m on eht.englishURN = m.englishURN
set eht.ourHadithNumber = m.ourHadithNumber, eht.matchingArabicURN = m.arabicURN;
update hadithdb.IndonesianHadithTable iht join hadithdb.matchtable m on iht.indonesianURN = m.indonesianURN
set iht.ourHadithNumber = m.ourHadithNumber, iht.matchingArabicURN = m.arabicURN;
update hadithdb.UrduHadithTable uht join hadithdb.matchtable m on uht.urduURN = m.urduURN
set uht.ourHadithNumber = m.ourHadithNumber, uht.matchingArabicURN = m.arabicURN;
update hadithdb.ArabicHadithTable aht join hadithdb.matchtable m on aht.arabicURN = m.arabicURN
set aht.ourHadithNumber = m.ourHadithNumber, aht.matchingEnglishURN = m.englishURN;




delete from HadithTable;
insert into HadithTable (collection, arabicURN, englishURN, arabicText, hadithNumber, ourHadithNumber, babNumber, bookID, englishText, arabicBabName, englishBabName)
select aht.collection, aht.arabicURN, aht.matchingEnglishURN, aht.hadithText, aht.hadithNumber, aht.ourHadithNumber, aht.babNumber, bd.ourBookID, eht.hadithText, cd.arabicBabName, englishBabName
from ArabicHadithTable as aht 
	left outer join BookData as bd on aht.collection = bd.collection and aht.bookID = bd.arabicBookID
	left outer join ChapterData as cd on aht.collection = cd.collection and aht.bookID = cd.arabicBookID and aht.babNumber = cd.babID
	left outer join EnglishHadithTable as eht on aht.matchingEnglishURN = eht.englishURN
where bd.status = 4;
update HadithTable set bookID = '35b' where collection = 'nasai' and bookID = '-35';
update HadithTable set bookID = 'introduction' where bookID = '-1';


/* Update first and last hadith numbers in BookData for verified books*/;
UPDATE BookData AS bd JOIN (
  SELECT collection, bookID, COUNT( * ) AS numHadith, MIN( CAST( hadithNumber AS signed ) ) AS beginNumber, MAX( CAST( hadithNumber AS signed ) ) AS endNumber
  FROM HadithTable
  GROUP BY collection, bookID
) AS ht ON bd.collection = ht.collection
AND bd.ourBookID = ht.bookID
SET bd.firstNumber = ht.beginNumber,
bd.lastNumber = ht.endNumber,
bd.totalNumber = ht.numHadith WHERE bd.status =4;