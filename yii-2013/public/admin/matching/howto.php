<?php
session_start();
$page_title = "Howto Page";
include "setlang.php";
include "adminheader.php";

include "util.php";


?>

    <table width=75% align="center" cellpadding="0" cellspacing="0">
		<tr><td colspan=2>
			  <table width="75%" cellpadding=3 cellspacing="1" border=0 align="center">
			  <tr border=0><td colspan=2 border=0>

<p style="text-align: justify;">
<b>How do I begin?</b><br>
First get yourself a login <a href="/admin/registerh.php">here</a><br>
Then login <a href="/admin">here</a><br>
Click on "Bukhari" in the horizontal menu at the top.<br>
Click on some book and browse through it (but don't move anything!).
</p>

<p style="text-align: justify;">
<b>Terminology</b><br>
When I say "match" or "align" a pair of hadith, I mean two boxes next to each other horizontally contain ahadith that correspond to each other.
</p>

<p style="text-align: justify;"><b>What are "Move up" and "Move down"?</b><br>
As noted on the <a href="admin/about.php">About</a> page, the ahadith are aligned in chunks so these operations form the core of what is needed to align all the ahadith. By clicking Move Down on a hadith, you move it and everything below it down by one, while the other column remains the same. Same with Move Up, except that Move Up only works if there is a blank cell immediately above the hadith it's clicked on. Each move is immediately committed to the database. 
Book 1 is a toy example - the changes made to Book 1 are not committed to the database. Feel free to play around with these functions in Book 1 to get a sense of what they do.
<br>
</p>

<p style="text-align: justify;">
<b>How do you decide to match?</b><br>
Most of the time, the following steps suffice:<br>
- reading past the sanad in Arabic to the actual narrator and comparing him/her to the narrator mentioned in the English version<br>
- comparing a few words near the beginning and end of both versions <br>
- picking out a few keywords in the middle and comparing them.<br>
<br>
Typically this decision shouldn't take more than a minute per hadith at the beginning. As you match more hadith this time
goes down to about 15-20 seconds at most.<br>
<br></p>

<p style="text-align: justify;">
<b>What do I do when two hadith next to each other don't match?</b><br>
Look at the ones above and below. Chances are the one hadith down
in one language will match the one you were looking at. Use the Move Up
and Move Down functions to align the ones that do match. Doing this
will usually also cause a good number of ahadith following them to be
matched.<br><br>

If you can't find a match for a hadith, just leave a blank spot next to it
and move on with those that do match.
<br></p>

<p style="text-align: justify;"><b>Walk through an example: Book 1</b><br>
Point your browser to Book 1 of Sahih Bukhari by going 
<a href="/admin/matching/matchBooks_c.php?coll=bukhari&ebooknum=1">here</a>
<br>

Notice that the first placeholder on the English side is blank. But that the hadith in the cell below is the famous "inna ma al-a'maalu bi al-niyyaat ... " hadith, which matches the first Arabic hadith on the right. So click on "Move up" on English hadith number 1. This will move it and everything below it up one level. That move aligns the first two hadith on both sides.

<br><br>
Next note that hadith 3 on both sides appears to be the same, but there's some extra text at the bottom of the English one corresponding to the 4th Arabic hadith. Let's ignore that for now, but it will mean that hadith 4 on the Arabic side will remain unmatched. 

<br><br>
Now we read further and note that hadith 4 in English matches hadith 5 in Arabic, and 5 English matches 6 Arabic so we click "Move Down" on hadith 4 on the English side. This moves matches hadiths 4 and 5.
<br><br>

Next we see that the long Heracles hadith in English is matched to a blank spot, but then the Arabic hadith below that is also the Heracles one so we click "Move Up" on the Arabic hadith 7 to match those two.
<br><br>

At this point this is the best we can do, so click on "Check Book 1 matching" at the top or bottom. This should print a message at the top saying your alignment is correct.
<br><br>

Book 1 is an artificially constructed example of a really horrible matching - most of the others aren't this bad.
If this were a real matching scenario instead of an example one, I would also "split" the English hadith 3 and match it appropriately.

<br><br>
</p>

<p style="text-align: justify;"><b>Begin matching a book</b><br>
Click on a book on the main collection page (Bukhari for now) to browse it.<br>
If you'd like to begin matching the ahadith contained in that book, first click on "Initialize matching." This will enter the pairs shown on the page into the database and will mark you as the user working on that book. Once that is done, use the operations provided to match each English text with its corresponding Arabic one and vice versa to the best of your ability. If you're unsure about a particular hadith, simply match it to a blank space and move on. Clicking on "move down" creates a blank space and clicking on "Move up" fills up a blank space if one exists. 
Feel free to play around with these functions in Book 1 until you get a feel for them. 
If you spot a spelling mistake or minor error in a hadith, click on the "Modify" link and correct the error. If somehow two ahadith appear to be combined into one (because you see for example that there are two distinct ahadith in the other language) then click on the "Split" link.
<br>
<br>
If you can't find a match for a hadith, move things appropriately up and down so as to match it to a blank space and move on with the rest. Don't worry about that one - we can deal with it later.
<br>

<br>
You can spread out your matching activities over several sessions. When done with an entire book, click on "Mark book as matched."
</p>

<p style="text-align: justify;"><b>What does splitting do?</b><br>
Clicking on "Split" by a hadith makes two ahadith out of the original entry. Just follow the instructions on the page. 
<br>

<p style="text-align: justify;"><b>What is the Manual Match page?</b><br>
<br>

<p style="text-align: justify;"><b>What is the Merge Hadith page?</b><br>
<br>

</p>
<p style="text-align: justify;"><b>What if by moving down everything below it gets unmatched?</b><br>
In this case, move the other column down as well from a later point so as to preserve the matchings.
</p>

<p style="text-align: justify;"><b>Misc:</b><br>
- You can align however many or however few you like during each session, and come back to them whenever you like next.<br>
- The English chapter names for Sahih Bukhari are blank for now. Ignore those.<br>
- Only the Arabic ahadith have the full sanad. The English ones only have the narrator at the top.<br>
- Be careful with the move and change options. Some changes can be very hard to undo (especially the Split function)<br>
- Leaving unmatched ahadith is perfectly alright.<br>
</p>

<p style="text-align: justify;">
<b>The website is "live" right now, and any changes are committed to the database. Please be very careful with your commits.</b>


I will be making nightly backups of the matched ahadith inshaAllah.


Let me know of any questions inshaAllah. Email sunnahhadith@gmail.com


			  </td></tr>
			 <tr height=15></tr>
			  </table>
		</td></tr>
	 </table>

<?php


include "footer.php";

?>


