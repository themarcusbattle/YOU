<?php
Class projectsController Extends baseController {

	public function index() {

	}
	
	public function view() {
		$uri = array_reverse(explode('/',$_SERVER['REQUEST_URI']));
		$project_id = $uri[0];
		
		
		$where = array('project_id' => array('=' => $project_id));
		$project = $this->registry->db->getOneRecord('projects',$where);
		
		$join = array('LEFT JOIN' => array('projects' => 'project_id'));
		$where = array('tasks.deleted' => array('=' => 0));
		$tasks = $this->registry->db->getManyRecords('tasks',$join,$where);
		
		$this->registry->template->project = $project;
		$this->registry->template->tasks = $tasks;
		$this->registry->template->show('projects/view-single');
	}

} ?>