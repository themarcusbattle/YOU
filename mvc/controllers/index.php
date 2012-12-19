<?php

Class indexController Extends baseController {

	public function index() {
		
		$join = array('LEFT JOIN' => array('places' => 'place_id'));
		$where = array('deleted' => array('=' => 0));
		
		$this->registry->template->places = $this->registry->db->getManyRecords('places');
		$this->registry->template->projects = $this->registry->db->getManyRecords('projects',$join,$where);
		$this->registry->template->show('index');
		
	}

}

?>
