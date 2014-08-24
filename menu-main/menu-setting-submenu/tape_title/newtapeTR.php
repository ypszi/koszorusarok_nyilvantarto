<style type="text/css">
#tapetitle_table {
	width: 300px;
}

#tapetitle_table td {
	border: 0px;
	padding: 5px;
}

#tapetitle_table input[type="text"] {
	padding: 2px;
}
</style>

<div id="exit" class="exit" onclick="document.getElementById('tapetitle_popup').style.display= 'none';" style="display: block;">
X
</div>

<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Új szalag felirat létrehozása</p>

<form id='tapeform' method='POST' action='menu-main/menu-setting-submenu/tape_title/newtape.php'>
<table id="tapetitle_table">
<tr><td> <input type='text' class='borderedStyle inputStyle' placeholder='szalag felirat' name='tapetext' style='width: 100%;'> </td></tr>
<tr><td> <input type='submit' value='Hozzáadom' class='button' ></td></tr>
</table>
</form>