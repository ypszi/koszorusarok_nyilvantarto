	<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
	<div id="alertwindow"></div>
<?php
	include '../../../config.php';

	$citid = $_POST['citid'];
	$cittext = $_POST['cittext'];

	$query_up = "UPDATE `citation` SET `text`='$cittext' WHERE `id`=$citid";
	$result_up = mysql_query($query_up) or die (mysql_error());

	echo "<script type='text/javascript'>
			document.getElementById('alertwindow').innerHTML += '<h1>Id&eacute;zet sikeresen m&oacute;dos&iacute;tva!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"".$conf_path_abs."index.php?page=beallitas&subpage=idezet\"', 1000);
			</script>";
?>