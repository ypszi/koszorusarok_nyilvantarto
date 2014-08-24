<style type="text/css">
#floweredit_table {
	width: 300px;
}

#floweredit_table td {
	border: 0px;
	padding: 5px;
}

#floweredit_table input[type="text"] {
	padding: 2px;
}
</style>

<div id="exit" class="exit" onclick="document.getElementById('floweredit_popup').style.display= 'none';" style="display: block;">
X
</div>

<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Új koszorú alap készítése</p>

<form id='flowereditform' method='POST' action="menu-main/menu-setting-submenu/flower/flowermod.php" >
	<table id="floweredit_table">
	<tr><td> <input type='hidden' value="<?php echo $_POST['flowerid']; ?>" class='borderedStyle inputStyle' name='flowerid'></td></tr>
	<tr><td>Virág neve: </td><td> <input type='text' value="<?php echo $_POST['flowertype']; ?>" class='borderedStyle inputStyle' style="width: 100%;" placeholder='név' name='flowertype'></td></tr>
	<tr><td>Virág szín: </td><td> <input type='text' value="<?php echo $_POST['flowercolor']; ?>" class='borderedStyle inputStyle' style="width: 100%;" placeholder='szin' name='flowercolor'></td></tr>
	<tr><td>Virág ár: </td><td> <input type='text' value="<?php echo $_POST['flowerprice']; ?>" class='borderedStyle inputStyle' style="width: 100%;" placeholder='ár' name='flowerprice'></td></tr>
	<tr><td> <input type='submit' value='Módosít' class='button' ></td></tr>
</table>
</form>