	<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
	<div id="alertwindow"></div>
<?php
	include '../../../config.php';

	if (isset($_POST['flowertype'])) $flowertype = $_POST['flowertype']; else $flowertype = "";
	if (isset($_POST['flowercolor'])) $flowercolor = $_POST['flowercolor']; else $flowercolor = "";
	if (isset($_POST['flowerprice'])) $flowerprice = $_POST['flowerprice']; else $flowerprice = "";

	$query_ins = "INSERT INTO `flower` (`type`, `color`, `price`) VALUES ('$flowertype','$flowercolor','$flowerprice')";
	mysql_query($query_ins) or die(mysql_error());

	echo "<script type='text/javascript'>
			document.getElementById('alertwindow').innerHTML += '<h1>Vir&aacute;g sikeresen felv&eacute;ve!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"".$conf_path_abs."index.php?page=beallitas&subpage=virag\"', 1000);
			</script>";
?>