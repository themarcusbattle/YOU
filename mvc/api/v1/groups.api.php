<?php

class groupsApi extends api {

	public function index() {
		
		if($_SERVER['REQUEST_METHOD'] == 'GET') {	// Retrieves church data
			
			if(isset($_GET['group_id'])) {
				$response = $this->registry->db->getGroup($_GET);
				$this->returnData(array('group' => $response));
			} else {
				$response = $this->registry->db->getGroups($_GET);
				$this->returnData(array('groups' => $response));
			}
			
		} elseif($_SERVER['REQUEST_METHOD'] == 'POST') { // Creates a new church
			
			$response = $this->registry->db->addGroup($_POST);
	
			if($response) {
				$this->returnData(array(
					'success' => true, 
					'message' => $_POST['label'] . ' has been created',
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