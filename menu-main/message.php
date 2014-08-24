<?php
	require "protection.php";
?>

<div id="content">	
	<div id="left-menu">
		<?php 

			echo '<div class="button" id = "newMessageButton">
						<img src="img/icons/Message-icon.png" alt="" align="left" title="Új Üzenet"/>
						<div class="sidemenutitle">Új Üzenet</div>
					</div>';					
					//<a href="'.$conf_path_abs.'?page=uzenet&subpage=webmail">
			echo '<div class="button">
					<a href="http://levelezes.koszorusarok.hu/mailaccount/info.inc.php" target="_blank">
						<img src="img/icons/Webmail-icon.png" alt="" align="left" title="Webmail"/>
						<div class="sidemenutitle">Webmail</div>
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
						if ($subpage == 'uzenetek'){
							include "menu-message-submenu/messages.php";
						}
						if ($subpage == 'webmail'){
							include "menu-message-submenu/messages.php";
						}
					}else{
						include "menu-message-submenu/messages.php";
					}
				}
			?>
	</div>
</div>