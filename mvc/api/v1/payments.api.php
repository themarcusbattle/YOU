<?php
//require_once("app/classes/stripe/Stripe.php");

class paymentsApi extends api {

	public function index() {
	
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			//$this->returnData(array('message' => "You're trying to get that payment information aren't you?!"));
			$this->returnData($_GET);
		} elseif($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			//$this->returnData(array());
			//$this->returnData($_POST);
			
			print_r($_POST);
			exit;
			
			$response = $this->registry->db_local->saveContributions($_POST);
			if($response) {
				$this->returnData(array('success' => true));
			} else {
				$this->returnData(array('success' => false));
			}
		}
		
	}	
		
	
}

?>