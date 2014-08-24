<style type="text/css">
#citationmod_table {
	width: 300px;
}

#citationmod_table td {
	border: 0px;
	padding: 5px;
}

#citationmod_table input[type="text"] {
	padding: 2px;
}
</style>

<div id="exit" class="exit" onclick="document.getElementById('citation_popup').style.display= 'none';" style="display: block;">
X
</div>

<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Idézet módosítása</p>

<form id='citationform' method='POST' action='menu-main/menu-setting-submenu/citation/citationmod.php'>
<table id="citationmod_table">
<tr><td> <input type='hidden' value="<?php echo $_POST['citid']; ?>" name='citid' ></td></tr>
<tr><td> <input type='text' class='borderedStyle inputStyle' placeholder='idézet' value="<?php echo $_POST['cittext']; ?>" name='cittext' style='width: 100%;'></td></tr>
<tr><td> <input type='submit' value='Módosít' class='button' ></td></tr>
</table>
</form>