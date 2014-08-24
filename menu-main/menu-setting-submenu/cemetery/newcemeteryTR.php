<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<link href="js/colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" media="all"/>
	<script type="text/javascript" src="js/colorpicker/js/colorpicker.js"></script>
<style type="text/css">
#cemetery_table {
	width: 300px;
}

#cemetery_table td {
	border: 0px;
	padding: 5px;
}

#cemetery_table input[type="text"] {
	padding: 2px;
}
</style>

<div id="exit" class="exit" onclick="document.getElementById('cemetery_popup').style.display= 'none';" style="display: block;">
X
</div>

<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Új temető hozzáadása</p>


	<form id='cemeteryeditform' method='POST' action='menu-main/menu-setting-submenu/cemetery/newcemetery.php' enctype="multipart/form-data">
<table id="cemetery_table">
	<tr>
		<td> <input type='text' class='borderedStyle inputStyle' placeholder='név (pl: Újköztemető)' name='cemeteryname' style='width: 100%;'></td>
	</tr>
	<tr>
		<td> <input type='text' class='borderedStyle inputStyle' placeholder='cím (pl: 1108 Budapest, Kozma utca 8-10)' name='cemeteryaddress' style='width: 100%;'></td>
	</tr>
	<tr><td> <input type='submit' value='Hozzáad' class='button' ></td></tr>	
</table>
</form>