	<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
	<div id="alertwindow"></div>
<?php
	include '../../../config.php';

	if(isset($_POST['wreathbtype'])) $wreathbtype = $_POST['wreathbtype']; else $wreathbtype = 0;
	if(isset($_POST['wreathbsize'])) $wreathbsize = $_POST['wreathbsize']; else $wreathbsize = 0;
	if(isset($_POST['wreathbfmin'])) $wreathbfmin = $_POST['wreathbfmin']; else $wreathbfmin = 0;
	if(isset($_POST['wreathbfmax'])) $wreathbfmax = $_POST['wreathbfmax']; else $wreathbfmax = 0;
	if(isset($_POST['wreathbprice'])) $wreathbprice = $_POST['wreathbprice']; else $wreathbprice = 0;

	$query_ins = "INSERT INTO `base_wreath` (`type`, `size`, `flower_min`, `flower_max`, `price`) VALUES ('$wreathbtype','$wreathbsize','$wreathbfmin','$wreathbfmax','$wreathbprice')";
	mysql_query($query_ins) or die(mysql_error());

	echo "<script type='text/javascript'>
			document.getElementById('alertwindow').innerHTML += '<h1>Koszor&uacute; alap sikeresen felv&eacute;ve!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"".$conf_path_abs."index.php?page=beallitas&subpage=koszoru_alap\"', 1000);
			</script>";
?>