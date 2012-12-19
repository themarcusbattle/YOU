<?php
Class placesApi Extends api {

	public function index() {
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$places = $this->registry->db->getManyRecords('places');
			$this->returnData(array('places' => $places));
		}
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') { 
			$this->registry->db->addOneRecord('places',$_POST);
		}
		
		if($_SERVER['REQUEST_METHOD'] == 'PUT') { }
		
		if($_SERVER['REQUEST_METHOD'] == 'DELETE') { }
	}

} ?>