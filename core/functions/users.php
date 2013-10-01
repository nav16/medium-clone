<?php


	function change_profile_image($user_id, $file_temp, $file_extn) {
		$file_path =  'images/profile/' . substr(md5(time()), 0, 10) . '.' . $file_extn;
		move_uploaded_file($file_temp, $file_path);
					
		global $db;
		$query = $db->prepare("UPDATE `users` 
						SET `profile` = '$filepath' 
						WHERE `user_id` = :user_id");
		$query->bindValue(':file_path', $file_path);
		$query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	    $query->execute();					
	}

	function mail_users($subject, $body) {
	
		global $db;
	   $query = $db->query("SELECT `email`, `first_name` 
							  FROM `users` 
							  WHERE `allow_email` = 1");		
		 		
		while (($row=$query->fetch(PDO::FETCH_ASSOC)) !== false) {	
			email($row['email'], $subject, "Hello " . $row['first_name'] . ",\n\n" . $body);
		}
	}

	// function is_admin($user_id) {
	//    $user_id = (int)$user_id;
	//    $query = mysql_query("SELECT COUNT(`user_id`) 
	//                          FROM `users` 
	//                          WHERE `user_id` = $user_id 
	//                          AND `type` = 1");
	//    return (mysql_result($query, 0) == 1) ? true : false;
	// }

	function has_access($user_id, $type) {
		
		global $db;
		$query = $db->prepare("SELECT COUNT(`user_id`) as `count`,
							  FROM `users` 
							  WHERE `user_id` = :user_id 
							  AND `type` = :type");
		$query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$query->bindValue(':type', $type, PDO::PARAM_INT);
	    $query->execute();
		
		$count = $query->fetch(PDO::FETCH_ASSOC);
	    $count = $count['count'];
		return ($count == 1) ? true : false;
			
		
	}

	function recover($mode, $email) {		
		
		$user_data = user_data(user_id_from_email($email), 'user_id', 'first_name', 'username');
		
		if ($mode == 'username') {
			// recover username
			email($email, 'Your username', "Hello " . $user_data['first_name'] . ",\n\nYour username is: " . $user_data['username'] . "\n\n-sparklet");
		} else if ($mode == 'password'){
			// recover password
			$generated_password = substr(md5(rand(999, 999999)), 0, 8);
			// die($generated_password);
			change_password($user_data['user_id'], $generated_password);
			
			update_user($user_data['user_id'], array('password_recover' => '1'));
			
			email($email, 'Your password recovery', "Hello " . $user_data['first_name'] . ",\n\nYour new password is: " . $generated_password . "\n\n-sparklet");
		}
	}

	function update_user($user_id, $update_data) {
	//    global $session_user_id;
		$update = array();
				
		foreach($update_data as $field=>$data) {
			$update[] = ' `' . $field . '` = \'' . $data . '\'';
		}
		
	//    print_r($update);
	//    echo implode(', ', $update);
	//    die();
	 
	// option with global:    
	//    mysql_query("UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` = $session_user_id");
	// option without global:
	//    mysql_query("UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` = " . $_SESSION['user_id']) or die(mysql_error());
	// option with $user_id
		/* mysql_query("UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` = $user_id"); */
		
		
			global $db;
		$query = $db->prepare("UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` = :user_id");	
		$query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	    $query->execute();		
		
	}
		
	function activate($email, $email_code) {
			// query to update user active status						
		global $db;	
		$query = $db->prepare("SELECT COUNT(`user_id`) as `count`
						FROM `users` 
						WHERE `email` = :email 
						AND `email_code` = `:email_code` 
						AND `active` = 0");
			$query->bindParam(':email', $email);
			$query->bindparam(':email_code', $email_code);
			$query->execute();	
			$count = $query->fetch(PDO::FETCH_ASSOC);
			$count = $count['count'];		
						
		
		if ($count == 0) {		
						 
			$query1 = $db->prepare("UPDATE `users` SET `active` = 1 
						 WHERE `email` = :email");
			$query1->bindParam(':email', $email);
			$query1->execute();						 
			return true;
		} else {
			return false;
		}
	}

	function change_password($user_id, $password) {
		$password = md5($password);		
				
		global $db;	
		$query = $db->prepare("UPDATE `users` 
					SET `password` = :password, 
					`password_recover` = 0   
					WHERE `user_id` = :user_id");
			$query->bindValue(':password', $password);		
			$query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$query->execute();							
	}

	function register_user($register_data) {
		
		$register_data['password'] = md5($register_data['password']);

		$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
			$data = '\'' . implode('\', \'', $register_data) . '\'';
			
		global $db;	
		$query = $db->prepare("INSERT INTO `users` ($fields) VALUES ($data)");
		$query->execute();	
		
		
		email($register_data['email'], 'Activate your account', "
		Hello " . $register_data['first_name'] . ",\n\n
		You need to activate your account, so use the link below:\n\n
		http://blog.iteching.info/activate.php?email=" . $register_data['email'] . "&email_code=" . $register_data['email_code'] . "\n\n
		
		link
		
		- sparklet
		");
	}


	function user_count() {
	
	 global $db;
		$query = $db->prepare("SELECT COUNT(`user_id`) as `count`
							  FROM `users` 
							  WHERE `active` = 1");
		$query->execute();
		$count = $query->fetch(PDO::FETCH_ASSOC);
	    $count = $count['count'];
		return $count;

	}

	function user_data($user_id) {
		$data = array();
		$func_num_args = func_num_args();
		$func_get_args = func_get_args();
		if ($func_num_args > 1) {
			unset($func_get_args[0]);

			$fields = '`' . implode('`, `', $func_get_args) . '`';
							
			global $db;
			$query = $db->prepare("SELECT $fields
								  FROM `users` 
								  WHERE `user_id`=:user_id");
			$query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$query->execute();
			$data = $query->fetch(PDO::FETCH_ASSOC);			
			
			return $data;
		}

	}

	function logged_in() {
		return (isset($_SESSION['user_id'])) ? true : false;
	}

	function user_exists($username) {
		
		global $db;
		$user = strtolower($username);
		$query = $db->prepare("SELECT COUNT(`user_id`) as `count`
						FROM `users` 
						WHERE `username`= :username");
		$query->bindParam(':username', $username);
		$query->execute();
		$count = $query->fetch(PDO::FETCH_ASSOC);
	    $count = $count['count'];
		return ($count == 1) ? true : false;	
		
	}

	function email_exists($email) {	
		
	    global $db;
		$query = $db->prepare("SELECT COUNT(`user_id`) as `count`
						FROM `users` 
						WHERE `email`= :email");
		$query->bindParam(':email', $email);
		$query->execute();
		$count = $query->fetch(PDO::FETCH_ASSOC);
	    $count = $count['count'];
		return ($count == 1) ? true : false;		
		
	}
	

	function user_active($username) {

		global $db;
		$query = $db->prepare("SELECT COUNT(`user_id`) as `count`
						FROM `users` 
						WHERE `username` = :username AND `active` = 1");
		$query->bindParam(':username', $username);	
		$query->execute();
		$count = $query->fetch(PDO::FETCH_ASSOC);
	    $count = $count['count'];
		return ($count == 1) ? true : false;
		
	}
	
	
	function user_id_from_username($username) {	
		
		global $db;
		$query = $db->prepare("SELECT `user_id` 
						FROM `users` 
						WHERE `username`= :username ");
		$query->bindParam(':username', $username);
		$query->execute();
		$query->execute();	
		return $query->fetchColumn();
		
	}

	function user_id_from_email($email) {
		
		global $db;
		$query = $db->prepare("SELECT `user_id` 
						FROM `users` 
						WHERE `email`= :emai");
		$query->bindParam(':email', $email);
		$query->execute();	
		return $query->fetchColumn();
	}

	function login($username, $password) {
	
		global $db;
		$user_id = user_id_from_username($username);
		$password = md5($password);
		$query = $db->prepare("SELECT COUNT(`user_id`) as `count`
						FROM `users` 
						WHERE `username`= :username AND `password`= :password");
		$query->bindParam(':username', $username);
		$query->bindParam(':password', $password);
		$query->execute();
		$result= $query->fetch(PDO::FETCH_ASSOC);
	    $count = $result['count'];
		return ($count == 1) ? $user_id : false;	
	
	}
	function Gravatar($user_id){	 
		global $db;	
		$query = $db->prepare("SELECT email FROM `users` WHERE user_id = :user_id");
		$query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$query->execute();
		$row= $query->fetch(PDO::FETCH_ASSOC);			
	    if(!empty($row))
	     {
			$email = md5(strtolower($row['email']));
			$fkimg = urlencode('http://localhost/medium/images/default.png');
			$data="http://www.gravatar.com/avatar/$email?d=$fkimg";
			return $data;
         }
	  }


?>
