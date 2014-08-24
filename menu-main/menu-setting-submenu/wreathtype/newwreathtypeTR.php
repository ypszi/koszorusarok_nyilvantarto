<style type="text/css">
#wbaseedit {
	width: 300px;
}

#wbaseedit td {
	border: 0px;
	padding: 5px;
}

#wbaseedit input[type="text"] {
	padding: 2px;
}
</style>

<div id="exit" class="exit" onclick="document.getElementById('wreathtype_popup').style.display= 'none';" style="display: block;">
X
</div>

<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Új koszorú alap létrehozása</p>

<form id='wbeditform' method='POST' action="menu-main/menu-setting-submenu/wreathtype/newwreathtype.php" >
	<table id="wbaseedit">
	<tr><td> <select style="width: 100%;" name='wreathbtype'>
		<option disabled>Válasszon koszorú alapot</option>
		<?php 
			include '../../../config.php';
			$query = "SELECT id,type FROM `base_wreath_type` ORDER BY type ASC;";
			$result = mysql_query($query) or die (mysql_error());
		
			while ($row = mysql_fetch_assoc($result)) {
				$base_wreath_type = $row['type'];
				echo "<option value='".$row['id']."'>$base_wreath_type</option>";
			}
		 ?>
	</select></td></tr>
	<tr><td> <input type='text' class="borderedStyle inputStyle" style="width: 100%;" placeholder='méret' name='wreathbsize'></td></tr>
	<tr><td> <input type='text' class="borderedStyle inputStyle" style="width: 100%;" placeholder='minimum virágszám' name='wreathbfmin'></td></tr>
	<tr><td> <input type='text' class="borderedStyle inputStyle" style="width: 100%;" placeholder='maximum virágszám' name='wreathbfmax'></td></tr>
	<tr><td> <input type='text' class="borderedStyle inputStyle" style="width: 100%;" placeholder='ár' name='wreathbprice'></td></tr>
	<tr><td> <input type='submit' value='Hozzáad' class='button' ></td></tr>
</table>
</form>