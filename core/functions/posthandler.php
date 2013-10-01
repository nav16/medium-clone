<?php

	function allPosts(){
				 
		global $db;
		$query = $db->prepare("SELECT * FROM posts WHERE view = 1 ORDER BY id DESC");
		$query->execute();	

		/* Fetch all of the remaining rows in the result set */
		$result = $query->fetchAll();
		
			return $result;
	}
	 
	
	 function getPost($id){
	 
		    global $db;
			$query = $db->prepare("SELECT * FROM posts WHERE id = :id");
		    $query->bindValue(':id', $id, PDO::PARAM_INT);
			$result = $query->execute();
				while($row = $result->fetch(PDO::FETCH_ASSOC)) :
				 $data[]=$row;
					 if(!empty($data))
					  {
						return $data;
					  }
				endwhile;
	  }

?>