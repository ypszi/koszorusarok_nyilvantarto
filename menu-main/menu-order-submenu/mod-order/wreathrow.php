<?php 
	include '../../../config.php';
	if (isset($_GET['wreathnum'])) $wreathnum = $_GET['wreathnum']; else $wreathnum = 1;
?>
<td colspan="3" class="border_top">
<table class="order_data" id="wreathtable<?php echo $wreathnum; ?>">
	<tr>
		<td>
			Koszorú típus:
		</td>
		<td>
			<select id="wreath_type<?php echo $wreathnum; ?>" name="wreath_type<?php echo $wreathnum; ?>" onChange="loadCatalogWreathNames(this.id, 'wreath<?php echo $wreathnum; ?>');">
				<option disabled value="" selected>Válasszon koszorút típust!</option>
				<?php 
					$query = "SELECT type FROM  `base_wreath_type` ORDER BY type";
					$result = mysql_query($query) or die (mysql_error());
				
					while ($row = mysql_fetch_assoc($result)) {
						$wreath_type = $row['type'];
						echo "<option value=\"$wreath_type\" >$wreath_type</option>";
					}
				?>
			 </select>
		</td>
		<td rowspan="7">
			<img id="wreath_preview<?php echo $wreathnum; ?>" name="wreath_preview<?php echo $wreathnum; ?>" style='width: 165px;'>
			<input type='hidden' id='wreath_preview_src<?php echo $wreathnum; ?>' name='wreath_preview_src<?php echo $wreathnum; ?>' value=''>
		</td>
	</tr>
	<tr>
		<td>
			Koszorú:
		</td>
		<td>
			<select id="wreath<?php echo $wreathnum; ?>" name="wreath<?php echo $wreathnum; ?>" onChange="loadWreathimg(this, <?php echo $wreathnum; ?>);" disabled>
				<option disabled value="" selected>Válasszon koszorút!</option>
				<?php 
					$query = "SELECT name FROM  `special_wreath`";
					$result = mysql_query($query) or die (mysql_error());
				
					while ($row = mysql_fetch_assoc($result)) {
						$wreath = $row['name'];
						echo "<option value=\"$wreath\" >$wreath</option>";
					}
				?>
			 </select>
		</td>
	</tr>
	<tr>
		<td>
			Azonosító: 
		</td>
		<td>
			<input type="text" id="azonosito<?php echo $wreathnum; ?>" name="azonosito<?php echo $wreathnum; ?>" placeholder="Azonosító">
		</td>
	</tr>
	<tr>
		<td>Kér szalagot</td>
		<td> 
			<input type="checkbox" name="isRibbon<?php echo $wreathnum; ?>" id="isRibbon<?php echo $wreathnum; ?>" onChange="ribbonEnable(this.id);">
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<select id="ribbon<?php echo $wreathnum; ?>" name="ribbon<?php echo $wreathnum; ?>" disabled>
					<option disabled selected>Válasszi ki a szalag szinét és típusát</option>";
				<?php
					$query = "SELECT * FROM  `ribbon_type`";
					$result = mysql_query($query) or die(mysql_error());

					while ($row = mysql_fetch_assoc($result)) {
						$type = $row['type'];
						$note = $row['note'];
						echo "<option>$type</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<select id="ribboncolor<?php echo $wreathnum; ?>" name="ribboncolor<?php echo $wreathnum; ?>" disabled>
				<option disabled selected>Válassza ki a szalag színét</option>
			<?php
				$query = "SELECT color FROM  `ribbon_color`";
				$result = mysql_query($query) or die(mysql_error());

				while ($row = mysql_fetch_assoc($result)) {
					$color = $row['color'];
					echo "<option>$color</option>";
				}
			?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<select id="farewelltext<?php echo $wreathnum; ?>" name="farewelltext<?php echo $wreathnum; ?>" disabled>
				<option disabled value="" selected>Válasszi ki a búcsúszöveget</option>
				<?php
					include 'farewelltext.php';
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Akik adják:</td>
		<td>
			<textarea style="resize: vertical;" cols="50" rows="5" id="givers<?php echo $wreathnum; ?>" name="givers<?php echo $wreathnum; ?>" placeholder="Akik adják"></textarea>
		</td>
		<td>
			<input type="button" value="Sor törlése" class="minus" onClick="del_WreathRow_modder(<?php echo $wreathnum; ?>);" style="margin-top: 30px; width: 165px;">
			<input type="button" value="Új sor hozzáadása" class="plus" onClick="addWreath_modder();" style="margin-top: 10px; width: 165px;">
		</td>
	</tr>
</table>
</td>