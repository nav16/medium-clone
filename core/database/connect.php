<?php
$config['db'] = array(
	'host' 			=> 'localhost',
	'username'		=> 'root',
	'password'		=> '',
	'dbname'		=> 'medium'
);

try {
	$db = new PDO('mysql:host=' .$config['db']['host'] . ';dbname=' . $config['db']['dbname'], $config['db']['username'], $config['db']['password']);
}
catch(PDOException $e) { 
    echo $e->getMessage();
}
?>
