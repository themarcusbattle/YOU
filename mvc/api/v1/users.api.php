<?php

class usersApi extends api {

	public function index() {
		
		if($_SERVER['REQUEST_METHOD'] == 'GET') {	// Retrieves user data

			if(isset($_GET['user_id'])) {
				$response = $this->registry->db->getUser($_GET);
				
				if($response) {
					$this->returnData(array(
						'user' => $response
					));
				} else {
					$this->returnData(array(
						'users' => $response,
						'message' => 'User does not exist'
					));
				}
			} else {
				$response = $this->registry->db->getUsers($_GET);
				
				if($response) {
					$this->returnData(array(
						'users' => $response
					));
				} else {
					$this->returnData(array(
						'users' => $response,
						'message' => 'No users for this church'
					));
				}
			}
			
		} elseif($_SERVER['REQUEST_METHOD'] == 'POST') { // Creates a new user
			
			// Create Stripe user via POST
			$curl = curl_init('http://marcbook.local/mb/steeple/api/1/stripe/users.json');
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		  curl_setopt($curl, CURLOPT_POST, true );
		  curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($_POST));
		  $stripe = json_decode(curl_exec($curl), true);
		  curl_close($curl);
			
			$_POST['stripe_id'] = $stripe['stripe_id'];
			$_POST['user_token'] = $this->generateID();
			$response = $this->registry->db->addUser($_POST);

			if($response) {
				$this->returnData(array(
					'success' => true, 
					'message' => $_POST['first_name'] . ' has been registered',
					'user_id' => $response
				));
			} else {
				$this->returnData(array(
					'success' => false
				));
			}
			
		} elseif($_SERVER['REQUEST_METHOD'] == 'PUT') { // Updates a church
			
			$response = $this->registry->db->updateUser($_REQUEST);
			if($response) {
				$this->returnData(array(
					'success' => true,
					'message' => $_REQUEST['first_name'] . ' has been updated',
				));
			} else {
				$this->returnData(array('success' => false));
			}
		}
		
	}	
		
	
}

?>