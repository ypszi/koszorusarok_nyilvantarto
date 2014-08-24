<?php	

		$where="";
		foreach ($_POST['offers_to_print'] as $key) {

			if (isset($key)){
				if ($where!=""){
					$where = $where .  ' OR id='.$key;
				}else{
					$where = $where . 'id='.$key;				
				}
			}
		}
		
		$con = new mysqli('localhost', 'koszor01_user', 'Petrik2012', 'koszor01_protea');
		$con->set_charset('utf8_unicode_ci');
		$con->query('SET CHARACTER SET latin2;');

		$query = "UPDATE offer_wreath
			SET archive = 1 
			WHERE ".$where.";";
				
		$result = $con->query($query);						

/*		while ($row = mysqli_fetch_array($result)) {
		}*/
	
	$con->close();
?>