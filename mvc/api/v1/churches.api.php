<?php

class churchesApi extends api {

	public function index() {
		
		if($_SERVER['REQUEST_METHOD'] == 'GET') {	// Retrieves church data
			
			if(isset($_GET['church_id'])) {
				$response = $this->registry->db->getChurch($_GET);
			} else {
				$response = $this->registry->db->getChurches($_GET);
			}
			$this->returnData(array('churches' => $response));
			
		} elseif($_SERVER['REQUEST_METHOD'] == 'POST') { // Creates a new church
			
			$_POST['church_token'] = $this->generateID();
			$response = $this->registry->db->addChurch($_POST);
	
			if($response) {
				$this->returnData(array(
					'success' => true, 
					'message' => $_POST['name'] . ' has been registered',
					'church_id' => $response
				));
			} else {
				$this->returnData(array(
					'success' => false
				));
			}
			
		} elseif($_SERVER['REQUEST_METHOD'] == 'PUT') { // Updates a church
			
			$response = $this->registry->db->updateChurch($_REQUEST);
			if($response) {
				$this->returnData(array(
					'success' => true,
					'message' => $_REQUEST['name'] . ' has been updated',
				));
			} else {
				$this->returnData(array('success' => false));
			}
			
		}
		
	}	
		
	
}

?>