	<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
	<div id="alertwindow"></div>
<?php
	include '../../../config.php';

	if (isset($_POST['username'])) $username = $_POST['username']; else $username = "";
	if (isset($_POST['print_name'])) $print_name = $_POST['print_name']; else $print_name = "";
	if (isset($_POST['title'])) $title = $_POST['title']; else $title = "";
	$password = md5('1234');
	if (isset($_POST['salary'])) $salary = $_POST['salary']; else $salary = 0;
	if (isset($_POST['shop'])) $shop = $_POST['shop']; else $shop = 0;
	if (isset($_POST['color'])) $color = $_POST['color']; else $color = substr(md5(rand()), 0, 6);
	if (isset($_POST['enable'])) $enable = $_POST['enable']; else $enable = 1;
	if (isset($_POST['access_level'])) $access_level = $_POST['access_level']; else $access_level = 500;

		//Kép feltöltés
		$picture = "";
		if (isset($_FILES['user_img']) === true) {
		  $files = $_FILES['user_img'];

		  for ($i=0; $i < count($files['name']); $i++) { 
		    $filename = $files['name'][$i];
		    $ftmp_name = $files['tmp_name'][$i];
		    $filetype = $files['type'][$i];
		    $filesize = $files['size'][$i];

		    $accents = array(
				        'á' => 'a', 'Á' => 'A',
				        'ä' => 'a', 'Ä' => 'A',
				        
				        'é' => 'e', 'É' => 'E',
				        
				        'í' => 'i', 'Í' => 'I',
				        
				        'ó' => 'o', 'Ó' => 'O',
				        'ö' => 'o', 'Ö' => 'O',
				        'ő' => 'o', 'Ő' => 'O',
				        
				        'ú' => 'u', 'Ú' => 'U',
				        'ü' => 'u', 'Ü' => 'U',
				        'ű' => 'u', 'Ű' => 'U',
				        ' ' => '' );

				foreach ($accents as $key => $val)
				{
				    $filename = preg_replace('#'.$key.'#', $val, $filename);
				}

				$allowedExts = array("gif", "GIF", "jpeg", "JPEG", "jpg", "JPG", "png", "PNG");
				$exploded = explode(".", $filename);
				$extension = end($exploded);
				$target = "../../../img/users/";
				$maxsize = 10485760; // 10MB -> 10240kbyte * 1024byte

				if ((($filetype == "image/gif")
				|| ($filetype == "image/jpeg")
				|| ($filetype == "image/jpg")
				|| ($filetype == "image/pjpeg")
				|| ($filetype == "image/x-png")
				|| ($filetype == "image/png"))
				&& ($filesize < $maxsize)
				&& in_array($extension, $allowedExts)) {

				if ($files["error"][$i] > 0) {
					echo "<script type=\"text/javascript\">
						document.getElementById('alertwindow').innerHTML = '<h1>Hiba! Hibakód: " . $files["error"][$i] . "</h1>';
						document.getElementById('alertwindow').style.display = 'block';
						</script>";
				}
				else {
						if (file_exists($target . $filename)) {
							echo "<script type=\"text/javascript\">
							document.getElementById('alertwindow').innerHTML = '<h1>Ez a f&aacute;jl m&aacute;r l&eacute;tezik: " . $filename . "! </h1>';
							document.getElementById('alertwindow').style.display = 'block';
							</script>";
						}
						else {
							move_uploaded_file($ftmp_name, $target . $filename);
							echo "<script type=\"text/javascript\">
							document.getElementById('alertwindow').innerHTML = '<h1>K&eacute;pfelt&ouml;lt&eacute;s sikeres!</h1>';
							document.getElementById('alertwindow').style.display = 'block';
							</script>";
							//echo "File stored in: " . "upload/" . $fname;
						}
					}
				}
				else {
					if ($filesize > $maxsize) {
						echo "<script type=\"text/javascript\">
							document.getElementById('alertwindow').innerHTML = '<h1>T&uacute;l nagy f&aacute;jlm&eacute;ret!</h1>';
							document.getElementById('alertwindow').style.display = 'block';
							</script>";
					} else {
						if ($filename == "") {
							echo "";
						}
						else {
							echo "<script type=\"text/javascript\">
							document.getElementById('alertwindow').innerHTML = '<h1>&eacute;rv&eacute;nytelen f&aacute;jl!</h1>';
							document.getElementById('alertwindow').style.display = 'block';
							</script>";
						}
					}
				}
		  	$picture = $filename;
		  }
		}

	$query_ins = "INSERT INTO `users` (`name`, `print_name`, `title`, `password`, `salary`, `shop`, `picture`, `color`, `enable`, `access_level`) VALUES ('$username','$title','$password','$salary','$shop','$picture', '$color', '$enable','$access_level')";
	mysql_query($query_ins) or die(mysql_error());

	echo "<script type='text/javascript'>
			document.getElementById('alertwindow').innerHTML += '<h1>Alkalmazott sikeresen felv&eacute;ve!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"".$conf_path_abs."index.php?page=beallitas&subpage=alkalmazott\"', 1000);
			</script>";
?>