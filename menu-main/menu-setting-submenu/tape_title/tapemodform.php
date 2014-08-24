<style type="text/css">
#tapetitlemod_table {
	width: 300px;
}

#tapetitlemod_table td {
	border: 0px;
	padding: 5px;
}

#tapetitlemod_table input[type="text"] {
	padding: 2px;
}
</style>

<div id="exit" class="exit" onclick="document.getElementById('tapetitle_popup').style.display= 'none';" style="display: block;">
X
</div>

<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Szalag felirat módosítása</p>

<form id='tapeform' method='POST' action='menu-main/menu-setting-submenu/tape_title/tapemod.php'>
<table id="tapetitlemod_table">
<tr><td> <input type='hidden' class='inputStyle' value='<?php echo $_POST['tapeid']; ?>' name='tapeid' ></td></tr>
<tr><td> <input type='text' class='borderedStyle inputStyle' placeholder='szalag felirat' value='<?php echo $_POST['tapetext']; ?>' name='tapetext' style='width: 100%;'> </td></tr>
<tr><td> <input type='submit' value='Módosít' class='button' ></td></tr>
</table>
</form>