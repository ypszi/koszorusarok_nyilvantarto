<link href="css/alertwindow.css" rel="stylesheet" type="text/css" media="all"/>
<style type="text/css">
	#pw_change td {
		vertical-align: middle;
		border: 1px solid #c0d4a1;
		text-align: center;
		padding: 2px;
	}

	#submit {
		cursor: pointer;
		height: 30px;
		color: #fff;
		padding: 2px;
		background: url(img/btn-bg1.png) repeat-x 0 0px;
		text-decoration: none !important;
		-webkit-transition: background .2s ease;
		-moz-transition: background .2s ease;
		-ms-transition: background .2s ease;
		-o-transition: background .2s ease;
		transition: background .2s ease;
	}
</style>
	<script type="text/javascript" src="js/protea_functions.js"></script>

<div class="title">
	<span class="firstWord">Jelszó</span> csere
</div>

<div id="alertwindow"></div>

<form method="POST" action="menu-main/menu-setting-submenu/password/replace.php" enctype="multipart/form-data" onsubmit="return pw_check()">
	<table id="pw_change">
		<tr>
			<td>
				Régi jelszó
			</td>
			<td>
				<input type="password" placeholder="Adja meg régi jelszavát" id="old_pw" name="old_pw">
				<?php 
				echo '<input type="hidden" value="" name="hidd_oldpw" id="hidd_oldpw">';
				?>
			</td>
		</tr>
		<tr>
			<td>
				Új jelszó
			</td>
			<td>
				<input type="password" placeholder="Új jelszó" id="new_pw" name="new_pw">
			</td>
		</tr>
		<tr>
			<td>
				Új jelszó ismét
			</td>
			<td>
				<input type="password" placeholder="Új jelszó újra" id="new_pw_again" >
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" id="submit" value="Mentés">
			</td>
		</tr>
	</table>
</form>