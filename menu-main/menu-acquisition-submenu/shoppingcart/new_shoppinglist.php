<?php
	include '../../../config.php';
?>
	<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
	<div id='alertwindow'></div>

<?php 

	if (isset($_POST['listnote'])) $listnote = $_POST['listnote'];

	if (isset($_POST['date'])) $name = $_POST['date'];
	if (isset($_POST['product'])) $product = $_POST['product'];
	if (isset($_POST['required_number'])) $required_number = $_POST['required_number'];
	if (isset($_POST['buying_number'])) $buying_number = $_POST['buying_number'];
	if (isset($_POST['price'])) $price = $_POST['price'];
	if (isset($_POST['sale_price'])) $sale_price = $_POST['sale_price'];

	$date = date("Y-m-d H:i:s");

	$query = "INSERT INTO `shopping_cart` (`name`, `note`, `date`) VALUES ('$name', '$listnote', '$date');";
	$result = mysql_query($query) or die(mysql_error());

	$query = "SELECT id FROM `shopping_cart` ORDER BY id DESC LIMIT 0, 1;";
	$result = mysql_query($query) or die(mysql_error());
	
	while ($row = mysql_fetch_assoc($result)) {
		$cart_id = $row['id'];
	}

	for ($i=0; $i < $_POST['item_num']; $i++) { 
		$query_ins = "INSERT INTO `shopping_cart_item` (`shopping_cart_id`, `product`, `required_number`, `buying_number`, `price`, `sale_price`, `archive`) 
						VALUES (".$cart_id.", '".$product[$i]."', '".$required_number[$i]."', '".$buying_number[$i]."', '".$price[$i]."', '".$sale_price[$i]."', '0')";
		$result_ins = mysql_query($query_ins) or die(mysql_error());
	}

	echo "<script type=\"text/javascript\">
	alertwindow.innerHTML = \"<h1>Bevásárló lista sikeresen hozzáadva!</h1>\";
	alertwindow.style.display = \"block\";
	setTimeout('window.location.href=\"../../../index.php?page=beszerzes&subpage=bevasarlolista\"', 1500);
	</script>";
?>