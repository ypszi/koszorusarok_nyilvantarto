<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<link href="js/colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" media="all"/>
	<script type="text/javascript" src="js/colorpicker/js/colorpicker.js"></script>
<style type="text/css">
#user_table {
	width: 300px;
}

#user_table td {
	border: 0px;
	padding: 5px;
}

#user_table input[type="text"] {
	padding: 2px;
}
</style>

<div id="exit" class="exit" onclick="document.getElementById('user_popup').style.display= 'none';" style="display: block;">
X
</div>

<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Új alkalmazott hozzáadása</p>


	<form id='usereditform' method='POST' action='menu-main/menu-setting-submenu/employees/newuser.php' enctype="multipart/form-data">
<table id="user_table">
	<tr>
		<td> <input type='text' class='borderedStyle inputStyle' placeholder='név' name='username' style='width: 100%;'></td>
		<td> <input type='text' class='borderedStyle inputStyle' placeholder='nyomtatási név' name='print_name' style='width: 100%;'></td>
		<td> <input type='file' class='inputStyle' name='user_img[]' style='width: 100%;'></td>
	</tr>
	<tr>
		<td> <input type='text' class='borderedStyle inputStyle' placeholder='beosztás' name='title' style='width: 100%;'></td>
		<td> 
			<script type="text/javascript">
			$('#colorSelector').ColorPicker({
				color: '#0000ff',
				onShow: function (colpkr) {
					$(colpkr).fadeIn(500);
					$(colpkr).css( "zIndex", 6 );
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onSubmit: function (hsb, hex, rgb) {
					$('#colorSelector').css('backgroundColor', '#' + hex);
					$('#colorSelector').val(hex);
				}
			});
			</script>
			<input type='text' id="colorSelector" class='inputStyle' placeholder='szín' name='color' style='width: 100%; height: 30px;'>
		</td>
	</tr>
	<tr>

		<td> <input type='text' class='borderedStyle inputStyle' placeholder='fizetés' name='salary' style='width: 100%;'></td>
		<td> 
			<select name='shop' style='width: 100%;'>
				<option disabled selected>Válasszon Boltot!</option>
							<?php 
							include '../../../config.php';
								$query = "SELECT id, name FROM `shops` WHERE enable = 1";
								$result = mysql_query($query) or die(mysql_error());

								while ($row = mysql_fetch_assoc($result)) {
									$shopid = $row['id'];
									$shopname = $row['name'];
									echo "<option value='$shopid' >$shopname</option>";
								}
							?>
			</select>
		</td>
	</tr>
	<tr>
		<td> <input type='text' class='borderedStyle inputStyle' placeholder='hozzáférési szint' name='access_level' style='width: 100%;'></td>
		<td> <select name='enable' style='width: 100%;'>
			<option disabled selected>Válasszon engedélyezettséget</option>
			<option value="0">0 - nem engedélyezett</option>
			<option value="1">1 - engedélyezett</option>
		</select></td>
	</tr>
	<tr><td> <input type='submit' value='Hozzáad' class='button' ></td></tr>
	
</table>
</form>