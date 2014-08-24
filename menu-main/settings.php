<?php
	require "protection.php";
?>
<div id="content">	
	<div id="left-menu">
		<?php 
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=beallitas&subpage=jelszocsere">
						<img src="img/icons/Password-icon.png" alt="" align="left" title="Jelszócsere"/>
						<div class="sidemenutitle">Jelszó csere</div>
					</a>
					</div>';
					
			if ($_SESSION['logged_in'] == 1 || $_SESSION['logged_in'] == 2 || $_SESSION['logged_in'] == 3 || $_SESSION['logged_in'] == 7 || $_SESSION['logged_in'] == 10) {
				echo '<div class="button">
						<a href="'.$conf_path_abs.'?page=beallitas&subpage=koszoru&koszoru_tipus=11">
							<img src="img/icons/Wreaths-icon.png" alt="" align="left" title="Koszorú"/>
							<div class="sidemenutitle">Koszorúk</div>
						</a>
						</div>';
				echo '<div class="button">
						<a href="'.$conf_path_abs.'?page=beallitas&subpage=uj_koszoru">
							<img src="img/icons/New-Wreath-icon.png" alt="" align="left" title="Új_Koszorú"/>
							<div class="sidemenutitle">Új Koszorú</div>
						</a>
						</div>';
				echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=beallitas&subpage=koszoru_alap">
						<img src="img/icons/Flower-Edit-icon.png" alt="" align="left" title="Koszorú alap "/>
						<div class="sidemenutitle">Koszorú alapok</div>
					</a>
					</div>';
				echo '<div class="button">
						<a href="'.$conf_path_abs.'?page=beallitas&subpage=virag">
							<img src="img/icons/Flower-Edit-icon.png" alt="" align="left" title="Virág "/>
							<div class="sidemenutitle">Virágok</div>
						</a>
						</div>';
				echo '<div class="button">
						<a href="'.$conf_path_abs.'?page=beallitas&subpage=idezet">
							<img src="img/icons/Citation-icon.png" alt="" align="left" title="Idézet"/>
							<div class="sidemenutitle">Idézetek</div>
						</a>
						</div>';
				echo '<div class="button">
						<a href="'.$conf_path_abs.'?page=beallitas&subpage=koszoru_felirat">
							<img src="img/icons/TapeTitle-icon.png" alt="" align="left" title="Koszorú_felirat"/>
							<div class="sidemenutitle">Koszorú feliratok</div>
						</a>
						</div>';
			}
		?>					
	</div>
	<div id="settings-right-content" style="width:740px;">
			<?php
				if (isset($_SESSION['logged_in'])) {
					if (isset($_GET['subpage'])){
						$subpage = $_GET['subpage'];
					}
					if (isset($subpage)) {			
						if ($subpage == 'jelszocsere'){
							include "menu-setting-submenu/password/pw_change_form.php";
						}elseif ($subpage == 'alkalmazott'){
							include "menu-setting-submenu/employees/employees.php";
						}elseif ($subpage == 'koszoru_alap'){
							include "menu-setting-submenu/wreathtype/wreathtypeedit.php";
						}elseif ($subpage == 'virag'){
							include "menu-setting-submenu/flower/floweredit.php";
						}elseif ($subpage == 'uj_koszoru'){
							include "menu-setting-submenu/wreath/wreathform.php";
						}elseif ($subpage == 'koszoru'){
							include "menu-setting-submenu/wreaths/wreaths.php";
						}elseif ($subpage == 'koszoru_szerkesztes'){
							include "menu-setting-submenu/wreaths/wreathsedit.php";
						}elseif ($subpage == 'koszoru_nyomtatas'){
							include "menu-setting-submenu/wreaths/get_wreath_pdf.php";
						}elseif ($subpage == 'idezet'){
							include "menu-setting-submenu/citation/citation.php";
						}elseif ($subpage == 'koszoru_felirat'){
							include "menu-setting-submenu/tape_title/tape_title.php";
						}elseif ($subpage == 'koltseg'){
							include "menu-setting-submenu/outlay/outlay.php";
						}elseif ($subpage == 'beszerzes'){
							include "menu-setting-submenu/acquisition/acquisition.php";
						}elseif ($subpage == 'kellektipus'){
							include "menu-setting-submenu/ingredient/ingredient.php";
						}elseif ($subpage == 'uzlet'){
							include "menu-setting-submenu/shops/shops.php";
						}elseif ($subpage == 'temetok'){
							include "menu-setting-submenu/cemetery/cemetery.php";
						}elseif ($subpage == 'frissit'){
							include "menu-setting-submenu/refresh/refresh.php";
						}else{
							include "menu-setting-submenu/password/pw_change_form.php";
						}
					}else{
						include "menu-setting-submenu/password/pw_change_form.php";
					}
				}
			?>
	</div>
	
	<div id="left-menu" style="margin-left:20px; margin-right:0px;">
		<?php 
				if (isset($_SESSION['logged_in'])) {
					if (isset($_GET['subpage'])){
						$subpage = $_GET['subpage'];
					}
					
					if ($_SESSION['logged_in'] == 1 || $_SESSION['logged_in'] == 2 || $_SESSION['logged_in'] == 3 || $_SESSION['logged_in'] == 10){
					echo '<div class="button">
							<a href="'.$conf_path_abs.'?page=beallitas&subpage=koltseg">
								<img src="img/icons/Outlay-icon.png" alt="" align="left" title="Költség "/>
								<div class="sidemenutitle">Költség</div>
							</a>
							</div>';
					echo '<div class="button">
							<a href="'.$conf_path_abs.'?page=beallitas&subpage=beszerzes">
								<img src="img/icons/Acquisition-icon.png" alt="" align="left" title="Beszerzés "/>
								<div class="sidemenutitle">Beszerzés</div>
							</a>
							</div>';
					echo '<div class="button">
							<a href="'.$conf_path_abs.'?page=beallitas&subpage=kellektipus">
								<img src="img/icons/Ingredient-icon.png" alt="" align="left" title="Kellék Típus "/>
								<div class="sidemenutitle">Kellék Típus</div>
							</a>
							</div>';
					echo '<div class="button">
							<a href="'.$conf_path_abs.'?page=beallitas&subpage=alkalmazott">
								<img src="img/icons/User-icon.png" alt="" align="left" title="Alkalmazottak"/>
								<div class="sidemenutitle">Alkalmazottak</div>
							</a>
						</div>';
					echo '<div class="button">
							<a href="'.$conf_path_abs.'?page=beallitas&subpage=temetok">
								<img src="img/icons/Coffin-icon.png" alt="" align="left" title="Temetők"/>
								<div class="sidemenutitle">Temetők</div>
							</a>
						</div>';
					echo '<div class="button">
							<a href="'.$conf_path_abs.'?page=beallitas&subpage=frissit">
								<img src="img/icons/Refresh-icon.png" alt="" align="left" title="Koszorú frissítés"/>
								<div class="sidemenutitle">Koszorú Frissítés</div>
							</a>
							</div>';
					echo '<div class="button">
							<a href="'.$conf_path_abs.'?page=beallitas&subpage=uzlet">
								<img src="img/icons/Shops-icon.png" alt="" align="left" title="Üzlet"/>
								<div class="sidemenutitle">Üzlet</div>
							</a>
							</div>';
				}
			}
		?>					
	</div>
	
</div>