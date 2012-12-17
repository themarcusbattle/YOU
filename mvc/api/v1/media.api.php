<?php

class mediaApi extends api {

	public function index() {
		
		if($_SERVER['REQUEST_METHOD'] == 'GET') {	// Retrieves user data

			if(isset($_GET['media_id'])) {
				$response = $this->registry->db->getMedia($_GET);
				
				if($response) {
					$this->returnData(array(
						'media' => $response
					));
				} else {
					$this->returnData(array(
						'media' => $response,
						'message' => 'media does not exist'
					));
				}
			} else {
				$response = $this->registry->db->getAllMedia($_GET);
				
				if($response) {
					$this->returnData(array(
						'media' => $response
					));
				} else {
					$this->returnData(array(
						'media' => $response,
						'message' => 'No media for this church'
					));
				}
			}
			
		} elseif($_SERVER['REQUEST_METHOD'] == 'POST') { // Creates a new user
			
			$response = $this->registry->db->addMedia($_POST);
	
			if($response) {
				$this->returnData(array(
					'success' => true, 
					'message' => $_POST['media_title'] . ' has been added to the media collection',
					'media_id' => $response
				));
			} else {
				$this->returnData(array(
					'success' => false
				));
			}
			
		} elseif($_SERVER['REQUEST_METHOD'] == 'PUT') { // Updates a church
			
			$response = $this->registry->db->updateMedia($_REQUEST);
			if($response) {
				$this->returnData(array(
					'success' => true,
					'message' => $_REQUEST['title'] . ' has been updated',
				));
			} else {
				$this->returnData(array('success' => false));
			}
		}
		
	}	
		
	
}

?>