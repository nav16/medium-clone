<?php
session_start();
// error_reporting(0);
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
require ('functions/general.php');
require ('functions/users.php');
require ('functions/posthandler.php');
// echo $current_file = basename(__FILE__);
$current_file = explode('/', $_SERVER['SCRIPT_NAME']);
$current_file = end($current_file);
// print_r($current_file);
if (logged_in() === true) {
    $session_user_id = $_SESSION['user_id'];
    $user_data = user_data($session_user_id, 'user_id', 'username', 'password',
            'first_name', 'last_name', 'email', 'password_recover', 
            'type', 'allow_email', 'profile');
 //   echo $user_data['username'];
    if (user_active($user_data['username']) === false) {
        session_destroy();
        header('Location: index.php');
        exit();
    }
    if ($current_file !== 'changepassword.php' && $user_data['password_recover'] == 1) {
        header('Location: changepassword.php?force');
        exit();
    }
} else {
    $session_user_id = 0;
}

// echo $user_data['type'];

$errors = array();
?>
