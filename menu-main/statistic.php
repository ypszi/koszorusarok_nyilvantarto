<?php
	require "protection.php";
?>

<div id="content">	
	<div id="left-menu">
		<?php 
/*			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=statisztika&subpage=altalanos">
						<img src="img/icons/Quick-icon.png" alt="" align="left" title="Általános"/>
						<div class="sidemenutitle">Általános</div>
					</a>
				</div>';*/
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=statisztika&subpage=fizetes">
						<img src="img/icons/Salary-icon.png" alt="" align="left" title="Fizetés"/>
						<div class="sidemenutitle">Fizetés</div>
					</a>
					</div>';
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=statisztika&subpage=fizetesek">
						<img src="img/icons/ShopSalary-icon.png" alt="" align="left" title="Egyéni Fizetés"/>
						<div class="sidemenutitle">Egyéni Fizetés</div>
					</a>
					</div>';
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=statisztika&subpage=napibevetel">
						<img src="img/icons/DayIncoming-icon.png" alt="" align="left" title="Bevétel rögzítés"/>
						<div class="sidemenutitle">Bevétel rögzítés</div>
					</a>
				</div>';
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=statisztika&subpage=napibeszerzes">
						<img src="img/icons/DayAcquisition-icon.png" alt="" align="left" title="Beszerzés rögzítés"/>
						<div class="sidemenutitle">Beszerzés rögzítés</div>
					</a>
					</div>';
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=statisztika&subpage=napijarulek">
						<img src="img/icons/DayContributory-icon.png" alt="" align="left" title="Költség rögzítés"/>
						<div class="sidemenutitle">Költség rögzítés</div>
					</a>
				</div>';
		?>					
	</div>

	<div id="right-content" style="width:740px;">

			<?php
				if (isset($_SESSION['logged_in'])) {
					if (isset($_GET['subpage'])){
						$subpage = $_GET['subpage'];
					}

					if (isset($subpage)) {	
						if ($subpage == 'bevetel'){
							include "menu-statistic-submenu/statistic.php";
						}elseif ($subpage == 'vegsoosszesites'){
							include "menu-statistic-submenu/finalstatistic.php";
						}elseif ($subpage == 'napibevetel'){
							include "menu-statistic-submenu/daystatistic.php";
						}elseif ($subpage == 'napiosszesites'){
							include "menu-statistic-submenu/daysummery.php";
						}elseif ($subpage == 'eladas'){
							include "menu-statistic-submenu/sold_flower.php";
						}elseif ($subpage == 'fizetesek'){
							include "menu-statistic-submenu/salary.php";
						}elseif ($subpage == 'fizetes'){
							include "menu-statistic-submenu/shopsalary.php";
						}elseif ($subpage == 'beszerzes'){
							include "menu-statistic-submenu/acquisition/acquisition.php";
						}elseif ($subpage == 'napibeszerzes'){
							include "menu-statistic-submenu/dayacquisition.php";
						}elseif ($subpage == 'jarulek'){
							include "menu-statistic-submenu/outlay/outlay.php";
						}elseif ($subpage == 'napijarulek'){
							include "menu-statistic-submenu/dayoutlay.php";
						//}elseif ($subpage == 'altalanos'){
						//	include "menu-statistic-submenu/quick.php";
						}else{
							include "menu-statistic-submenu/statistic.php";
						}
					}else{
						include "menu-statistic-submenu/statistic.php";
					}
				}
			?>
	</div>
	
		<div id="left-menu" style="margin-left:20px; margin-right:0px;">
		<?php 
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=statisztika&subpage=bevetel">
						<img src="img/icons/InCome-icon.png" alt="" align="left" title="Bevétel"/>
						<div class="sidemenutitle">Bevétel</div>
					</a>
				</div>';
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=statisztika&subpage=napiosszesites">
						<img src="img/icons/DaySummery-icon.png" alt="" align="left" title="Napi bevétel"/>
						<div class="sidemenutitle">Napi bevétel</div>
					</a>
				</div>';
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=statisztika&subpage=beszerzes">
						<img src="img/icons/Acquisition-icon.png" alt="" align="left" title="Beszerzés"/>
						<div class="sidemenutitle">Beszerzés</div>
					</a>
					</div>';
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=statisztika&subpage=jarulek">
						<img src="img/icons/Contributory-icon.png" alt="" align="left" title="Költség"/>
						<div class="sidemenutitle">Költség</div>
					</a>
				</div>';
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=statisztika&subpage=vegsoosszesites">
						<img src="img/icons/Statistic-icon.png" alt="" align="left" title="Mérleg"/>
						<div class="sidemenutitle">Mérleg</div>
					</a>
				</div>';
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=statisztika&subpage=eladas">
						<img src="img/icons/Flower-Edit-icon.png" alt="" align="left" title="Eladás"/>
						<div class="sidemenutitle">Eladások</div>
					</a>
				</div>';
		?>					
	</div>

	
</div>