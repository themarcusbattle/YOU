<?php

class loginApi extends api {

	public function index() {
	
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			echo "get";
			
		} else if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->returnData($this->registry->db_local->login_user($_POST));
		}
	
	}	
	
}

?>