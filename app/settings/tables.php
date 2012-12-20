<?php
	
	$tables = array(
		'users' => array(
			'primary_key' => 'user_id',
			'cols' => array(
				'user_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'first_name' => 'VARCHAR(50)',
				'last_name' => 'VARCHAR(50)',
				'email' => 'VARCHAR(128)',
				'date_created' => 'TIMESTAMP DEFAULT NOW()',
				'deleted' => 'INT(1) DEFAULT 0'
			)
		),
		'places' => array(
			'primary_key' => 'place_id',
			'cols' => array(
				'place_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'place_name' => 'VARCHAR(50)',
				'date_created' => 'TIMESTAMP DEFAULT NOW()',
				'deleted' => 'INT(1) DEFAULT 0'
			)
		),
		'roles' => array(
			'primary_key' => 'role_id',
			'cols' => array(
				'role_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'label' => 'VARCHAR(50)',
				'place_id' => 'INT(11)',
				'date_created' => 'TIMESTAMP DEFAULT NOW()',
				'deleted' => 'INT(1) DEFAULT 0'
			)
		),
		'projects' => array(
			'primary_key' => 'project_id',
			'cols' => array(
				'project_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'project_name' => 'VARCHAR(50)',
				'place_id' => 'INT(11)',
				'date_created' => 'TIMESTAMP DEFAULT NOW()',
				'deleted' => 'INT(1) DEFAULT 0'
			)
		),
		'tasks' => array(
			'primary_key' => 'task_id',
			'cols' => array(
				'task_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'task' => 'VARCHAR(140)',
				'project_id' => 'INT(11)',
				'parent_task_id' => 'INT(11)',
				'is_milestone' => 'INT(1) DEFAULT 0',
				'completed' => 'DATETIME',
				'date_created' => 'TIMESTAMP DEFAULT NOW()',
				'deleted' => 'INT(1) DEFAULT 0'
			)
		)
	);

	// Define Controllers for each table
	foreach ($tables as $table => $cols) {
		
		// Create Controllers
		if (!file_exists('mvc/controllers/' . $table . '.php')) {
			$file = $table . '.php';
			$filePath = 'mvc/controllers/' . $file;
		
			$fileStatus = fopen($filePath, 'w') or die("can't create file");
			
			$data  = '<?php';
			$data .= "\n" . 'Class ' . $table . 'Controller Extends baseController {';
			$data .= "\n";
			$data .= "\n\t" . 'public function index() {';
			$data .= "\n\t\t" .	'echo "Please setup this controller";';
			$data .= "\n\t" . '}';
			$data .= "\n";
			$data .= "\n" . '} ?>';
			
			fwrite($fileStatus, $data);
			fclose($fileStatus);
			
		} else {
			//echo $table . '.php already exits'; 
		}
		
		// Create api classes
		if (!file_exists('mvc/api/v' . $server[$_SERVER['HTTP_HOST']]['api'] . '/' . $table . '.api.php')) {
			$file = $table . '.api.php';
			$filePath = 'mvc/api/v' . $server[$_SERVER['HTTP_HOST']]['api'] . '/' . $file;
		
			$fileStatus = fopen($filePath, 'w') or die("can't create file");
			
			$data  = '<?php';
			$data .= "\n" . 'Class ' . $table . 'Api Extends api {';
			$data .= "\n";
			$data .= "\n\t" . 'public function index() {';
			$data .= "\n\t\t" .	'if($_SERVER[\'REQUEST_METHOD\'] == \'GET\') { }';
			$data .= "\n\t\t" .	'if($_SERVER[\'REQUEST_METHOD\'] == \'POST\') { }';
			$data .= "\n\t\t" .	'if($_SERVER[\'REQUEST_METHOD\'] == \'PUT\') { }';
			$data .= "\n\t\t" .	'if($_SERVER[\'REQUEST_METHOD\'] == \'DELETE\') { }';
			$data .= "\n\t" . '}';
			$data .= "\n";
			$data .= "\n" . '} ?>';
			
			fwrite($fileStatus, $data);
			fclose($fileStatus);
			
		} else {
			//echo $table . '.api.php already exits'; 
		}

	}
	
?>