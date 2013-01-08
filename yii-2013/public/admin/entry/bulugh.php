<?php

include "processpost.php";
if (isset($_POST['submit'])) {
	$success = processPost("bulugh");
}
?>

<html>
<head>
<title>Hadith Entry Page for Bulugh al-Mar'am</title>
</head>

<body onload="document.hform.hadithnumber.focus();">

<div style="margin: auto; width: 80%;">

<h1>Bulugh al-Mar'am</h1>

<p align=center>
<font color="#02AB24">
<?php
	if (isset($_POST['submit'])) {
		if ($success == 1) echo "Hadith saved successfully, alhamdulillah";
		else echo "There was a problem saving the hadith :(";
	}
?>
</font>
</p>

<form name="hform" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

<table border=0 width="100%" cellpadding="2" cellspacing="1" bgcolor="#eeeeee">
	<tr>
		<td><b>Book</b></td>
		<td width="20%">
			<?php
				echo '<label for="booknumber">Number: </label>';
				echo '<input type="text" size="4" name="booknumber" ';
				if (isset($_POST['booknumber'])) echo 'value="'.$_POST['booknumber'].'"';
				echo '>';
			?>
		</td>
		<td><b>Chapter</b></td>
		<td width="20%">
			<?php
				echo '<label for="chapternumber">Number: </label>';
				echo '<input type="text" size="4" name="chapternumber" ';
				if (isset($_POST['chapternumber'])) echo 'value="'.$_POST['chapternumber'].'"';
				echo '>';
			?>
		</td>
		<td>
			<?php
				echo '<label for="chaptername">Name: </label>';
				echo '<input type="text" size="40" name="chaptername" ';
				if (isset($_POST['chaptername'])) echo 'value="'.$_POST['chaptername'].'"';
				echo '>';
			?>
		</td>
	</tr>
</table>

<br>

<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr>
<td width="10%" align="center" bgcolor="#eeeeee"><strong>Hadith No.</strong></td>
<td bgcolor="#eeeeee">&nbsp;</td>
<td width="90%" bgcolor="#eeeeee"><strong>Hadith Text</strong></td>
</tr>

<tr><td align="center" bgcolor="#eeeeee"><input type="text" size="10" name="hadithnumber[]"></td><td>&nbsp;</td><td><textarea name="hadithtext[]" rows="3" style="width:90%"></textarea></td></tr>

<tr><td align="center" bgcolor="#eeeeee"><input type="text" size="10" name="hadithnumber[]"></td><td>&nbsp;</td><td><textarea name="hadithtext[]" rows="3" style="width:90%"></textarea></td></tr>

<tr><td align="center" bgcolor="#eeeeee"><input type="text" size="10" name="hadithnumber[]"></td><td>&nbsp;</td><td><textarea name="hadithtext[]" rows="3" style="width:90%"></textarea></td></tr>

<tr><td align="center" bgcolor="#eeeeee"><input type="text" size="10" name="hadithnumber[]"></td><td>&nbsp;</td><td><textarea name="hadithtext[]" rows="3" style="width:90%"></textarea></td></tr>

<tr><td align="center" bgcolor="#eeeeee"><input type="text" size="10" name="hadithnumber[]"></td><td>&nbsp;</td><td><textarea name="hadithtext[]" rows="3" style="width:90%"></textarea></td></tr>

<tr><td align="center" bgcolor="#eeeeee"><input type="text" size="10" name="hadithnumber[]"></td><td>&nbsp;</td><td><textarea name="hadithtext[]" rows="3" style="width:90%"></textarea></td></tr>

<tr><td align="center" bgcolor="#eeeeee"><input type="text" size="10" name="hadithnumber[]"></td><td>&nbsp;</td><td><textarea name="hadithtext[]" rows="3" style="width:90%"></textarea></td></tr>

<tr><td align="center" bgcolor="#eeeeee"><input type="text" size="10" name="hadithnumber[]"></td><td>&nbsp;</td><td><textarea name="hadithtext[]" rows="3" style="width:90%"></textarea></td></tr>

<tr><td align="center" bgcolor="#eeeeee"><input type="text" size="10" name="hadithnumber[]"></td><td>&nbsp;</td><td><textarea name="hadithtext[]" rows="3" style="width:90%"></textarea></td></tr>

<tr><td align="center" bgcolor="#eeeeee"><input type="text" size="10" name="hadithnumber[]"></td><td>&nbsp;</td><td><textarea name="hadithtext[]" rows="3" style="width:90%"></textarea></td></tr>

</table>
<p>
 <input type="submit" name="submit" value="Save &amp; Continue">
</p>



</form>
</div>

<?php 
include "footer.php";
?>
</body>
</html>
