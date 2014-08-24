<style type="text/css">
#citation_table {
	width: 300px;
}

#citation_table td {
	border: 0px;
	padding: 5px;
}

#citation_table input[type="text"] {
	padding: 2px;
}
</style>

<div id="exit" class="exit" onclick="document.getElementById('citation_popup').style.display= 'none';" style="display: block;">
X
</div>

<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Új idézet létrehozása</p>

<form id='citationform' method='POST' action='menu-main/menu-setting-submenu/citation/newcitation.php'>
<table id="citation_table">
<tr><td> <input type='text' class='borderedStyle inputStyle' placeholder='idézet' name='cittext' style='width: 100%;'></td></tr>
<tr><td> <input type='submit' value='Hozzáadom' class='button' ></td></tr>
</table>
</form>