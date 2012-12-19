<?php
Class projectsController Extends baseController {

	public function index() {

	}
	
	public function view() {
		$uri = array_reverse(explode('/',$_SERVER['REQUEST_URI']));
		$project_id = $uri[0];
		
		$where = array(
			'project_id' => array(
				'=' => $project_id
			)
		);
		$project = $this->registry->db->getOneRecord('projects',$where);
		
		$this->registry->template->project = $project;
		$this->registry->template->show('projects/view-single');
	}

} ?>