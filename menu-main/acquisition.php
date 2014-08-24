<?php
	require "protection.php";
?>

<div id="content">	
	<div id="left-menu">
		<?php 
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=beszerzes&subpage=beszerzes">
						<img src="img/icons/Acquisition-icon.png" alt="" align="left" title="Beszerzések"/>
						<div class="sidemenutitle">Beszerzések</div>
					</a>
					</div>';
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=beszerzes&subpage=kellekjegyzek">
						<img src="img/icons/Ingredient-icon.png" alt="" align="left" title="Kellék jegyzék"/>
						<div class="sidemenutitle">Kellék jegyzék</div>
					</a>
					</div>';
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=beszerzes&subpage=bevasarlolista">
						<img src="img/icons/ShoppingCart-icon.png" alt="" align="left" title="Bevesárló lista"/>
						<div class="sidemenutitle">Bevesárló lista</div>
					</a>
					</div>';
	?>					
	</div>
	<div id="settings-right-content">
			<?php
				if (isset($_SESSION['logged_in'])) {
					if (isset($_GET['subpage'])){
						$subpage = $_GET['subpage'];
					}

					if (isset($subpage)) {			
						if ($subpage == 'beszerzes'){
							include "menu-acquisition-submenu/acquisition.php";
						}else if($subpage == 'kellekjegyzek'){						
							include "menu-acquisition-submenu/ingredient/ingredient.php";
						}else if($subpage == 'bevasarlolista'){
							include "menu-acquisition-submenu/shoppingcart/shoppingcart.php";
						}else if($subpage == 'bevasarlolistanyomtatas'){
							include "menu-acquisition-submenu/shoppingcart/printshoppingcart.php";
						}else if($subpage == 'exportexcel'){
							include "menu-acquisition-submenu/shoppingcart/export_excel.php";
						}else if($subpage == 'importexcel'){
							include "menu-acquisition-submenu/shoppingcart/import_excel.php";
						}
					}else{
						include "menu-acquisition-submenu/acquisition.php";
					}
				}
			?>
	</div>
</div>