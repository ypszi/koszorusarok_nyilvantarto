<?php
	include '../../../config.php';

	$id = $_POST['id'];
	$query = "DELETE FROM special_wreath_img WHERE id = $id";
	$result = mysql_query($query) or die(mysql_error());

	$swreath_id = $_POST['swreath_id'];

	$query = "SELECT id, url FROM `special_wreath_img` WHERE special_wreath_id = $swreath_id";
	$result = mysql_query($query) or die (mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		echo '<div style="margin: 0 10px 10px 0;">
				<div id="'.$row['id'].'" class="del_gallery_img" style="cursor: pointer; text-decoration: none; position: relative; display: inline; left: 15px; padding: 5px; background-color: rgb(214, 9, 9); color: white;">X</div>
				<img src="'.$row['url'].'" style="width: 120px;">
			</div>';
	}
?>