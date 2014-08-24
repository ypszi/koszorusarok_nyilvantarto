	<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
	<div id="alertwindow"></div>
<?php
	include '../../../config.php';

	$userid = $_POST['userid'];
	$username = $_POST['username'];
	$print_name = $_POST['print_name'];
	$title = $_POST['title'];
	$salary = $_POST['salary'];
	$shop = $_POST['shop'];
	$color = $_POST['color'];
	$enable = $_POST['enable'];
	$access_level = $_POST['access_level'];

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
			if (!isset($_FILES['user_img']['tmp_name'][1])) {
				if (isset($_POST['picture'])) {
					$picture = $_POST['picture'];
				} else {
					$picture = "";
				}
			}
		}

	$query_up = "UPDATE `users` SET `name`='$username',`print_name`='$print_name', `title`='$title', `salary`='$salary', `shop`=$shop, `picture`='$picture', `color`='$color', `enable`=$enable, `access_level`=$access_level WHERE `id`=$userid";
	$result_up = mysql_query($query_up) or die (mysql_error());

	echo "<script type='text/javascript'>
			document.getElementById('alertwindow').innerHTML += '<h1>Alkamazott sikeresen m&oacute;dos&iacute;tva!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"".$conf_path_abs."index.php?page=beallitas&subpage=alkalmazott\"', 1000);
			</script>";
?>