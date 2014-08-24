	<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
	<div id="alertwindow"></div>
<?php
	include '../../../config.php';

	if (isset($_POST['cemeteryname'])) $name = $_POST['cemeteryname']; else $name = "";
	if (isset($_POST['cemeteryaddress'])) $address = $_POST['cemeteryaddress']; else $address = "";

	$query_ins = "INSERT INTO `cemetery` (`name`, `address`) VALUES ('$name','$address')";
	mysql_query($query_ins) or die(mysql_error());

	echo "<script type='text/javascript'>
			document.getElementById('alertwindow').innerHTML += '<h1>Temeto sikeresen felv&eacute;ve!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"".$conf_path_abs."index.php?page=beallitas&subpage=temetok\"', 1000);
			
			</script>";
?>