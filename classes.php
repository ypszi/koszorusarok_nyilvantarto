<?php
class Database{
	private $db_host;
	private $db_user;
	private $db_pass;
	private $db_name;

	public function __construct($db_host, $db_user, $db_pass, $db_name){
		$this->db_host = $db_host;
		$this->db_user = $db_user;
		$this->db_pass = $db_pass;
		$this->db_name = $db_name;
	}

	public function connect(){
		mysql_connect($this->db_host, $this->db_user, $this->db_pass);
		mysql_select_db($this->db_name);
		mysql_query("set names 'utf8'");
	}
	
	public function query($query){
		$query = mysql_query($query) or die(mysql_error());
		return $query;
	}
	
	public function resultAssoc($query, $just_one, $force_array = false){
		$array = false;
		
		while ($line = mysql_fetch_assoc($query)){
			if ($just_one)
				if ($force_array)
					$array[] = $line;
				else
					$array = $line;
			else
				$array[] = $line;
		}
		
		return $array;
	}
}

class Cleaner{
  public function secureString($string, $size = 0){
		$string = mysql_real_escape_string(trim($string));
		
		if ($size > 0)
			$string = substr($string, 0, $size);
		
		return $string;
	}
	
	public function toNumeric($string, $size = 0){
		$string = preg_replace('/[^0-9]+/', '', $string);
		
		if ($size > 0)
			$string = substr($string, 0, $size);
		
		return $string;
	}
	
	public function isEmail($string){
		if (preg_match("/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)*\.([a-zA-Z]{2,6})$/", $string)){
			return true;
		}
		
		return false;
	}
	
	public function htmlString($string, $encrypt = true){
		if(get_magic_quotes_gpc())
			$string = stripslashes($string);
	
		$crypt_codes = array("<", ">", "'", "\"", "`", "/", "\\");
		$decrypt_codes = array("&lt;", "&gt;", "&#39;", "&quot;", "&#96;", "&#47;", "&#92;");
		
		if ($encrypt){
			for ($i = 0; $i < count($crypt_codes); ++$i){
				$string = str_replace($crypt_codes[$i], $decrypt_codes[$i], $string);
			}
		}else{
			for ($i = 0; $i < count($crypt_codes); ++$i){
				$string = str_replace($decrypt_codes[$i], $crypt_codes[$i], $string);
			}
		}
		
		return $string;
	}
}
?>