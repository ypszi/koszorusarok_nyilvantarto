	<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
	<div id="alertwindow"></div>
<?php
	include '../../../config.php';

	$cemeteryid = $_POST['cemeteryid'];
	$cemeteryname = $_POST['cemeteryname'];
	$cemeteryaddress = $_POST['cemeteryaddress'];

	$query_up = "UPDATE `cemetery` SET `name`='$cemeteryname',`address`='$cemeteryaddress' WHERE `id`=$cemeteryid";
	$result_up = mysql_query($query_up) or die (mysql_error());

	echo "<script type='text/javascript'>
			document.getElementById('alertwindow').innerHTML += '<h1>Temeto sikeresen m&oacute;dos&iacute;tva!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"".$conf_path_abs."index.php?page=beallitas&subpage=temetok\"', 1000);
			</script>";
?>