<?php 
	session_start();
	include '../../../config.php';
?>
<td colspan="4">
<table id="ord_wreath" style="float: left;">
	<tr>
		<td>
			<?php 
			if (isset($_GET['wreathnum'])) $wreathnum = $_GET['wreathnum']; else $wreathnum = 1;

			echo "<select id=\"wreath_type$wreathnum\" name=\"wreath_type$wreathnum\" onChange=\"loadCatalogWreathNames(this.id, 'wreath$wreathnum');\">";
			?>
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
	</tr>
	<tr>
		<td>
			<?php
			echo "<select id=\"wreath$wreathnum\" name=\"wreath$wreathnum\" onChange=\"loadWreathimg(this, $wreathnum);\" disabled>";
			?>
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
<?php echo "<input type=\"checkbox\" name=\"isRibbon$wreathnum\" id=\"isRibbon$wreathnum\" onChange=\"ribbonEnable(this.id);\">"; ?>
		    <label>Kér szalagot</label>
		</td>
	</tr>
	<tr>
		<td>
	<?php echo "<select id=\"ribbon$wreathnum\" name=\"ribbon$wreathnum\" disabled>
					<option disabled selected>Válasszi ki a szalag szinét és típusát</option>";
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
		<td>
<?php echo"	<select id=\"ribboncolor$wreathnum\" name=\"ribboncolor$wreathnum\" disabled>
				<option disabled selected>Válassza ki a szalag színét</option>";
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
		<td>
	<?php echo "<select id=\"farewelltext$wreathnum\" name=\"farewelltext$wreathnum\" disabled>"; ?>
				<option disabled value="" selected>Válasszi ki a búcsúszöveget</option>
				<?php
					include 'farewelltext.php';
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>
	<?php	echo "<textarea style=\"height: 64px;width: 225px;resize: vertical;\" id=\"givers$wreathnum\" name=\"givers$wreathnum\" placeholder=\"Akik adják\"></textarea>"; ?>
		</td>
	</tr>
</table>
<?php echo "<img id=\"wreath_preview$wreathnum\" name=\"wreath_preview$wreathnum\" style='width: 165px; margin-top: 5px; float: left;'>";
			echo "<input type='hidden' id='wreath_preview_src$wreathnum' name='wreath_preview_src$wreathnum' value=''>"; ?>
</td>