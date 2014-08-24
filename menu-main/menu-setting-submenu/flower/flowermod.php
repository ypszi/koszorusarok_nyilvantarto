	<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
	<div id="alertwindow"></div>
<?php
	include '../../../config.php';

	$flowerid = $_POST['flowerid'];
	$flowertype = $_POST['flowertype'];
	$flowercolor = $_POST['flowercolor'];
	$flowerprice = $_POST['flowerprice'];

	$query_up = "UPDATE `flower` SET `type`='$flowertype',`color`='$flowercolor',`price`=$flowerprice WHERE `id`=$flowerid";
	$result_up = mysql_query($query_up) or die (mysql_error());

	echo "<script type='text/javascript'>
			document.getElementById('alertwindow').innerHTML += '<h1>Koszor&uacute; alap sikeresen m&oacute;dos&iacute;tva!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"".$conf_path_abs."index.php?page=beallitas&subpage=virag\"', 1000);
			</script>";
?>