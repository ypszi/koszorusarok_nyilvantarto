<?php 
	// Excel fájl feltöltés
	$exc_file = "";
	if (isset($_FILES['excel_shopping_list']) === true) {
	  $files = $_FILES['excel_shopping_list'];

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

			$allowedExts = array("xls", "XLS");
			$exploded = explode(".", $filename);
			$extension = end($exploded);
			$target = "../../../img/wreath/";
			$maxsize = 10485760; // 10MB -> 10240kbyte * 1024byte

			if (($filesize < $maxsize) && in_array($extension, $allowedExts)) {

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
	  	$exc_file .= $filename . '|';
	  }
	}
?>