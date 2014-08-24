<link href="css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
<div id='alertwindow'></div>
<?php
	include '../../config.php';

	$shopid = substr($_GET['shop'], 0, 1);

	$query = "UPDATE `orders` SET maker_shop = '$shopid' WHERE id = ".$_GET['id']."";
	$result = mysql_query($query) or die(mysql_error());

	echo "<script type='text/javascript'>
			document.getElementById('alertwindow').innerHTML += '<h1>Rendel&eacute;s sikeresen &aacute;thelyezve!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"../../../index.php?page=rendeles&subpage=megrendeles&id=".$_GET['id']."\"', 1500);
			</script>";
?>