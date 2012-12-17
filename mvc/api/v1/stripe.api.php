<?php
require_once("app/classes/stripe/Stripe.php");

class stripeApi extends api {

	public function index() {
		self::churches();
	}	
	
	public function users() {
		
		if($_SERVER['REQUEST_METHOD'] == 'GET') { // Get Stripe user
			
			echo "undefined";
			
		} else if($_SERVER['REQUEST_METHOD'] == 'POST') {
		
			Stripe::setApiKey("sk_test_0QoZWJl2mV2fQRgg4G6UrTHw");
			$stripe = Stripe_Customer::create(array(
			  "description" => $_REQUEST['first_name'] . ' ' . $_REQUEST['last_name'] . ' - ' . $_REQUEST['email'],
			  "email" => $_REQUEST['email']
			));
			
			$this->returnData(array('stripe_id' => $stripe['id']));
		
		} else if($_SERVER['REQUEST_METHOD'] == 'PUT') {
			
			Stripe::setApiKey("sk_test_0QoZWJl2mV2fQRgg4G6UrTHw");
			
			// Create credit card token
			$token = Stripe_Token::create(array(
			    "card" => array(
			    "number" => $_REQUEST['credit_card'],
			    "exp_month" => 12,
			    "exp_year" => 2016,
			    "cvc" => $_REQUEST['cvc_code']
			  ),
			));
			$token = json_decode($token,true);
			
			// Get Stripe user details
			$cu = Stripe_Customer::retrieve($_REQUEST['stripe_id']);
			$cu->card = $token['id'];
			$response = $cu->save();
			$response = json_decode($response,true);
			
			// Update last4 in Steeple Account
			$user_updated = $this->registry->db->updateLast4($response);
			$this->returnData($user_updated);
		
		}
	}
	
	public function churches() {
	
		if($_SERVER['REQUEST_METHOD'] == 'GET') { // Find stripe acct for church
			
			$hasAcct = $this->registry->db->findStripeAcct($_GET);
			$this->returnData($hasAcct);
			
		} else if($_SERVER['REQUEST_METHOD'] == 'POST') { // POST REQUEST
			
			if(isset($_REQUEST['access_token'])) { // Add stripe account for church
				
				$response = $this->registry->db->addStripeAcct($_REQUEST);
				$this->returnData($response);	
		
			}
		}
	
	}	
		
}

?>