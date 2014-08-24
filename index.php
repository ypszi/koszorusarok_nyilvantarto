<?php if (!isset($_SESSION['logged_in'])) session_start(); ?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6 no-js" lang="hu"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7 no-js" lang="hu"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8 no-js" lang="hu"><![endif]-->
<!--[if IE 9 ]><html class="ie ie9 no-js" lang="hu"><![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="hu">
<!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<title>Protea Csoport - Nyilvántartó 1.0</title>
	<meta name="description" content="Megrendelések nyilvántartása, beszerzések optimalizálása"/> 
	<meta name="keywords" content="koszorú, koszorú kötés"/> 
	<meta name="generator" content=""/>
	<meta name="robots" content="index,follow"/>
	<meta name="author" content="Györgyi Tamás">

	<link rel="icon" type="image/vnd.microsoft.icon" href="img/favicon.ico"/>
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico"/>
	<link href='http://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'/>
	<script type="text/javascript">
			var baseDir = '';
			var baseUri = '';
			var priceDisplayPrecision = 2;
			var priceDisplayMethod = 0;
			var roundMode = 2;
		</script>
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
	<link href="css/style_old.css" rel="stylesheet" type="text/css" media="all"/>
	<link href="css/login_style.css" rel="stylesheet" type="text/css" media="all"/>

	<link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="js/protea_functions.js"></script>
	
</head>
<body id="index">
	<?php 
		include "config.php";
		include "classes.php";
	?>
	<div id="wrapper1">
			<div id="wrapper3" class="container_4 clearfix">

				<header id="header">
 
					<ul id="header_user">
						<?php 
							if (isset($_SESSION['logged_in'])) { ?>
						<li id="user_info">
							<?php
								if (isset($_SESSION['database'])){
									$db = unserialize($_SESSION['database']);
									$db->connect();
									
									$cleaner = unserialize($_SESSION['cleaner']);
								}else{
									$db = new Database($conf_db_host, $conf_db_user, $conf_db_pass, $conf_db_name);
									$db->connect();
									
									$cleaner = new Cleaner();
									
									$_SESSION['database'] = serialize($db);
									$_SESSION['cleaner'] = serialize($cleaner);
								}

								$query =  mysql_query("SELECT name FROM  `users` WHERE id=".$_SESSION['logged_in'].";");
								$username = mysql_result($query,0);
								echo "Üdvözöllek, <a class=\"login\" href=\"#\">$username</a>";
							?>
						</li>
						<li>
							<a href="logout.php" ><input type="button" class="button" value="Kijelentkezés" > </a>
						</li>
						<?php } else {
							echo "<li id=\"user_info\"> Nem jelentkezett be! </li>";
						} ?>
					</ul>
  

				<?php 

					if (isset($_SESSION['logged_in'])) { 
						echo '<a id="header_logo" href="'.$conf_path_abs.'" title="Protea Csoport"></a>';
					?>
					<div id="topmenu" style="margin-left:143px; width:915px;">
						<ul class="sf-menu clearfix">
<?php 
							echo '<li><a href="'.$conf_path_abs.'"><img src="img/icons/Home-icon.png" alt="" align="left" title="Fooldal" style="margin-top: -20px; margin-left: -15px;"/>Főoldal</a></li>';
							echo '<li><a href="'.$conf_path_abs.'?page=naptar"><img src="img/icons/Calendar-icon.png" alt="" align="left" title="Naptár" style="margin-top: -20px; margin-left: -15px;"/>Naptár</a></li>';
							echo '<li><a href="'.$conf_path_abs.'?page=szallitas"><img src="img/icons/Deliver-icon.png" alt="" align="left" title="Szállítás" style="margin-top: -20px; margin-left: -15px;"/>Szállítás</a></li>';							
							echo '<li><a href="'.$conf_path_abs.'?page=beszerzes"><img src="img/icons/Acquisition-Stat-Icon.png" alt="" align="left" title="Beszerzés" style="margin-top: -20px; margin-left: -15px;"/>Beszerzés</a></li>';
							echo '<li><a href="'.$conf_path_abs.'?page=temetes"><img src="img/icons/DeathCalendar-icon.png" alt="" align="left" title="Temetés" style="margin-top: -20px; margin-left: -15px;"/>Temetés</a></li>';
							echo '<li><a href="'.$conf_path_abs.'?page=uzenet"><img src="img/icons/Messages-icon.png" alt="" align="left" title="Üzenet" style="margin-top: -20px; margin-left: -15px;"/>Üzenet</a></li>';
							echo '<li><a href="'.$conf_path_abs.'?page=telefon"><img src="img/icons/Phone-icon.png" alt="" align="left" title="Telefon" style="margin-top: -20px; margin-left: -15px;"/>Telefon</a></li>';							
							echo '<li><a href="'.$conf_path_abs.'?page=ajanlatok"><img src="img/icons/Offers-icon.png" alt="" align="left" title="Ajánlatok" style="margin-top: -20px; margin-left: -15px;"/>Ajánlatok</a></li>';
							echo '<li><a href="'.$conf_path_abs.'?page=rendeles"><img src="img/icons/Order-icon.png" alt="" align="left" title="Megrendelés" style="margin-top: -20px; margin-left: -15px;"/>Rendelés</a></li>';
							echo '<li><a href="'.$conf_path_abs.'?page=munkahet"><img src="img/icons/Workweek-icon.png" alt="" align="left" title="Munkahét" style="margin-top: -20px; margin-left: -15px;"/>Munkahét</a></li>';
							echo '<li><a href="'.$conf_path_abs.'?page=beallitas"><img src="img/icons/Settings-icon.png" alt="" align="left" title="Beállítás" style="margin-top: -20px; margin-left: -15px;"/>Beállítás</a></li>';

							if ($_SESSION['logged_in'] == 1 || $_SESSION['logged_in'] == 2 || $_SESSION['logged_in'] == 3 || $_SESSION['logged_in'] == 10) {
								echo '<li><a href="'.$conf_path_abs.'?page=statisztika"><img src="img/icons/Statistic-icon.png" alt="" align="left" title="Statisztika" style="margin-top: -20px; margin-left: -15px;"/>Statisztika</a></li>';
							}
?>
						</ul>
					</div>
			<?php } ?>
				</header>

<?php
	if (isset($_SESSION['logged_in'])) {
		if (isset($_GET['page'])){
			$page = $_GET['page'];
		}

		if (isset($page)){			
			if ($page == 'main'){
				include "menu-main/main.php";
			}elseif ($page == 'rendeles'){
				include "menu-main/order.php";
			}elseif ($page == 'ajanlatok'){
				include "menu-main/offers.php";
			}elseif ($page == 'naptar'){
				include "menu-main/calendar.php";
			}elseif ($page == 'beszerzes'){
				include "menu-main/acquisition.php";
			}elseif ($page == 'uzenet'){
				include "menu-main/message.php";
			}elseif ($page == 'telefon'){
				include "menu-main/phone.php";
			}elseif ($page == 'szallitas'){
				include "menu-main/deliver.php";
			}elseif ($page == 'munkahet'){
				include "menu-main/workweek.php";
			}elseif ($page == 'statisztika'){
				include "menu-main/statistic.php";
			}elseif ($page == 'beallitas'){
				include "menu-main/settings.php";
			}elseif ($page == 'temetes'){
				include "menu-main/deathcalendar.php";
			}else{
				include "menu-main/main.php";
			}
		}else{
			include "menu-main/main.php";
		}
	}
	else {
		include "avatars.php";
	}
?>
	<?php
		$tmp = 0;
		if (!isset($_GET["page"]) AND isset($_SESSION['logged_in'])) {
			
			echo "</div>";
		}
	?>
		<footer>
			<div id="footer" class="clearfix">
				<p>&copy; 2012-<?php echo date("Y"); ?> ProteaCsoport</p>
			</div>
		</footer>
	<?php
		if (isset($_GET["page"]) AND !isset($_SESSION['logged_in'])) {
			echo "</div>";
		}
	?>

	</body>
</html>