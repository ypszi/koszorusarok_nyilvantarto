<?php
	require "protection.php";
?>

<div id="content">	
	<div id="left-menu">
		<?php 
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=rendeles&subpage=megrendelesek">
						<img src="img/icons/Orders-icon.png" alt="" align="left" title="Rendelések"/>
						<div class="sidemenutitle">Rendelések</div>
					</a>
				</div>';
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=rendeles&subpage=uj_megrendeles">
						<img src="img/icons/New-Order-icon.png" alt="" align="left" title="Új rendelés"/>
						<div class="sidemenutitle">Új rendelés</div>
					</a>
					</div>';
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=rendeles&subpage=keres">
						<img src="img/icons/Search-icon.png" alt="" align="left" title="Keresés"/>
						<div class="sidemenutitle">Keresés</div>
					</a>
					</div>';
			if ($_SESSION['logged_in'] == 1 || $_SESSION['logged_in'] == 2 || $_SESSION['logged_in'] == 3 || $_SESSION['logged_in'] == 7) {
				echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=rendeles&subpage=archive_megrendeles">
						<img src="img/icons/Offers-icon.png" alt="" align="left" title="Törölt"/>
						<div class="sidemenutitle">Törölt</div>
					</a>
					</div>';
				echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=rendeles&subpage=regi_megrendeles">
						<img src="img/icons/InCome-icon.png" alt="" align="left" title="Régi rendelés"/>
						<div class="sidemenutitle">Régi rendelés</div>
					</a>
					</div>';
			}
		?>					
	</div>

	<div id="right-content">
			<?php
				if (isset($_SESSION['logged_in'])) {
					if (isset($_GET['subpage'])){
						$subpage = $_GET['subpage'];
					}

					if (isset($subpage)) {			
						if ($subpage == 'megrendelesek'){
							include "menu-order-submenu/orders.php";
						}elseif ($subpage == 'megrendeles'){
							include "menu-order-submenu/order.php";
						}elseif ($subpage == 'uj_megrendeles'){
							include "menu-order-submenu/new-order/new_order.php";
						}elseif ($subpage == 'archive_megrendeles'){
							include "menu-order-submenu/archive_orders.php";							
						}elseif ($subpage == 'regi_megrendeles'){
							include "menu-order-submenu/old_orders.php";
						}elseif ($subpage == 'keres'){
							include "menu-order-submenu/search.php";
						}elseif($subpage == 'modositas') {
							include 'menu-order-submenu/mod-order/order-modify.php';
						}elseif($subpage == 'archivalas') {
							include 'menu-order-submenu/archive_unarchive.php';
						}elseif($subpage == 'visszaallitas') {
							include 'menu-order-submenu/archive_unarchive.php';
						}else{
							include "menu-order-submenu/orders.php";
						}
					}else{
						include "menu-order-submenu/orders.php";
					}
				}
			?>
	</div>

</div>