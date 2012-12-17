<?php

class contributionsApi extends api {

	public function index() {
		
		if($_SERVER['REQUEST_METHOD'] == 'GET') {	// Retrieves user data
			
			if(isset($_GET['user_id'])) {
			
				$response = $this->registry->db->getUserContributions($_GET);
				
				if($response) {
					$this->returnData(array(
						'contributions' => $response
					));
				} else {
					$this->returnData(array(
						'contributions' => $response,
						'message' => 'No contributions for the user'
					));
				}
				
			} elseif(isset($_GET['contribution_id'])) {
				$response = $this->registry->db->getContribution($_GET);
				
				if($response) {
					$this->returnData(array(
						'contribution' => $response
					));
				} else {
					$this->returnData(array(
						'contributions' => $response,
						'message' => 'Contribution does not exist'
					));
				}
			} else {
				$response = $this->registry->db->getContributions($_GET);
				
				if($response) {
					$this->returnData(array(
						'contributions' => $response
					));
				} else {
					$this->returnData(array(
						'contributions' => $response,
						'message' => 'No contributions for this church'
					));
				}
			}
			
		} elseif($_SERVER['REQUEST_METHOD'] == 'POST') { // Creates a new user
			
			if($_POST['payment_method'] == 'credit') {
				echo "you chose credit!";
			}
			
			print_r($_POST);exit;
			
			$_POST['payment_token'] = $this->generateID();
			$response = $this->registry->db->addContribution($_POST);
			
			if($response) {
				$this->returnData(array(
					'success' => true, 
					'message' => 'Contribution submitted successfully',
					'contribution_id' => $response
				));
			} else {
				$this->returnData(array(
					'success' => false
				));
			}
			
		} elseif($_SERVER['REQUEST_METHOD'] == 'PUT') { // Updates a church
			
			$response = $this->registry->db->updateContribution($_REQUEST);
			
			if($response) {
				$this->returnData(array(
					'success' => true,
					'message' => 'Contribution has been updated',
				));
			} else {
				$this->returnData(array('success' => false));
			}
		}
		
	}	
		
	
}

?>