<?php
	session_start();

	echo number_format($_SESSION['rprice'], 0, '', ' ') . " Ft";
?>