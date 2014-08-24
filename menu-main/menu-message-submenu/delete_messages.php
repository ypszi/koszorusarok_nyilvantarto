<?php	
		include '../../config.php';

		$where="";

		if (isset($_GET['recipient_messages'])) {
			foreach ($_GET['recipient_messages'] as $key) {
				if (isset($key)){
					if ($where!=""){
						$where = $where .  ' OR id='.$key;
					}else{
						$where = $where . 'id='.$key;				
					}
				}

				$query_rdel = "UPDATE `message`
				SET archiveRecipient = 1
				WHERE ".$where.";";
			}
		}
		$where="";

		if (isset($_GET['sender_messages'])) {
			foreach ($_GET['sender_messages'] as $key) {
				if (isset($key)){
					if ($where!=""){
						$where = $where .  ' OR id='.$key;
					}else{
						$where = $where . 'id='.$key;				
					}
				}

				$query_sdel = "UPDATE `message`
				SET archiveSender = 1
				WHERE ".$where.";";
			}
		}

		if (isset($_GET['recipient_messages'])) {
			mysql_query($query_rdel) or die (mysql_error());
		}
		if (isset($_GET['sender_messages'])) {
			mysql_query($query_sdel) or die (mysql_error());
		}
?>