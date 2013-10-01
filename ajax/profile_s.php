<?php 
include_once('../core/init.php');
protect_page();
	$username = trim($_POST['name_user']);
	$name_data = trim($_POST['name_data']);
	$bio_data = trim($_POST['bio_data']);
	
 if($session_user_id == user_id_from_username($username)) :

	$words = explode(" ", $name_data);
	$fname = $words[0];
	$lname = $words[1];
	try
	  {
			global $db;
			$query = $db->prepare("UPDATE `users` 
							SET `first_name` = :fname, `last_name` = :lname, `bio` = :bio_data 
							WHERE `username` = :username");
			$query->bindValue(':fname', $fname);
			$query->bindValue(':lname', $lname);
			$query->bindValue(':bio_data', $bio_data);		
			$query->bindValue(':username', $username);
			$query->execute(); 
	 
	  }
	catch (customException $e)
	  {  
	  error_log($e->errorMessage());
	  }
endif;
?>