<script type="text/javascript">
	function loginuser(param) {
		var uservalue = document.getElementById(param).id;
		uservalue = uservalue.substring(6); // uservalue = userid1 lenne -> 6. char után nézi
		document.getElementById('login_userid').value = uservalue;
	}
</script>

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
	$query =  mysql_query("SELECT id,name,title,picture FROM  `users` WHERE enable=1 ORDER BY name ASC;");

	echo '<div class="avatars">';

		while ($user = mysql_fetch_assoc($query)){
			echo '<div class="login_avatar" style="background: url('.$conf_path_abs.'/img/users/'.$user["picture"].') no-repeat #fff;" onClick="visibility(true); loginuser(\'userid'.$user["id"].'\');">
					<input type="hidden" id="userid'.$user["id"].'" >
					<div class="login_name">'.$user["name"].'</div>
					<div class="login_title">'.$user["title"].'</div>
				</div>';
		}
		echo'	
			<div id="login">
				<h1>Belépéshez szükséges jelszó</h1>
				<div class="exit" class="button" onClick="visibility(false);"> X </div>
				<form action="login.php" method="POST">
					<input type="hidden" name="user_id" id="login_userid" value="userid" >
					<input type="password" name="password" id="login_password" >
					<input type="submit" class="button" value="Belépés">
				</form>
			</div>';
	echo "</div>";
?>