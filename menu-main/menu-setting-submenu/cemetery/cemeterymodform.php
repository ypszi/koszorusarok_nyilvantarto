<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<link href="js/colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" media="all"/>
	<script type="text/javascript" src="js/colorpicker/js/colorpicker.js"></script>
<style type="text/css">
#cemeterymod_table {
	width: 300px;
}

#cemeterymod_table td {
	border: 0px;
	padding: 5px;
}

#cemeterymod_table input[type="text"] {
	padding: 2px;
}
</style>

<div id="exit" class="exit" onclick="document.getElementById('cemetery_popup').style.display= 'none';" style="display: block;">
X
</div>

<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Alkalmazott módosítása</p>

<form id='cemeteryform' method='POST' action='menu-main/menu-setting-submenu/cemetery/cemeterymod.php' enctype="multipart/form-data">
	<table id="cemeterymod_table">
		<tr>
			<td> <input type='hidden' value='<?php echo $_POST['id']; ?>' name='cemeteryid' ></td>
		</tr>

		<tr>
			<td> <input type='text' class='borderedStyle inputStyle' value='<?php echo $_POST['name']; ?>' placeholder='Temető neve' name='cemeteryname' style='width: 100%;'></td>
		</tr>
		<tr>
			<td> <input type='text' class='borderedStyle inputStyle' value='<?php echo $_POST['address']; ?>' placeholder='Temető cím név' name='cemeteryaddress' style='width: 100%;'></td>
		</tr>
		<tr>
			<td> <input type='submit' value='Módosít' class='button' ></td>
		</tr>
	</table>
</form>