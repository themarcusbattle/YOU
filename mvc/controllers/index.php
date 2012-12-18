<?php

Class indexController Extends baseController {

	public function index() {
		
		$this->registry->template->places = $this->registry->db->getManyRecords('places');
		$this->registry->template->projects = $this->registry->db->getManyRecords('projects');
		$this->registry->template->show('index');
		
	}

}

?>
