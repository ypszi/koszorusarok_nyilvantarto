<?php
include '../../../config.php';

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
if ($_POST['wreath_price'] == "") {
$query_ins = "INSERT INTO `other_incoming` (`date`, `shop`, `price`, `wreath_price`, `note`) VALUES ('$date','$shop','$price',NULL,'$note')";
} else {
$query_ins = "INSERT INTO `other_incoming` (`date`, `shop`, `price`, `wreath_price`, `note`) VALUES ('$date','$shop','$price','$wreath_price','$note')";
}
mysql_query($query_ins) or die(mysql_error());

?>
<script>
</script>