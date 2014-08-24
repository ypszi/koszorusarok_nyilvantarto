<?php
	session_start();

	echo number_format($_SESSION['lprice'], 0, '', ' ') . " Ft";
?>