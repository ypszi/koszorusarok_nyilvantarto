<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<link href="js/colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" media="all"/>
	<script type="text/javascript" src="js/colorpicker/js/colorpicker.js"></script>
<style type="text/css">
#usermod_table {
	width: 300px;
}

#usermod_table td {
	border: 0px;
	padding: 5px;
}

#usermod_table input[type="text"] {
	padding: 2px;
}
</style>

<div id="exit" class="exit" onclick="document.getElementById('user_popup').style.display= 'none';" style="display: block;">
X
</div>

<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Alkalmazott módosítása</p>

<form id='userform' method='POST' action='menu-main/menu-setting-submenu/employees/usermod.php' enctype="multipart/form-data">
<table id="usermod_table">
	<tr>
		<td> <input type='hidden' value='<?php echo $_POST['userid']; ?>' name='userid' ></td>
		<td> <input type='hidden' value='<?php echo $_POST['picture']; ?>' name='picture' ></td>
	</tr>

	<tr>
	<td> <input type='text' class='borderedStyle inputStyle' value='<?php echo $_POST['username']; ?>' placeholder='név' name='username' style='width: 100%;'></td>
	<td> <input type='text' class='borderedStyle inputStyle' value='<?php echo $_POST['print_name']; ?>' placeholder='nyomtatási név' name='print_name' style='width: 100%;'></td>
	<td> <input type='file' class='inputStyle' v name='user_img[]' style='width: 100%;'></td>
</tr>
<tr>
	<td> <input type='text' class='borderedStyle inputStyle' value='<?php echo $_POST['title']; ?>' placeholder='beosztás' name='title' style='width: 100%;'></td>
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
		<input type='text' id="colorSelector" class='inputStyle' value='<?php echo $_POST['color']; ?>' placeholder='szín' name='color' style='width: 100%; height: 30px;'>
	</td>
</tr>
<tr>

	<td> <input type='text' class='borderedStyle inputStyle' value='<?php echo $_POST['salary']; ?>' placeholder='fizetés' name='salary' style='width: 100%;'></td>
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
								if ($_POST['shop'] == $shopid) {
									echo "<option value='$shopid' selected >$shopname</option>";
								} else {
									echo "<option value='$shopid' >$shopname</option>";
								}
							}
						?>
		</select>
	</td>
</tr>
<tr>
	<td> <input type='text' class='borderedStyle inputStyle' value='<?php echo $_POST['access_level']; ?>' placeholder='hozzáférési szint' name='access_level' style='width: 100%;'></td>
	<td> 
		<select name='enable' style='width: 100%;'>
			<option disabled selected>Válasszon engedélyezettséget</option>
			<?php 
				if ($_POST['enable'] == 0) {
			?>
				<option value="0" selected>0 - nem engedélyezett</option>
				<option value="1">1 - engedélyezett</option>
			<?php 
				} else {
		 	?>
				<option value="0" >0 - nem engedélyezett</option>
				<option value="1" selected>1 - engedélyezett</option>
			<?php 
				}
			?>
		</select>
	</td>
</tr>

	<tr><td> <input type='submit' value='Módosít' class='button' ></td></tr>
</table>
</form>