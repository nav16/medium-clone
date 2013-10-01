<?php 

include_once('../core/init.php');
protect_page();
$post_id = trim($_POST['post_id']);
		
try
  {
		global $db;
		$query = $db->prepare("UPDATE `posts` 
						SET `view` = 0 
						WHERE `id` = :post_id");
		//$query->bindValue(':post_data', $post_data);
		$query->bindValue(':post_id', $post_id, PDO::PARAM_INT);
	    $query->execute(); 
 
  }
catch (customException $e)
  {  
  error_log($e->errorMessage());
  }

?>