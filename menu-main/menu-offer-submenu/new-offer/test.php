<?php session_start(); ?>
	<?php 
		echo '$_SESSION[shipment]: ' . $_SESSION['shipment'] . '<br>';
		echo '$_SESSION[clocation]: ' . $_SESSION['clocation'] . '<br>';
		echo '$_SESSION[caddress]: ' . $_SESSION['caddress'] . '<br>';
		echo '$_SESSION[cfuneral]: ' . $_SESSION['cfuneral'] . '<br>';
		echo '$_SESSION[ritual_date]: ' . $_SESSION['ritual_date'] . '<br>';
		echo '$_SESSION[ritual_time]: ' . $_SESSION['ritual_time'] . '<br>';
		echo '$_SESSION[dead_name]: ' . $_SESSION['dead_name'] . '<br>';
		echo '$_SESSION[customer_name]: ' . $_SESSION['customer_name'] . '<br>';
		echo '$_SESSION[phone_num]: ' . $_SESSION['phone_num'] . '<br>';
		echo '$_SESSION[email]: ' . $_SESSION['email'] . '<br>';
		echo '$_SESSION[end_price]: ' . $_SESSION['end_price'] . '<br>';
		echo '$_SESSION[price]: ' . $_SESSION['price'] . '<br>';
		echo '$_SESSION[ship_price]: ' . $_SESSION['ship_price'] . '<br>';
	?>