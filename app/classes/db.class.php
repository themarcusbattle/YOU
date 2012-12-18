<?php
abstract class Db {

	private $db_type = NULL;
	private $db_host = NULL;
	private $db_name = NULL;
	private $db_user = NULL;
	private $db_pass = NULL;
	
	public $db = NULL;
	
	public function __construct($params = array(),$tables = array()){
		$this->db_type = $params['type']; // defines type of db (i.e. mssql, mysql, etc)
		$this->db_host = $params['host'];
			$this->db_name = $params['dbname'];
		$this->db_user = $params['dbuser'];
		$this->db_pass = $params['dbpass'];
		
		$this->db = new PDO("$this->db_type:host=$this->db_host;dbname=$this->db_name", $this->db_user, $this->db_pass);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		
		self::createTables($tables);
	}
	
	/** HELPER FUNCTIONS **/
	private function createTables($tables = array()) {
		
		foreach($tables as $table => $cols) {
			if(!self::getTable($table)){ // If table doesn't exist make it
				$table_created = self::createTable($table,$cols);
				// echo "table $table created <br />";
			} else {
				$table_altered = self::alterTable($table,$cols);
				// echo "table $table altered <br />";
			}
		}
	}

	private function getTable($table) {
		$sql = "SHOW TABLES LIKE :table";
	
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array(
			'table' => $table
		));
	
		return $stmt->fetch();
	}
	
	private function createTable($table = '',$cols = array()) {
		$sql 	= "CREATE TABLE $table";
		
		if($cols) {
			$sql .= " (";
			foreach($cols['cols'] as $col => $data_type) {
				$sql .= "$col $data_type,";
			}
			
			// Check for last comma
			$pos = strrpos($sql, ',');
			if($pos !== false) {
				$sql = substr_replace($sql, '', $pos, 1);
	    }
			
			// Assign Primary Key
			if(isset($cols['primary_key'])) {
				$sql .= ", PRIMARY KEY (" . $cols['primary_key'] . ")";
			}
			
			$sql .= ")";
		} else {
			echo "$table needs at least one column to be created <br />";
			return false;
		}
		
		$response = $this->db->query($sql);
		return $response;
	}
	
	private function alterTable($table = '',$cols = array()) {
		$sql = "
			CREATE TABLE
		";
	}
	
	public function addOneRecord($table = '',$values = array()) {

		if (isset($values)) {
			$sql  = "INSERT INTO $table (";
			
			// Set the cols
			foreach ($values as $col => $value) {
				$sql .= "$col,";
			}
			
			// Check for last comma
			$pos = strrpos($sql, ',');
			if($pos !== false) {
				$sql = substr_replace($sql, '', $pos, 1);
	    }
	    $sql .= ") VALUES (";
	    
			// Set the values
			foreach ($values as $col => $value) {
				$sql .= ":$col,";
			}
			
			$sql .= ")";
			// Check for last comma
			$pos = strrpos($sql, ',');
			if($pos !== false) {
				$sql = substr_replace($sql, '', $pos, 1);
	    }
	    
			$stmt = $this->db->prepare($sql);
			$result = $stmt->execute($values);
			
			return $result;
		}
	}
	
	public function getOneRecord($table = '',$where = array()) {

		$sql = "SELECT * FROM $table";
		$stmt = $this->db->query($sql);
		return $stmt->fetch();
	}
	
	public function getManyRecords($table = '',$where = array()) {

		$sql = "SELECT * FROM $table";
		$stmt = $this->db->query($sql);
		return $stmt->fetchAll();
	}
	
	// return all tables from the db
	public function getAllTables() {
		$tables = array();
	
		$qry = $this->db->query("SELECT * FROM INFORMATION_SCHEMA.TABLES ORDER BY TABLE_NAME ASC");
		$result = $qry->fetchAll();
		
		foreach($result as $table){
			array_push($tables,$table['TABLE_NAME']);
		}
		
		return $result;
	}
	
	private function getAllColumns($table_name) {
		$qry = $this->db->query("SELECT column_name from information_schema.columns where table_name = '$table_name'");
		$result = $qry->fetchAll();
		
		return $result;
	}
	
	public function buildSQL($sql,$params){
		
		// Add any available parameters
		if($params) {
			$sql .= " WHERE ";
			
			foreach($params as $key => $value) {
				$sql .= $key . "=:" . $key;
			}
				
		}
		
		return $sql;
		
	}
	
}

?>