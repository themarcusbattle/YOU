<?php
abstract class Db {

	private $db_type = NULL;
	private $db_host = NULL;
	private $db_name = NULL;
	private $db_user = NULL;
	private $db_pass = NULL;
	
	public $db = NULL;
	
	public function __construct($params = array()){
		$this->db_type = $params['type']; // defines type of db (i.e. mssql, mysql, etc)
		$this->db_host = $params['host'];
		$this->db_name = $params['dbname'];
		$this->db_user = $params['dbuser'];
		$this->db_pass = $params['dbpass'];
		
		$this->db = new PDO("$this->db_type:host=$this->db_host;dbname=$this->db_name", $this->db_user, $this->db_pass);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	}
	
	/** HELPER FUNCTIONS **/
	
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