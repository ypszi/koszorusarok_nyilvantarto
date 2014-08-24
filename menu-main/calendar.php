<?php
	require "protection.php";
?>

	<div >
			<?php
				if (isset($_SESSION['logged_in'])) {
					if (isset($_GET['subpage'])){
						$subpage = $_GET['subpage'];
					}

					if (isset($subpage)) {			
						if ($subpage == 'osszesitett'){
							include "menu-calendar-submenu/main.php";
						}elseif ($subpage == 'naptarinap'){
							include "menu-calendar-submenu/day.php";
						}elseif ($subpage == 'bolt'){
							include "menu-calendar-submenu/shop.php";
						}elseif ($subpage == 'rendeles'){
							include "menu-calendar-submenu/order.php";
						}else{
							include "menu-calendar-submenu/main.php";
						}
					}else{
						include "menu-calendar-submenu/main.php";
					}
				}
			?>
	</div>
	
