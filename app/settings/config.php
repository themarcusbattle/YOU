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

	// Define which mode your app is in (Acceptable values = test,development,production)
	define ('__APP_MODE', $server[$_SERVER['HTTP_HOST']]['mode']);
	
	// Initialize any databases you've created in mvc/models
	$registry->db = new db_local($server[$_SERVER['HTTP_HOST']]['database']);
	
	require_once("app/classes/stripe/Stripe.php");
	Stripe::setApiKey("sk_0GPS3IYXhOF1TDkZTb9S7GaHznsZA");
?>