<?php
	session_start();
	include "../../../config.php";
?>
	<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
<?php
	echo "<div id=\"alertwindow\"></div>";

	$wreath_name = $_POST['wreath_name'];

	$save_errors = 0;

	$is_wreath = "SELECT name FROM special_wreath WHERE name='$wreath_name'";
	$result_iswreath = mysql_query($is_wreath) or die(mysql_error());

	if ($result_iswreath && mysql_num_rows($result_iswreath) > 0) {
		$save_errors++;
		echo "<script type=\"text/javascript\">
		document.getElementById('alertwindow').innerHTML += '<h1>Sikertelen hozzáadás! Ezzel a névvel már szerepel koszorú!</h1>';
		document.getElementById('alertwindow').style.display = 'block';
		</script>";
	} else {

		$wreath_fancy = $_POST['wreath_fancy'];
		$base_wreath_type = $_POST['base_wreath_type'];
		$base_wreath_size = $_POST['base_wreath_size'];

		$flowerid = array();
		$ftype = array();

		$fnum = $_SESSION['flowers'];
		$lnum = $_SESSION['leafs'];


		$ind = 1;
		for ($i=0; $i < $fnum; $i++) {
			$ftype[$ind] = $_POST["flower$ind"];

			$fcolor[$ind] = $_POST["color$ind"];

			$fqty[$ind] = $_POST["qty$ind"];
			$ind++;
		}

		$ind = 1;
		for ($i=0; $i < $lnum; $i++) {

			if (!isset($_POST["leaf$ind"])) $leaftype[$ind] = ""; else $leaftype[$ind] = $_POST["leaf$ind"];
			$leafqty[$ind] = $_POST["leafqty$ind"];
			$ind++;
		}
		if (!isset($_POST['rezgo'])) $rezgo = 0; else $rezgo = $_POST['rezgo'];
		if (!isset($_POST['rezgoqty'])) $rezgoqty = 0; else $rezgoqty = $_POST['rezgoqty'];
		$note = $_POST['note'];
		$calcprice = (float) str_replace(' ', '', $_POST['wreathprice']);
		if (isset($_POST['endprice'])) $endprice = (float) str_replace(' ', '', $_POST['endprice']); else $endprice = 0;
	?>

	<?php
		//Kép feltöltés
		$picture = "";
		if (isset($_FILES['swreath_img']) === true) {
			$file_name = $_FILES["swreath_img"]["name"];
			$file_type = $_FILES["swreath_img"]["type"];
			$file_size = $_FILES["swreath_img"]["size"];
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
					' ' => ''
			);

			foreach ($accents as $key => $val)
			{
				$file_name = preg_replace('#'.$key.'#', $val, $file_name);
			}

			$allowedExts = array("gif", "GIF", "jpeg", "JPEG", "jpg", "JPG", "png", "PNG");
			$exploded = explode(".", $file_name);
			$extension = end($exploded);
			$target = "../../../img/wreath/";
			$maxsize = 10485760; // 10MB -> 10240kbyte * 1024byte

			if ((($file_type == "image/gif")
				|| ($file_type == "image/jpeg")
				|| ($file_type == "image/jpg")
				|| ($file_type == "image/pjpeg")
				|| ($file_type == "image/x-png")
				|| ($file_type == "image/png"))
				&& ($file_size < $maxsize)
				&& in_array($extension, $allowedExts)) {

				if ($_FILES["swreath_img"]["error"] > 0) {
					$save_errors++;
					echo "<script type=\"text/javascript\">
						document.getElementById('alertwindow').innerHTML = '<h1>Hiba! Hibakód: " . $_FILES["swreath_img"]["error"] . "</h1>';
						document.getElementById('alertwindow').style.display = 'block';
						</script>";
				}
				else {

					if (file_exists($target . $file_name)) {
						$save_errors++;
						echo "<script type=\"text/javascript\">
						document.getElementById('alertwindow').innerHTML = '<h1>Ez a f&aacute;jl m&aacute;r l&eacute;tezik: " . $file_name . "! </h1>';
						document.getElementById('alertwindow').style.display = 'block';
						</script>";
					}
					else {
						move_uploaded_file($_FILES["swreath_img"]["tmp_name"], $target . $file_name);
						echo "<script type=\"text/javascript\">
						document.getElementById('alertwindow').innerHTML = '<h1>K&eacute;pfelt&ouml;lt&eacute;s sikeres!</h1>';
						document.getElementById('alertwindow').style.display = 'block';
						</script>";
						//echo "File stored in: " . "upload/" . $file_name;
					}
				}
			}
			else {
				if ($file_size > $maxsize) {
					$save_errors++;
					echo "<script type=\"text/javascript\">
						document.getElementById('alertwindow').innerHTML = '<h1>T&uacute;l nagy f&aacute;jlm&eacute;ret!</h1>';
						document.getElementById('alertwindow').style.display = 'block';
						</script>";
				} else {
					if ($file_name != "") {
						$save_errors++;
						echo "<script type=\"text/javascript\">
						document.getElementById('alertwindow').innerHTML = '<h1>&eacute;rv&eacute;nytelen f&aacute;jl!</h1>';
						document.getElementById('alertwindow').style.display = 'block';
						</script>";
					}
				}
			}

			$picture = $file_name;
		}

		// Galéria feltöltés
		$filenames = array();
		if (isset($_FILES['swreath_img_gallery']) === true) {
		  $files = $_FILES['swreath_img_gallery'];

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
				$target = "../../../img/gallery/";
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
						$save_errors++;
						echo "<script type=\"text/javascript\">
							document.getElementById('alertwindow').innerHTML = '<h1>Hiba! Hibakód: " . $files["error"][$i] . "</h1>';
							document.getElementById('alertwindow').style.display = 'block';
							</script>";
					} else {
						if (file_exists($target . $filename)) {
							$save_errors++;
							echo "<script type=\"text/javascript\">
							document.getElementById('alertwindow').innerHTML = '<h1>Ez a f&aacute;jl m&aacute;r l&eacute;tezik: " . $filename . "! </h1>';
							document.getElementById('alertwindow').style.display = 'block';
							</script>";
						}
						else {
							$filenames[] = $filename;
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
						$save_errors++;
						echo "<script type=\"text/javascript\">
							document.getElementById('alertwindow').innerHTML = '<h1>T&uacute;l nagy f&aacute;jlm&eacute;ret!</h1>';
							document.getElementById('alertwindow').style.display = 'block';
							</script>";
					} else {
						if ($filename != "") {
							$save_errors++;
							echo "<script type=\"text/javascript\">
							document.getElementById('alertwindow').innerHTML = '<h1>&eacute;rv&eacute;nytelen f&aacute;jl!</h1>';
								document.getElementById('alertwindow').style.display = 'block';
							</script>";
						}
					}
				}
			}
		}

		if ($save_errors > 0) {
			echo "<script type=\"text/javascript\">
			document.getElementById('alertwindow').innerHTML += '<h1>Sikertelen hozzáadás!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"../../../index.php?page=beallitas&subpage=uj_koszoru\"', 2000);
			</script>";
		} else {

			$query_id = "SELECT id FROM  `base_wreath` WHERE size = '$base_wreath_size'";
			$result_id = mysql_query($query_id, $conn) or die(mysql_error());
			while ($row_id = mysql_fetch_assoc($result_id)) {

				$query_ins = "INSERT INTO `special_wreath` (`name`, `fancy`, `base_wreath_id`, `calculate_price`, `sale_price`, `picture`, `note`) VALUES ('$wreath_name', '$wreath_fancy', '".$row_id['id']."','$calcprice','$endprice','$picture', '$note')";
				mysql_query($query_ins, $conn) or die(mysql_error());
				$swreath_id = mysql_insert_id();
				foreach ($filenames as $filename) {
					$target_path = $target . $swreath_id;
					if ( !is_dir($target_path) ) {
						$old_umask = umask(0);
						mkdir($target_path);
						umask($old_umask);
					}
					$url = $conf_path_abs . "img/gallery/$swreath_id/". $filename;
					$query = "INSERT INTO `special_wreath_img` (`special_wreath_id`, `url`) VALUES ($swreath_id, '$url') ";
					$result = mysql_query($query, $conn) or die(mysql_error());
					rename($target . $filename, $target_path. "/" . $filename);
				}

				$ind = 1;
				for ($i=0; $i < $fnum; $i++) {
					$query_fid = "SELECT id FROM flower WHERE type = '".$ftype[$ind]."' AND color = '".$fcolor[$ind]."';";
					$result_fid = mysql_query($query_fid, $conn) or die(mysql_error());

					$query_swid = "SELECT id FROM  `special_wreath` ORDER BY id DESC LIMIT 0, 1;";
					$result_swid = mysql_query($query_swid, $conn) or die(mysql_error());
					while ($row_swid = mysql_fetch_assoc($result_swid)) {
						$swid = $row_swid['id'];
						while ($row_fid = mysql_fetch_assoc($result_fid)) {
							$query_fins = "INSERT INTO `conect_flower_special_wreath` (`special_wreath_id`, `id_flower`, `priece`)
								VALUES ('".$swid."', '".$row_fid['id']."', '".$fqty[$ind]."')";
							$result_fins = mysql_query($query_fins, $conn) or die(mysql_error());
						}
					}
					$ind++;
				}

				$ind = 1;
				for ($i=0; $i < $lnum; $i++) {
					$query_leafid = "SELECT id FROM flower WHERE type = 'levél' AND color = '".$leaftype[$ind]."';";
					$result_leafid = mysql_query($query_leafid, $conn) or die(mysql_error());

					$query_swid = "SELECT id FROM  `special_wreath` ORDER BY id DESC LIMIT 0, 1;";
					$result_swid = mysql_query($query_swid, $conn) or die(mysql_error());
					while ($row_swid = mysql_fetch_assoc($result_swid)) {
						$swid = $row_swid['id'];
						while ($row_leafid = mysql_fetch_assoc($result_leafid)) {
							$query_fins = "INSERT INTO `conect_flower_special_wreath` (`special_wreath_id`, `id_flower`, `priece`)
								VALUES ('".$swid."', '".$row_leafid['id']."', '".$leafqty[$ind]."')";
							$result_fins = mysql_query($query_fins, $conn) or die(mysql_error());
						}
					}
					$ind++;
				}

				$query_rezgoid = "SELECT id FROM flower WHERE type = \"rezgő\";";
				$result_rezgoid = mysql_query($query_rezgoid, $conn) or die(mysql_error());

				$query_swid = "SELECT id FROM  `special_wreath` ORDER BY id DESC LIMIT 0, 1;";
				$result_swid = mysql_query($query_swid, $conn) or die(mysql_error());

				while ($row_swid = mysql_fetch_assoc($result_swid)) {
					$swid = $row_swid['id'];
					while ($row_rezgo = mysql_fetch_assoc($result_rezgoid)) {
						$query_rins = "INSERT INTO `conect_flower_special_wreath` (`special_wreath_id`, `id_flower`, `priece`)
							VALUES ('".$swid."', '".$row_rezgo['id']."', '".$rezgoqty."')";
						if ($rezgoqty != 0) $result_rins = mysql_query($query_rins, $conn) or die(mysql_error());
					}
				}
			}

			echo "<script type=\"text/javascript\">
			document.getElementById('alertwindow').innerHTML += '<h1>Koszor&uacute; hozz&aacute;adva az adatb&aacute;zishoz!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"../../../index.php?page=beallitas&subpage=uj_koszoru\"', 1500);
			</script>";
		}
	}


?>