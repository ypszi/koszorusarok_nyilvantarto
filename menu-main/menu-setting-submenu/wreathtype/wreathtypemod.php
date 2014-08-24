	<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
	<div id="alertwindow"></div>
<?php
	include '../../../config.php';

	$wreathbid = $_POST['wreathbid'];
	$wreathbtype = $_POST['wreathbtype'];
	$wreathbsize = $_POST['wreathbsize'];
	$wreathbfmin = $_POST['wreathbfmin'];
	$wreathbfmax = $_POST['wreathbfmax'];
	$wreathbprice = $_POST['wreathbprice'];

	$query_up = "UPDATE `base_wreath` SET `type`='$wreathbtype',`size`='$wreathbsize',`flower_min`=$wreathbfmin,`flower_max`=$wreathbfmax,`price`=$wreathbprice WHERE `id`=$wreathbid";
	mysql_query($query_up) or die (mysql_error());

	echo "<script type='text/javascript'>
			document.getElementById('alertwindow').innerHTML += '<h1>Koszor&uacute; alap sikeresen m&oacute;dos&iacute;tva!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"".$conf_path_abs."index.php?page=beallitas&subpage=koszoru_alap\"', 1000);
			</script>";
?>