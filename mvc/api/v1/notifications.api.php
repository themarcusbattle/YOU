<?php

class notificationsApi extends api {

	public function index() {
		
		if($_SERVER['REQUEST_METHOD'] == 'GET') {	// Retrieves church data
			
			if(isset($_GET['types']) && ($_GET['types'] == 'true')) {
			
				$response = $this->registry->db->getNotificationTypes($_GET);
				
				if($response) {
					$this->returnData(array(
						'notification_types' => $response
					));
				} else {
					$this->returnData(array(
						'notification_types' => $response,
						'message' => 'no notification types set'
					));
				}
				
			} else if(isset($_GET['notification_id'])) {
				$response = $this->registry->db->getNotification($_GET);
				
				if($response) {
					$this->returnData(array(
						'notification' => $response
					));
				} else {
					$this->returnData(array(
						'notification' => $response,
						'message' => 'notification does not exist'
					));
				}
			} else {
				$response = $this->registry->db->getNotifications($_GET);
				
				if($response) {
					$this->returnData(array(
						'notifications' => $response
					));
				} else {
					$this->returnData(array(
						'notifications' => $response,
						'message' => 'no notifications sent'
					));
				}
			}
			
			
		} elseif($_SERVER['REQUEST_METHOD'] == 'POST') { // Creates a new church
			
			// check who it's being sent to 
			// e.g. if ($_POST['to'] == 'all') do something
			// e.g. if ($_POST['to'] == 'all') do something
			
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