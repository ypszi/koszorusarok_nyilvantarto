<?php
include '../../../config.php';

$id = $_POST['id'];
$date = $_POST['date'];
$shop = $_POST['shop'];
$price = $_POST['price'];
$wreath_price = $_POST['wreath_price'];
$note = $_POST['note'];

//	$query_types = "SELECT * FROM other_incoming WHERE archive = 0 ORDER BY type ASC;";
//	$result_types = mysql_query($query_types) or die(mysql_error());
//	while ($row_types = mysql_fetch_assoc($result_types)) {
//		if ($row_types["type"] == $type) {
//			$type = $row_types["id"];
//		}
//	}

$query_update= "UPDATE `other_incoming` SET `price`='$price',`wreath_price`='$wreath_price',`date`='$date',`shop`='$shop',`note`='$note' WHERE id='$id'";

mysql_query($query_update) or die(mysql_error());

?>
<script>
</script>