<?php
	
	// Define which server we're on and their settings
	// {database type} - acceptable values are (mysql,dblib for sql)
	
	$server = array(
		'you.marcusbattle.com' => array(
			'database' => array(
				'type' => 'mysql',
				'host' => 'localhost',
				'dbname' => 'mbattle_you',
				'dbuser' => 'mbattle_you',
				'dbpass' => 'qh3FRUoXusoG'
			),
			'root' => '/',
			'mode' => 'production'
		),
		'marcbook.local' => array(
			'database' => array(
				'type' => 'mysql',
				'host' => 'localhost',
				'dbname' => 'project_you',
				'dbuser' => 'chozinwun',
				'dbpass' => ''
			),
			'root' => '/mb/you/',
			'mode' => 'development'
		)
	);
	
	
	$tables = array(
		'users' => array(
			'primary_key' => 'user_id',
			'cols' => array(
				'user_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'first_name' => 'VARCHAR(50)',
				'last_name' => 'VARCHAR(50)',
				'email' => 'VARCHAR(128)'
			)
		),
		'places' => array(
			'primary_key' => 'place_id',
			'cols' => array(
				'place_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'name' => 'VARCHAR(50)',
				'date_created' => 'DATETIME'
			)
		),
		'roles' => array(
			'primary_key' => 'role_id',
			'cols' => array(
				'role_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'label' => 'VARCHAR(50)',
				'place_id' => 'INT(11)',
				'date_created' => 'DATETIME'
			)
		),
		'projects' => array(
			'primary_key' => 'project_id',
			'cols' => array(
				'project_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'name' => 'VARCHAR(50)',
				'place_id' => 'INT(11)',
				'date_created' => 'DATETIME'
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
	}
	
	
	// Define which mode your app is in (Acceptable values = test,development,production)
	define ('__APP_MODE', $server[$_SERVER['HTTP_HOST']]['mode']);
	
	// Initialize any databases you've created in mvc/models
	$registry->db = new db_local($server[$_SERVER['HTTP_HOST']]['database'],$tables);
	$registry->server = $server;
	$registry->tables = $tables;
	
	require_once("app/classes/stripe/Stripe.php");
	Stripe::setApiKey("sk_0GPS3IYXhOF1TDkZTb9S7GaHznsZA");
?>