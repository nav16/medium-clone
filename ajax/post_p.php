<?php 
include_once('../core/init.php');
protect_page();
$post_title = trim(strip_tags($_POST['post_title']));
$post_sub = trim(strip_tags($_POST['post_sub']));
$post_data = trim(htmlspecialchars($_POST['post_data'], ENT_QUOTES)); 
$post_id = trim($_POST['post_id']);
$views = $_POST['post_view'];
$datetime = time(); //create date time
if(empty($post_id)) :
try
  {
		global $db;
		$query = $db->prepare("INSERT INTO `posts`(`title`, `subtitle`, `post`, `datetime`,`view`, `fk_u_id`) VALUES ('$post_title', '$post_sub', '$post_data', $datetime, $views, :user_id)");
	/* 	
		$query->bindParam(':post_title', $post_title);
		$query->bindParam(':post_sub', $post_sub);
		$query->bindParam(':post_data', $post_data);*/
		$query->bindParam(':user_id', $session_user_id); 
	    $query->execute();
 }
catch (Exception $e)
  {  
  error_log($e->errorMessage());
  }
else :

try
  {
		global $db;
		$query = $db->prepare("UPDATE `posts` 
						SET `post` = :post_data, `view` = 1 , `datetime` = $datetime
						WHERE `id` = :post_id");
		$query->bindValue(':post_data', $post_data);
		$query->bindValue(':post_id', $post_id, PDO::PARAM_INT);
	    $query->execute(); 
 
  }
catch (customException $e)
  {  
  error_log($e->errorMessage());
  }
  
 endif;

?>