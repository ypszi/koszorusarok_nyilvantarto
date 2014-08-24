<?php session_start(); ?>
<link href="../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
<div id='alertwindow'></div>
<?php
	include '../../config.php';
	$marked_date = date('Y-m-d');
	$marked_user = $_SESSION['logged_in'];
	
	$query = "UPDATE `orders` SET paid = '$marked_date', paid_check = '$marked_user' WHERE id = ".$_GET['id']."";
	$result = mysql_query($query) or die(mysql_error());

	echo "<script type='text/javascript'>
			document.getElementById('alertwindow').innerHTML += '<h1>Rendel&eacute;s sikeresen m&oacute;dos&iacute;tva!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"../../../index.php?page=rendeles&subpage=megrendeles&id=".$_GET['id']."\"', 1500);
			</script>";
?>