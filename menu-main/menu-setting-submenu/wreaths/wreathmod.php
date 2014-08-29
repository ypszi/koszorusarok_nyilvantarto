<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
<?php
	include '../../../config.php';
?>
<div id="alertwindow"></div>
<?php

	$actual_wname = $_POST['origin_wname'];
	$wreath_name = $_POST['wreath_name'];
	$the_same_wname = false;

	$wreath_id = 0; //Módosítandó koszorú ID-je
	$query_wid = "SELECT id FROM `special_wreath` WHERE name = '".$_POST['origin_wname']."'";
	$result_wid = mysql_query($query_wid, $conn) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result_wid)) {
		$wreath_id = $row['id'];
	}

	$save_errors = 0;

	$is_wreath = "SELECT name FROM special_wreath WHERE name='$wreath_name'";
	$result_iswreath = mysql_query($is_wreath) or die(mysql_error());

	if ($actual_wname = $wreath_name) {
		$the_same_wname = true;
	} else {
		$the_same_wname = false;
	}

	if (!$the_same_wname && mysql_num_rows($result_iswreath) > 0) {
		$save_errors++;
		echo "<script type=\"text/javascript\">
		document.getElementById('alertwindow').innerHTML += '<h1>Sikertelen módosítás! Ezzel a névvel már szerepel koszorú!</h1>';
		document.getElementById('alertwindow').style.display = 'block';
		</script>";
	} else {
		$wreath_fancy = $_POST['wreath_fancy'];
		$note = $_POST['note'];
		$base_wreath_type = $_POST['base_wreath_type'];
		$base_wreath_size = $_POST['base_wreath_size'];

		$flowernum = $_POST['flowernum'];
		$flower = array();
		$color = array();
		$qty = array();
		for ($i=0; $i < $flowernum; $i++) {
			$flower[($i+1)] = $_POST['flower'.($i+1)];
			$color[($i+1)] = $_POST['color'.($i+1)];
			$qty[($i+1)] = $_POST['qty'.($i+1)];
		}

		$leafnum = $_POST['leafnum'];
		$leaf = array();
		$leafqty = array();
		for ($i=0; $i < $leafnum; $i++) {
			$leaf[($i+1)] = $_POST['leaf'.($i+1)];
			$leafqty[($i+1)] = $_POST['leafqty'.($i+1)];
		}

		if (isset($_POST['rezgo'])) $rezgo = $_POST['rezgo']; else $rezgo="";
		if (isset($_POST['rezgoqty'])) $rqty = $_POST['rezgoqty']; else $rqty = 0;

		//Kép feltöltés
		if (isset($_FILES['file']) === true) {
			$file_name = $_FILES["file"]["name"];
			$file_type = $_FILES["file"]["type"];
			$file_size = $_FILES["file"]["size"];
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

				if ($_FILES["file"]["error"] > 0) {
					$save_errors++;
					echo "<script type=\"text/javascript\">
						document.getElementById('alertwindow').innerHTML = '<h1>Hiba! Hibakód: " . $_FILES["file"]["error"] . "</h1>';
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
					} else {
						move_uploaded_file($_FILES["file"]["tmp_name"], $target . $file_name);
						echo "<script type=\"text/javascript\">
						document.getElementById('alertwindow').innerHTML = '<h1>K&eacute;pfelt&ouml;lt&eacute;s sikeres!</h1>';
						document.getElementById('alertwindow').style.display = 'block';
						</script>";
						//echo "File stored in: " . "upload/" . $file_name;
					}
				}
			} else {
				if ($file_size > $maxsize) {
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

			if ($file_name == ""){
				$picture = $_POST['current_img'];
			} else {
				$picture = $file_name;
			}
		}

		// Galéria feltöltés
		$filenames = array();
		if (isset($_FILES['swreath_img_gallery']) === true) {
			$files = $_FILES['swreath_img_gallery'];

			if (count($files['name']) <= 5) {
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
							// ha már létezik a fájl, akkor töröljük
							unlink( $target . $filename );
							$filenames[] = $filename;
							move_uploaded_file($ftmp_name, $target . $filename);
							echo "<script type=\"text/javascript\">
							document.getElementById('alertwindow').innerHTML = '<h1>K&eacute;pfelt&ouml;lt&eacute;s sikeres!</h1>';
							document.getElementById('alertwindow').style.display = 'block';
							</script>";
							//echo "File stored in: " . "upload/" . $fname;
						}
					} else {
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
			} else {
				$save_errors++;
				echo "<script type=\"text/javascript\">
				document.getElementById('alertwindow').innerHTML = '<h1>T&uacute;l sok f&aacute;jl!</h1>';
				document.getElementById('alertwindow').style.display = 'block';
				</script>";
			}
		}

		$wreathprice = (float) str_replace(' ', '', $_POST['wreathprice']);
		$endprice = (float) str_replace(' ', '', $_POST['endprice']);


		if ($save_errors > 0) {
			echo "<script type=\"text/javascript\">
			document.getElementById('alertwindow').innerHTML += '<h1>Sikertelen szerkeszt&eacute;s!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"../../../index.php?page=beallitas&subpage=koszoru&koszoru_tipus=5\"', 2000);
			</script>";
		} else {

			$query_id = "SELECT id FROM `base_wreath` WHERE size = '$base_wreath_size'";
			$result_id = mysql_query($query_id, $conn) or die(mysql_error());

			while ($row = mysql_fetch_assoc($result_id)) {
				$bw_id = $row['id'];
				$query_up = "UPDATE `special_wreath` SET `name`='$wreath_name', `fancy`='$wreath_fancy', `base_wreath_id`=$bw_id, `calculate_price`=$wreathprice, `sale_price`=$endprice, `picture`='$picture', `note`='$note' WHERE `id`=$wreath_id";
				$result_up = mysql_query($query_up) or die (mysql_error());
			}

			if (!empty($filenames)) {

				$query_url = "SELECT url FROM `special_wreath_img` WHERE `special_wreath_id`=$wreath_id";
				$result_url = mysql_query($query_url) or die (mysql_error());

				while ($row = mysql_fetch_assoc($result_url)) {
					unlink( "../../../img/gallery/".basename($row['url']) );
				}

				$query_del = "DELETE FROM `special_wreath_img` WHERE `special_wreath_id`=$wreath_id";
				$result_del = mysql_query($query_del) or die (mysql_error());

				foreach ($filenames as $filename) {
					$url = $conf_path_abs . "img/gallery/". $filename;
					$query = "INSERT INTO `special_wreath_img` (`special_wreath_id`, `url`) VALUES ($wreath_id, '$url') ";
					$result = mysql_query($query, $conn) or die(mysql_error());
				}
			}

			$query_del = "DELETE FROM `conect_flower_special_wreath` WHERE `special_wreath_id`=$wreath_id";
			$result_del = mysql_query($query_del) or die (mysql_error());

			$ind = 1;
			for ($i=0; $i < $flowernum; $i++) {

				$query_fid = "SELECT id FROM flower WHERE type = '".$flower[$ind]."' AND color = '".$color[$ind]."';";
				$result_fid = mysql_query($query_fid, $conn) or die(mysql_error());

				while ($row_fid = mysql_fetch_assoc($result_fid)) {
					$fid = $row_fid['id'];
					$query_fins = "INSERT INTO `conect_flower_special_wreath` (`special_wreath_id`, `id_flower`, `priece`)
									VALUES ('$wreath_id', '$fid', '".$qty[$ind]."')";
					$result_fins = mysql_query($query_fins, $conn) or die(mysql_error());
				}
				$ind++;
			}

			$ind = 1;
			for ($i=0; $i < $leafnum; $i++) {

				$query_leafid = "SELECT id FROM flower WHERE type = 'levél' AND color = '".$leaf[$ind]."';";
				$result_leafid = mysql_query($query_leafid, $conn) or die(mysql_error());

				while ($row_leafid = mysql_fetch_assoc($result_leafid)) {
					$leafid = $row_leafid['id'];
					$query_fins = "INSERT INTO `conect_flower_special_wreath` (`special_wreath_id`, `id_flower`, `priece`)
									VALUES ('$wreath_id', '$leafid', '".$leafqty[$ind]."')";
					$result_fins = mysql_query($query_fins, $conn) or die(mysql_error());
				}
				$ind++;
			}

			$query_rezgoid = "SELECT id FROM flower WHERE type = 'rezgő'";
			$result_rezgoid = mysql_query($query_rezgoid, $conn) or die(mysql_error());

			while ($row_rezgo = mysql_fetch_assoc($result_rezgoid)) {
				$rezgoid = $row_rezgo['id'];
				$query_rins = "INSERT INTO `conect_flower_special_wreath` (`special_wreath_id`, `id_flower`, `priece`)
					VALUES ('$wreath_id', '$rezgoid', '$rqty')";
				if ($rqty != 0) $result_rins = mysql_query($query_rins, $conn) or die(mysql_error());
			}

			echo "<script type=\"text/javascript\">
				document.getElementById('alertwindow').innerHTML = '<h1>Sikeres m&oacute;dos&iacute;t&aacute;s!</h1>';
				document.getElementById('alertwindow').style.display = 'block';
				setTimeout('window.location.href=\"../../../index.php?page=beallitas&subpage=koszoru\"', 1000);</script>";
		}
	}
?>