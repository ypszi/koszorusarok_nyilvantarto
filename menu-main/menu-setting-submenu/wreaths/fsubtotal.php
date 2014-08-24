<?php
	session_start();

	echo number_format($_SESSION['fprice'], 0, '', ' ') . " Ft";
?>