<?php
	require "protection.php";
?>
<div id="content">	

	<div >
			<?php
				if (isset($_SESSION['logged_in'])) {
					if (isset($_GET['subpage'])){
						$subpage = $_GET['subpage'];
					}

					if (isset($subpage)) {			
						if ($subpage == 'telefon'){
							include "menu-phone-submenu/phone.php";
						}
					}else{
						include "menu-phone-submenu/phone.php";
					}
				}
			?>
	</div>
	
</div>