<?php

class statesApi extends api {

	public function index() {
		
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			
			$response = $this->registry->db->getStates($_GET);
			$this->returnData(array('states' => $response));
			
		}
		
	}	
		
	
}

?>