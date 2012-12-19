<?php
Class projectsApi Extends api {

	public function index() {
		if($_SERVER['REQUEST_METHOD'] == 'GET') { 
			$projects = $this->registry->db->getManyRecords('projects');
			$this->returnData(array('projects' => $projects));
		}
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			if ($_POST['place_id'] == 'new') {
				$place = array(
					'place_name' => $_POST['place_name']
				);
				$_POST['place_id'] = $this->registry->db->addOneRecord('places',$place);
			}
			
			unset($_POST['place_name']);
			$project_id = $this->registry->db->addOneRecord('projects',$_POST);
			
			if ($project_id) {
				$this->returnData(array(
					'success' => true,
					'msg' => 'Project was created',
					'project_id' => $project_id
				));
			}
		}
		
		if($_SERVER['REQUEST_METHOD'] == 'PUT') { }
		
		if($_SERVER['REQUEST_METHOD'] == 'DELETE') { 
			//$this->registry->db->updateOneRecord('places',$_POST);
		}
	}

} ?>