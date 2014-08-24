<?php
	session_start();

	echo number_format($_SESSION['wprice'], 0, '', ' ') . " Ft";
?>