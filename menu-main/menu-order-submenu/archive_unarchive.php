<link href="css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
<div id='alertwindow'></div>

<?php 
	$order_id = $_GET['order_id'];
	if (isset($_GET['subpage']) && $_GET['subpage'] == "archivalas") {
		$query = "UPDATE `orders` SET archive = 1 WHERE id=$order_id;";
		$result = mysql_query($query) or die(mysql_error());
		echo "<script type='text/javascript'>
				document.getElementById('alertwindow').innerHTML += '<h1>Rendel&eacute;s sikeresen archiv&aacute;lva!</h1>';
				document.getElementById('alertwindow').style.display = 'block';
				setTimeout('window.location.href=\"$conf_path_abs?page=rendeles&subpage=archive_megrendeles\"', 1500);
				</script>";
	} elseif (isset($_GET['subpage']) && $_GET['subpage'] == "visszaallitas") {
		$query = "UPDATE `orders` SET archive = 0 WHERE id=$order_id;";
		$result = mysql_query($query) or die(mysql_error());
		echo "<script type='text/javascript'>
				document.getElementById('alertwindow').innerHTML += '<h1>Rendel&eacute;s sikeresen vissza&aacute;l&iacute;tva!</h1>';
				document.getElementById('alertwindow').style.display = 'block';
				setTimeout('window.location.href=\"$conf_path_abs?page=rendeles&subpage=megrendelesek\"', 1500);
				</script>";
	}
 ?>