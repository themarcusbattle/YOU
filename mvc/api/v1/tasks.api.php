<?php
Class tasksApi Extends api {

	public function index() {
		if($_SERVER['REQUEST_METHOD'] == 'GET') { }
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$task_id = $this->registry->db->addOneRecord('tasks',$_POST);
			
			if ($task_id) {
				$this->returnData(array(
					'success' => true,
					'msg' => 'Task was created',
					'task_id' => $task_id
				));
			}
			
		}
		if($_SERVER['REQUEST_METHOD'] == 'PUT') { }
		if($_SERVER['REQUEST_METHOD'] == 'DELETE') { }
	}

} ?>