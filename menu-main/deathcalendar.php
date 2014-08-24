<script>
		/*function newFuneral() {
			// alert("asd");
			$.ajax({
				type: "GET",
				url: "menu-main/menu-deathcalendar-submenu/addFuneral.php",
				success: function(data){
					$('#newFuneral').html(data);
					$('#newFuneral').toggle();
				}
			});
		}*/
</script>

<?php
	require "protection.php";
?>

<div id="content">	
	<div id="left-menu">
		<?php 
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=temetes&subpage=naptar">
						<img src="img/icons/Calendar-icon.png" alt="" align="left" title="Temetkezési naptár"/>
						<div class="sidemenutitle">Temetkezési naptár</div>
					</a>
				</div>';
			echo '<div class="button">
					<a href="'.$conf_path_abs.'?page=temetes&subpage=temetes">
						<img src="img/icons/DeathCalendar-icon.png" alt="" align="left" title="Temetkezési naptár"/>
						<div class="sidemenutitle">Temetések kezelése</div>
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
						if ($subpage == 'naptar'){
							include "menu-deathcalendar-submenu/calendar.php";
						}elseif ($subpage == 'naptarinap'){
							include "menu-deathcalendar-submenu/day.php";
						}
						elseif ($subpage == 'temetes'){
							include "menu-deathcalendar-submenu/funeral.php";
						}
					}else{
						include "menu-deathcalendar-submenu/calendar.php";
					}
				}
			?>
	</div>
</div>