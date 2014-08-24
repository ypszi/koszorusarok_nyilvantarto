	<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
	<div id="alertwindow"></div>
<?php
	include '../../../config.php';

	if (isset($_POST['wreath_type'])) $wreath_type = $_POST['wreath_type']; else $wreath_type = "";

	$query_ins = "INSERT INTO `base_wreath_type` (`type`) VALUES ('$wreath_type')";
	mysql_query($query_ins) or die(mysql_error());

	echo "<script type='text/javascript'>
			document.getElementById('alertwindow').innerHTML += '<h1>Koszor&uacute;t&iacute;pus sikeresen felv&eacute;ve!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"".$conf_path_abs."index.php?page=beallitas&subpage=frissit\"', 1000);
			</script>";
?>