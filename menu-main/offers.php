<?php
	require "protection.php";
?>

<div id="content">	
	<div id="left-menu">
		<?php 
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=ajanlatok&subpage=ajanlatok">
						<img src="img/icons/Offers-icon.png" alt="" align="left" title="Ajánlatok"/>
						<div class="sidemenutitle">Ajánlatok</div>
					</a>
				</div>';
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=ajanlatok&subpage=uj_ajanlat">
						<img src="img/icons/New-Offer-icon.png" alt="" align="left" title="Új ajánlat"/>
						<div class="sidemenutitle">Új ajánlat</div>
					</a>
					</div>';
			if ($_SESSION['logged_in'] == 1 || $_SESSION['logged_in'] == 2 || $_SESSION['logged_in'] == 3 || $_SESSION['logged_in'] == 7) {
				echo '<div class="button">
						<a href="'.$conf_path_abs.'?page=ajanlatok&subpage=regi_ajanlat">
							<img src="img/icons/OldOffer-icon.png" alt="" align="left" title="Régi ajánlat"/>
							<div class="sidemenutitle">Régi ajánlat</div>
						</a>
						</div>';
				echo '<div class="button">
						<a href="'.$conf_path_abs.'?page=ajanlatok&subpage=rendeles_ajanlat">
							<img src="img/icons/InCome-icon.png" alt="" align="left" title="Rendelésbeli"/>
							<div class="sidemenutitle">Rendelésbeli</div>
						</a>
						</div>';
				echo '<div class="button">
						<a href="'.$conf_path_abs.'?page=ajanlatok&subpage=archive_ajanlat">
							<img src="img/icons/OfferArchive-icon.png" alt="" align="left" title="Törölt Ajánlatok"/>
							<div class="sidemenutitle">Törölt</div>
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
						if ($subpage == 'ajanlatok'){
							include "menu-offer-submenu/offers.php";
						}elseif ($subpage == 'ajanlat_szerkesztes'){
							include "menu-offer-submenu/new-offer/offerform.php";
						}elseif ($subpage == 'uj_ajanlat'){
							include "menu-offer-submenu/new-offer/offerform.php";
						}elseif ($subpage == 'regi_ajanlat'){
							include "menu-offer-submenu/oldoffers.php";
						}elseif ($subpage == 'rendeles_ajanlat'){
							include "menu-offer-submenu/orderoffers.php";
						}elseif ($subpage == 'archive_ajanlat'){
							include "menu-offer-submenu/archiveoffers.php";
						}else{
							include "menu-offer-submenu/offers.php";
						}
					}else{
						include "menu-offer-submenu/offers.php";
					}
				}
			?>
	</div>

</div>