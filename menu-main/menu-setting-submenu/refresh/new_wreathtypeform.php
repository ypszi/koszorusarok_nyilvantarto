<style type="text/css">
#new_wreathtype_table {
	width: 300px;
}

#new_wreathtype_table td {
	border: 0px;
	padding: 5px;
}

#new_wreathtype_table input[type="text"] {
	padding: 2px;
}
</style>

<div id="exit" class="exit" onclick="document.getElementById('wreathtype_popup').style.display= 'none';" style="display: block;">
X
</div>

<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Új virág létrehozás</p>

<form id='wreathtypeform' method='POST' action="menu-main/menu-setting-submenu/refresh/new_wreathtype.php" >
	<table id="new_wreathtype_table">
	<tr><td> <input type='text' class='borderedStyle inputStyle' style="width: 100%;" placeholder='Koszorú típus' name='wreath_type'></td></tr>
	<tr><td> <input type='submit' value='Hozzáad' class='button' ></td></tr>
</table>
</form>
