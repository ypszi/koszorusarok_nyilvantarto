	<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
	<div id="alertwindow"></div>
<?php
	include '../../../config.php';

	$tapeid = $_POST['tapeid'];
	$tapetext = $_POST['tapetext'];

	$query_up = "UPDATE `tape_title` SET `text`='$tapetext' WHERE `id`=$tapeid";
	$result_up = mysql_query($query_up) or die (mysql_error());

	echo "<script type='text/javascript'>
			document.getElementById('alertwindow').innerHTML += '<h1>Szalag felirat sikeresen m&oacute;dos&iacute;tva!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"".$conf_path_abs."index.php?page=beallitas&subpage=koszoru_felirat\"', 1000);
			</script>";
?>