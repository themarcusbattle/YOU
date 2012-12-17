<?php

class db_media extends Db {

	public function getAllMedia($params = array()) {
		$sql = "SELECT * FROM media WHERE show_in_app = 1";
		$stmt = $this->db->query($sql);
		return array('media' => $stmt->fetchAll());
	}
	
}


?>