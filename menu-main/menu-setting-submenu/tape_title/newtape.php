	<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
	<div id="alertwindow"></div>
<?php
	include '../../../config.php';

	if (isset($_POST['tapetext'])) $tapetext = $_POST['tapetext']; else $tapetext = "";

	$query_ins = "INSERT INTO `tape_title` (`text`) VALUES ('$tapetext')";
	mysql_query($query_ins) or die(mysql_error());

	echo "<script type='text/javascript'>
			document.getElementById('alertwindow').innerHTML += '<h1>Szalag felirat sikeresen felv&eacute;ve!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"".$conf_path_abs."index.php?page=beallitas&subpage=koszoru_felirat\"', 1000);
			</script>";
?>