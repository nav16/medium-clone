<?php
include "core/init.php";
if (isset($_GET['username']) === true && empty($_GET['username']) === false) {
    $username = $_GET['username'];

    if (user_exists($username) === true) {
        $user_id = user_id_from_username($username);
        $profile_data = user_data($user_id, 'username', 'first_name', 'last_name', 'bio');

  $fname =  $profile_data['first_name'];
  $lname = 	$profile_data['last_name'];
  $bio = $profile_data['bio'];
  $uname = $profile_data['username'];
  $pimg = Gravatar($user_id);
        } else {
        echo 'Sorry, that user doesn\'t exist!';
			header('Location: index.php');
		exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>


<!DOCTYPE HTML>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">

<html class="screen-scroll wf-fftisawebpro-i4-active wf-fftisawebpro-i7-active wf-fftisawebpro-n4-active wf-fftisawebpro-n7-active wf-freightsanspro-n5-active wf-freightsanspro-n7-active wf-active">
<title><?=$fname?> <?=$lname?> -- Broomble</title>
<link href="css/profile.css" rel="stylesheet" type="text/css" media="screen">
	<script src="js/jquery.min.js"></script>
<body>
<div class="site-nav-overlay"></div>
<div class="container" id="container">
 <div class="butter-bar error"></div>
 <div class="surface" style="display: block; visibility: visible;">
  <div tabindex="-1" class="screen-content">
   <aside class="cover cover-user picker-target no-image" data-load-img=".cover-img">
   <button class="site-nav-logo"><span class="icons icons-logo-m"></span></button>
   <div class="cover-table">
    <div class="cover-row">
     <div class="cover-img"></div>
    </div>
    <div class="cover-row">
     <div class="cover-body">
      <div class="cover-body-inner">
       <span class="cover-avatar" data-username="<?=$uname?>"><img title="<?=$fname?> <?=$lname?>" src="<?=$pimg?>"/></span>
       <h1 class="cover-title">
        <?=$fname?> <?=$lname?>
       </h1>
       <p class="cover-description">
        <?=$bio?>
       </p>
	   <br>
	   <?php if($session_user_id == $user_id) :?>
	   <div class="cover-actions">
		   <button class="btn btn-edit" title="Edit Profile" data-action="edit-profile">Edit profile</button>
		   <button class="btn btn-primary btn-save" title="Save Profile" data-action="save-profile" style="display: none;">Save</button>
		   <button class="btn btn-cancel" title="Cancel Edits" data-action="cancel-edit" style="display: none;">Cancel</button>
	   </div>
	   <?php endif;?>
      </div>
     </div>
    </div>
   </div>
   </aside><section tabindex="-1" class="wrapper">
   <div class="wrapper-inner">   
   
    <div class="bucket post-bucket">
     <div class="bucket-header show-subtitles-variant">
      <nav class="bucket-sort">
      <h5 class="bucket-title">
       <span class="bucket-header-title">Posted by <?=$fname?> <?=$lname?></span>
      </h5>
      </nav>
     </div>
	 
	<?php global $db;
		$query = $db->prepare("SELECT * FROM posts WHERE view = 1 AND fk_u_id = :user_id ORDER BY id DESC");
		$query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$query->execute();	
			
		while($data = $query->fetch(PDO::FETCH_ASSOC)) :
			
			 $id=$data['id'];
			 $title=$data['title'];				 
			 $date = $data['datetime'];
			 $date = date('F d Y', $date);			 
	 	?> 
	 <article class="post-item post-item-grid hide-author post-status- show-subtitles-variant"><a title="Go to the profile of <?=$fname?> <?=$lname?>" href="/@marynmck"></a><a title="Go to the profile of <?=$fname?> <?=$lname?>" href="/<?=$uname?>"><img title="<?=$fname?> <?=$lname?>" class="post-item-avatar" src="<?=$pimg?>" /></a>
     <h3 class="post-item-title">
      <a title="<?=$title?> by <?=$fname?> <?=$lname?>" href="/post/<?=$id?>" data-action="open-post"><?=$title?></a>
     </h3>
     <ul class="post-item-meta">
  
      <li class="post-item-meta-item">
       <span class="reading-time"><?=$date?></span>
      </li>
     </ul>
     </article>
	 
<?php endwhile;?>
	 	 

    </div>
	
	


	<div class="bucket post-bucket">
     <div class="bucket-header show-subtitles-variant">
      <nav class="bucket-sort">
      <h5 class="bucket-title">
       <span class="bucket-header-title">Drafts</span>
      </h5>
      </nav>
     </div>
	 
	 <?php global $db;
		$query = $db->prepare("SELECT * FROM posts WHERE view = 0 AND fk_u_id = :user_id ORDER BY id DESC");
		$query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$query->execute();	
			
		while($data = $query->fetch(PDO::FETCH_ASSOC)) :
			
			 $id=$data['id'];
			 $title=$data['title'];				 
			 $date = $data['datetime'];
			 $date = date('F d Y', $date);			 
	 	?> 	 
	 
	 <article class="post-item post-item-grid hide-author post-status- show-subtitles-variant"><a title="Go to the profile of <?=$fname?> <?=$lname?>" href="/<?=$uname?>"></a><a title="Go to the profile of <?=$fname?> <?=$lname?>" href="/<?=$uname?>"><img title="<?=$fname?> <?=$lname?>" class="post-item-avatar" src="<?=$pimg?>" /></a>
     <h3 class="post-item-title">
      <a title="<?=$title?> by <?=$fname?> <?=$lname?>" href="/post/<?=$id?>" data-action="open-post"><?=$title?></a>
     </h3>
     <ul class="post-item-meta">
  
      <li class="post-item-meta-item">
       <span class="reading-time"><?=$date?></span>
      </li>
     </ul>
     </article>
	 
	 
<?php endwhile;?>

    </div>
	
	
   </div>
   </section>
  </div>
 </div>
</div>
<div class="loading-bar"></div>
<script>
$('button').click(function(e) {
			var val = $(this).data( "action" );
			switch (val) {
			case 'edit-profile' :		
				$(this).css('display','none');
				$('.cover-title').attr('contenteditable', 'true');
				$('.cover-description').attr('contenteditable', 'true');
				$('.cover-title').focus();	
				$('button[data-action="save-profile"]').css('display','');
				$('button[data-action="cancel-edit"]').css('display','');
			  break;
			case 'save-profile' :					
					var name_user = $.trim($('.cover-avatar').data('username'));								
					var name_data = $.trim($('.cover-title').text());					
					var bio_data = $.trim($('.cover-description').text());
					var dataString = 'name_user=' + name_user + '&name_data=' + name_data + '&bio_data=' + bio_data;					
						$.ajax({
						type: "POST",
						url: "ajax/profile_s.php",
						data: dataString,
						cache: false,						
						success: function(response){												
							$('.cover-title').attr('contenteditable', 'false');
							$('.cover-description').attr('contenteditable', 'false');						
							$('button[data-action="edit-profile').css('display','');
							$('button[data-action="save-profile"]').css('display','none');
							$('button[data-action="cancel-edit"]').css('display','none');
						}						
					});
				  break;	
			case 'cancel-edit' :				
				$('.cover-title').attr('contenteditable', 'false');
				$('.cover-description').attr('contenteditable', 'false');
				$('button[data-action="edit-profile').css('display','');
				$('button[data-action="save-profile"]').css('display','none');
				$('button[data-action="cancel-edit"]').css('display','none');
			  break;		  	
		  }
			
});		
	
    </script>

</body>
</html>