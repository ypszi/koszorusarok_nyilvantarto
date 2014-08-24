<?php
	include '../../../config.php';
?>
	<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
	<div id='alertwindow'></div>

<?php 

	if (isset($_POST['listdate'])) $listdate = $_POST['listdate'];
	if (isset($_POST['list_id'])) $list_id = $_POST['list_id'];
	if (isset($_POST['shopping_cart_id'])) $shopping_cart_id = $_POST['shopping_cart_id'];
	if (isset($_POST['listnote'])) $listnote = $_POST['listnote'];

	if (isset($_POST['product'])) $product = $_POST['product'];
	if (isset($_POST['required_number'])) $required_number = $_POST['required_number'];
	if (isset($_POST['buying_number'])) $buying_number = $_POST['buying_number'];
	if (isset($_POST['price'])) $price = $_POST['price'];
	if (isset($_POST['sale_price'])) $sale_price = $_POST['sale_price'];
	if (isset($_POST['note'])) $note = $_POST['note'];

	$date = date("Y-m-d H:i:s");

	$query_del = "DELETE FROM `shopping_cart_item` WHERE shopping_cart_id = $shopping_cart_id;";
	$result_del = mysql_query($query_del) or die(mysql_error());

	for ($i=0; $i < $_POST['item_num']; $i++) { 
		$query_ins = "INSERT INTO `shopping_cart_item` (`shopping_cart_id`, `product`, `required_number`, `buying_number`, `price`, `sale_price`, `note`, `archive`) 
												VALUES ($shopping_cart_id, '$product[$i]', '$required_number[$i]', '$buying_number[$i]', '$price[$i]', '$sale_price[$i]', '$note[$i]', '0')";
		$result_ins = mysql_query($query_ins) or die(mysql_error());
	}


	$query = "UPDATE `shopping_cart` SET note = '$listnote', date = '$date' WHERE id=$list_id;";
//	$query = "UPDATE `shopping_cart` SET name = '$listdate', note = '$listnote', date = '$date' WHERE id=$list_id;";
	$result = mysql_query($query) or die(mysql_error());

	echo "<script type=\"text/javascript\">
	alertwindow.innerHTML = \"<h1>Sikeres módosítás!</h1>\";
	alertwindow.style.display = \"block\";
	setTimeout('window.location.href=\"../../../index.php?page=beszerzes&subpage=bevasarlolista\"', 1500);
	</script>";
?>