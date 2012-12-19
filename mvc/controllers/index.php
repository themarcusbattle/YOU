<?php

Class indexController Extends baseController {

	public function index() {
		
		$join = array(
			'LEFT JOIN' => array(
				'places' => 'place_id'
			)
		);
		
		$this->registry->template->places = $this->registry->db->getManyRecords('places');
		$this->registry->template->projects = $this->registry->db->getManyRecords('projects',$join);
		$this->registry->template->show('index');
		
	}

}

?>
