<?php
	$wreath_id = "5";
	if (isset($_GET["koszoru_tipus"])){
		$wreath_id = $_GET["koszoru_tipus"];
	}

	$query = "	SELECT id,type
				FROM `base_wreath_type`
				ORDER BY type ASC;";

	$result = mysql_query($query) or die (mysql_error());
	$db = 0;
	echo '<div class="wreath_type" style="width: 730px; height: 30px; margin-left: -20px; padding-left: 5px;">';
	while ($row = mysql_fetch_assoc($result)) {
		$db++;
		if ($wreath_id != $row["id"]){
			echo '<a style="margin: 0px 2px 0px 2px;" href="'.$conf_path_abs.'?page=beallitas&subpage=koszoru&koszoru_tipus='.$row["id"].'">'.$row["type"].'</a> ';
		}else{
			echo '<a style="margin: 0px 2px 0px 2px;" class="select" href="'.$conf_path_abs.'?page=beallitas&subpage=koszoru&koszoru_tipus='.$row["id"].'">'.$row["type"].'</a>';
		}
		if ($db % 8 == 0) {
			echo '</div>
					<div class="wreath_type" style="width: 920px; height: 30px; margin-left: -20px; padding-left: 5px;">';
		}
	}
	echo '</div>';

	echo "<br /><br />";
	$query = "	SELECT special_wreath.picture, special_wreath.id,special_wreath.fancy, special_wreath.name, special_wreath.note, special_wreath.calculate_price, special_wreath.sale_price, base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note
				FROM `special_wreath`,`base_wreath`
				WHERE special_wreath.base_wreath_id=base_wreath.id AND base_wreath.type='".$wreath_id."'
				ORDER BY special_wreath.name ASC;";

	$result = mysql_query($query) or die (mysql_error());

	echo "<table id='wreath_table'>";
	while ($row = mysql_fetch_assoc($result)) {
		$pic = explode("|", $row["picture"]);
		echo '<tr>
				<td>
					<a href="'.$conf_path_abs.'img/wreath/'.$pic[0].'" target="_blank"><img src="'.$conf_path_abs.'img/wreath/'.$pic[0].'"/></a>
				</td>
				<td style="width: 140px;">
					<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">'.$row["name"].'</span>
					<div style="font:bold 11px/20px Georgia, serif; color:#627f6b;">'.$row["fancy"].'</div>
					<div style="margin-top:8px; font-style:italic;">'.$row["note"].'</div>
				</td>
				<td>';
				echo '<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">Alap</span>
					<table id="bwreath_sub_table">
						<tr>
							<td style="width: 380px;">'.$row["size"].', '.$row["base_wreath_note"].'</td>
						</tr>
					</table>';

				$query_flowers = "	SELECT flower.type, flower.color, flower.price ,conect_flower_special_wreath.priece
									FROM `conect_flower_special_wreath`,`flower`
									WHERE conect_flower_special_wreath.special_wreath_id = '".$row['id']."' AND conect_flower_special_wreath.id_flower = flower.id
									ORDER BY flower.leaf ASC, conect_flower_special_wreath.priece DESC;";
				$result_flowers = mysql_query($query_flowers) or die (mysql_error());
				echo '<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">&Ouml;sszetev&#337;k</span>
					<table id="wreath_sub_table">';

				$flower_price = 0;
				while ($row_flower = mysql_fetch_assoc($result_flowers)) {

					echo '<tr>';
						echo '<td style="width: 80px;">'. $row_flower["type"] . '</td>';
						echo '<td style="width: 120px;">'. $row_flower["color"] . '</td>';
						echo '<td style="width: 40px;">'. $row_flower["priece"] . ' db</td>';
						echo '<td style="width: 60px; font-style:italic;">'.number_format($row_flower["price"], 0, ',', ' ').' Ft/db</td>';

						$flower_price += $row_flower["priece"]*$row_flower["price"];
						echo '<td style="width: 55px;"><strong>'.number_format($row_flower["priece"]*$row_flower["price"], 0, ',', ' ').' Ft</strong></td>';
					echo '</tr>';
				}
				echo "</table>";

				// VIRÁGOK
				$query_onlyflowers = "	SELECT flower.type, flower.color, flower.price ,conect_flower_special_wreath.priece
				FROM `conect_flower_special_wreath`,`flower`
				WHERE conect_flower_special_wreath.special_wreath_id = '".$row['id']."' AND conect_flower_special_wreath.id_flower = flower.id AND flower.type NOT LIKE 'levél' AND flower.type NOT LIKE 'rezgő';";
				$result_onlyflowers = mysql_query($query_onlyflowers) or die (mysql_error());

				$ftype = array();
				$fcolor = array();
				$fqty = array();

				$ind = 0;
				while ($row_onlyflower = mysql_fetch_assoc($result_onlyflowers)) {
					$ftype[$ind] = $row_onlyflower['type'];
					$fcolor[$ind] = $row_onlyflower["color"];
					$fqty[$ind] = $row_onlyflower["priece"];
					$ind++;
				}

				$flotype = "";
				$flocolor = "";
				$floqty = "";
				$i = 1;
				foreach ($ftype as $value) {
					$flotype .= "&ftype$i=".$value;
					$i++;
				}
				$flonum = "&flowernum=".($i-1);
				$i = 1;
				foreach ($fcolor as $value) {
					$flocolor .= "&fcolor$i=".$value;
					$i++;
				}
				$i = 1;
				foreach ($fqty as $value) {
					$floqty .= "&fqty$i=".$value;
					$i++;
				}

				// LEVÉL
				$query_onlyleafs = "	SELECT flower.type, flower.color, flower.price ,conect_flower_special_wreath.priece
				FROM `conect_flower_special_wreath`,`flower`
				WHERE conect_flower_special_wreath.special_wreath_id = '".$row['id']."' AND conect_flower_special_wreath.id_flower = flower.id AND flower.type LIKE 'levél';";
				$result_onlyleafs = mysql_query($query_onlyleafs) or die (mysql_error());

				$ltype = array();
				$lcolor = array();
				$lqty = array();

				$ind = 0;
				while ($row_onlyleaf = mysql_fetch_assoc($result_onlyleafs)) {
					$ltype[$ind] = $row_onlyleaf['type'];
					$lcolor[$ind] = $row_onlyleaf["color"];
					$lqty[$ind] = $row_onlyleaf["priece"];
					$ind++;
				}

				$leaftype = "";
				$leafcolor = "";
				$leafqty = "";
				$i = 1;
				foreach ($ltype as $value) {
					$leaftype .= "&ltype$i=".$value;
					$i++;
				}
				$leafnum = "&leafnum=".($i-1);
				$i = 1;
				foreach ($lcolor as $value) {
					$leafcolor .= "&lcolor$i=".$value;
					$i++;
				}
				$i = 1;
				foreach ($lqty as $value) {
					$leafqty .= "&lqty$i=".$value;
					$i++;
				}

				// REZGŐ
				$query_onlyrezgo = "	SELECT flower.type, flower.color, flower.price ,conect_flower_special_wreath.priece
				FROM `conect_flower_special_wreath`,`flower`
				WHERE conect_flower_special_wreath.special_wreath_id = '".$row['id']."' AND conect_flower_special_wreath.id_flower = flower.id AND flower.type LIKE 'rezgő';";
				$result_onlyrezgo = mysql_query($query_onlyrezgo) or die (mysql_error());

				$rezgo = "";
				$rqty = 0;

				$ind = 0;
				while ($row_onlyrezgo = mysql_fetch_assoc($result_onlyrezgo)) {
					$rezgo = $row_onlyrezgo['type'];
					$rqty = $row_onlyrezgo["priece"];
					$ind++;
				}

				if ($rezgo == "rezgő") {
					$rezgo = "true";
				} else {
					$rezgo = "false";
				}

				$isrezgo = "&rezgo=".$rezgo;
				$rezgoqty = "&rqty=".$rqty;

		echo'   </td>
				<td>
					<div style="text-align:right;">

				<input type="button" value="" style="background-image:url('.$conf_path_abs.'/img/icons/Delete-icon.png); background-repeat:no-repeat; width:35px; " class="button" onclick="deleteSpecialWreath('.$row["id"].')">

				<a href="'.$conf_path_abs.'?page=beallitas&subpage=koszoru_szerkesztes
				&wreath='.$row["name"].'&fancy='.$row["fancy"].'&img='.$row["picture"].'&note='.$row["note"].'&size='.$row["size"].
				$flotype.$flocolor.$floqty.$flonum.
				$leaftype.$leafcolor.$leafqty.$leafnum.
				$isrezgo.$rezgoqty.'">
				<input type="button" value="" class="button" style="background-image:url('.$conf_path_abs.'img/icons/Edit-icon.png); background-repeat:no-repeat; width:32px; height: 32px;" id="'.$wreath_id.'"/>
				</a>

				<a href="'.$conf_path_abs.'menu-main/menu-setting-submenu/wreaths/get_wreath_pdf.php?id='.$row["id"].'" target="_blank">
				<input type="button" value="" class="button" style="background-image:url('.$conf_path_abs.'img/icons/Print-icon.png); background-repeat:no-repeat; width:32px; height: 32px;" id="'.$wreath_id.'"/>
				</a>
					</div>
					<div style="margin-top:2px;">Koszor&uacute;alap: '.number_format($row["price"], 0, ',', ' ').' Ft</div>
					<div style="margin-top:2px;">&Ouml;sszetev&#337;k : '.number_format($flower_price, 0, ',', ' '). ' Ft</div>
					<div style="margin-top:5px;">V&eacute;g&ouml;sszeg  : <strong>'.number_format($row["calculate_price"], 0, ',', ' ') .' Ft</strong>
					<div style="margin-top:5px;">&Eacute;rt&eacute;kes&iacute;t&eacute;si &ouml;sszeg:
					<div style="text-align:right;">'.number_format(round(($row["calculate_price"]+1000)*1.1111,-2), 0, ',', ' ') .' Ft</div>
					<div style="margin-top:25px;">R&ouml;gz&iacute;tett v&eacute;g &ouml;sszeg:
					<div style="text-align:right; font:bold 14px/30px Georgia, serif; color:#ef5f44;">'.number_format($row["sale_price"], 0, ',', ' ') .' Ft</div>
				</td>

			</tr>';
	}
	echo "</table>";
?>