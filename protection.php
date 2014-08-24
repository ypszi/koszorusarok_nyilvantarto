<?php
	if (basename($_SERVER['SCRIPT_FILENAME']) != 'index.php'){
		header('Location: index.php');
	}
?>