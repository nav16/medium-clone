<?php include "core/init.php"; 
$id = $_GET['id'];

$query = $db->prepare("SELECT * FROM posts WHERE id = :id");
	$query->bindValue(':id', $id, PDO::PARAM_INT);
	$query->execute();		
	$data = $query->fetch(PDO::FETCH_ASSOC);

if ((logged_in() === true) && $session_user_id == $data['fk_u_id']) :
	$query = $db->prepare("SELECT * FROM posts WHERE id = :id");
else :
	$query = $db->prepare("SELECT * FROM posts WHERE view = 1 AND id = :id");
endif;
			
			$query->bindValue(':id', $id, PDO::PARAM_INT);
			$query->execute();		
				while($data = $query->fetch(PDO::FETCH_ASSOC)) :

					 $id=$data['id'];
					 $title=$data['title'];
					 $subtitle=$data['subtitle'];
					 $post = strip_tags(htmlspecialchars_decode($data['post']), '<p><a><b><i><u><h4><h3><q>');
					 $date = $data['datetime'];
					 $date = date('F d Y', $date);
					 $userid =$data['fk_u_id'];
					 $view = $data['view'];
					 $user_data = user_data($userid, 'username', 'first_name', 'last_name', 'type', 'bio');
					 $fname = $user_data['first_name'];
					 $lname = $user_data['last_name'];
					 $uname = $user_data['username'];
					 $bio= $user_data['bio'];
					 $pimg = Gravatar($userid);
					 
?>
<html>
	<head>
		<META http-equiv="Content-Type" content="text/html; charset=utf-8">	
		<link href="/medium/css/posts.css" rel="stylesheet" type="text/css" media="screen">	    
		<title><?=$title?></title>
    	<script src="/medium/js/jquery.min.js"></script>
<style>
article, aside, details, figcaption, figure, footer, header, hgroup, nav, section, summary
{
	display: block;
}
html
{
	font-size: 100%;
	-ms-text-size-adjust: 100%;
}
button, input, select, textarea
{
	font-family: sans-serif;
}
body
{
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	margin-left: 0px;
}
dl, menu, ol, ul
{
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	margin-left: 0px;
}
menu, ol, ul
{
	padding-top: 0px;
	padding-right: 0px;
	padding-bottom: 0px;
	padding-left: 0px;
	list-style-type: none;
	list-style-position: outside;
	list-style-image: none;
}
button, input, select, textarea
{
	font-size: 100%;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	margin-left: 0px;
	vertical-align: baseline;
}
button, input
{
	line-height: normal;
}
button, input[type='button'], input[type='reset'], input[type='submit']
{
	cursor: pointer;
}
html, body, .container
{
	height: 100%;
}
.screen-scroll, .screen-scroll > body, .screen-scroll .container
{
	overflow: hidden;
}
body
{
	color: #333332;
	line-height: 1.4;
	font-family: "ff-tisa-web-pro",Georgia,Cambria,"Times New Roman",Times,serif;
	font-size: 18px;
	font-weight: 400;
}
.btn
{
	height: 40px;
	text-align: center;
	color: #666665;
	line-height: 39px;
	padding-top: 0px;
	padding-right: 20px;
	padding-bottom: 0px;
	padding-left: 20px;
	font-family: "freight-sans-pro","Myriad Pro","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Geneva,Verdana,sans-serif;
	font-size: 14px;
	font-style: normal;
	font-weight: 400;
	text-decoration: none;
	vertical-align: bottom;
	border-top-color: currentColor;
	border-right-color: currentColor;
	border-bottom-color: rgba(0,0,0,0.1);
	border-left-color: currentColor;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 1px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	display: inline-block;
	position: relative;
	cursor: pointer;
	box-sizing: border-box;
	border-top-left-radius: 3px;
	border-top-right-radius: 3px;
	border-bottom-right-radius: 3px;
	border-bottom-left-radius: 3px;
	-ms-user-select: none;
	transition-property: all;
	transition-duration: 0.1s;
	transition-timing-function: ease;
	transition-delay: 0s;
	background-color: rgb(222, 222, 220);
}
.btn-small
{
	height: 34px;
	line-height: 35px;
}
.btn-primary
{
	color: #fff;
	background-color: rgb(87, 173, 104);
}
.metabar
{
	top: 0px;
	width: 100%;
	height: 65px;
	color: #b3b3b1;
	font-family: "freight-sans-pro","Myriad Pro","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Geneva,Verdana,sans-serif;
	font-size: 14px;
	font-weight: 400;
	display: block;
	position: absolute;
	z-index: 500;
	box-sizing: border-box;
	pointer-events: none;
}
.active.metabar > .metabar-status
{
	left: 0px;
	top: 0px;
	position: fixed;
}
.metabar-actions
{
	top: 0px;
	right: 10px;
	position: absolute;
	pointer-events: visible;
}
.metabar-actions li
{
	margin-right: 4px;
	display: inline-block;
}
.metabar-actions .btn
{
	margin-top: 16px;
}
.metabar-actions-btns
{
	vertical-align: top;
	display: inline-block;
}
.metabar-message
{
	color: #666665;
	text-transform: uppercase;
	line-height: 44px;
	letter-spacing: 0.1em;
	padding-top: 0px;
	padding-right: 15px;
	padding-bottom: 0px;
	padding-left: 15px;
	font-family: "freight-sans-pro","Myriad Pro","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Geneva,Verdana,sans-serif;
	font-size: 11px;
	font-weight: 700;
	margin-top: 10px;
	margin-left: 54px;	
	position: relative;
	transition-property: margin-left;
	transition-duration: 0.3s;
	transition-timing-function: ease;
	transition-delay: 0s;
	background-color: rgba(255, 255, 255, 0.95);
}

</style>
	</head>
	<body>
	<button class="site-nav-logo"><span class="icons icons-logo-m"></span></button>
<?php if ((logged_in() === true) && $session_user_id == $userid) :?>		
	<div class="metabar active">  
     <section class="metabar-status">
 	<span class="metabar-message"></span></section> 
	
 <div class="metabar-actions metabar-mode-edit">
  <ul class="metabar-actions-btns">
  <?php if($view == 1) :?>
   <li>
        <button title="Delete this post" class="btn btn-small" data-action="delete-post">Delete</button>
   </li>
	<li>
              <button title="Edit" class="btn btn-primary btn-small" data-action="edit">Edit</button>
   </li>
   <li>
              <button title="Update" class="btn btn-primary btn-small" data-action="update" style="display: none;">Update</button>
   </li>
   <?php endif;?>
   
	<?php if($view == 0) :?> 
	 <li>
              <button title="Edit" class="btn btn-primary btn-small" data-action="edit">Edit</button>
   </li>
	<li>
              <button title="Save Draft" class="btn btn-small" data-action="save-draft" style="display: none;">Save Draft</button>
   </li>
	<li>
              <button title="Publish" class="btn btn-primary btn-small" data-action="publish" style="display: none;">Publish</button>
   </li>
   <?php endif;?>   
</ul>
 </div>
</div>
<?php endif;?>	
<article class="post-article">

<section class="post-page-wrapper  post-page-wrapper-contain">   
<div class="post-page-wrapper-inner">     
 <div class="post-author-side">
  <div class="post-author-card">   
         <a title="Go to the profile of <?=$fname?> <?=$lname?>" class="post-author-image" href="/<?=$uname?>"><img title="Sumit Pandey" src="<?=$pimg?>" /></a>
         
		   <div class="post-author-info">
		    
		           <a title="Go to the profile of <?=$fname?> <?=$lname?>" class="post-author-name" href="/<?=$uname?>" rel="author"><?=$fname?> <?=$lname?></a>
		           
		    <p>	
		            <?=$bio?>       
		    </p>   
		           
		    <p></p>	          
		   </div>   
         
   <div class="post-published-date">    
           <strong>Published</strong>           
    <p>     
        <time class="post-date"><?=$date?></time>            
    </p>
    
   </div>        
  </div>      
 </div>  
     <header class="post-header post-header-top">
     
 <ul class="post-meta">       
  <li class="post-meta-item">   
         <span class="post-meta-author"><a title="Go to the profile of <?=$fname?> <?=$lname?>" class="post-author" href="/@pbennett101"><?=$fname?> <?=$lname?></a></span>      
  </li>      
 </ul> 
     </header>
     
 <div class="post-content">       
  <div class="post-content-inner">
   
   
           <header class="post-header post-header-headline">
           
    <h1 class="post-title" itemprop="name" name="title">     
             <?=$title?>
    </h1>
    
           </header>
           
    <div class="post-field body" >
            <h2 class="post-field subtitle"><?=$subtitle?></h2>
            <div class="post-body-field" id="post_<?=$id?>"><?=$post?></div>
            
    </div>
   <div class="post-author-bottom post-supplemental">
    
           
    <div class="post-author-card">
     
      <a title="Go to the profile of <?=$fname?> <?=$lname?>" class="post-author-image" href="/<?=$uname?>"><img title="<?=$fname?> <?=$lname?>" src="<?=$pimg?>" /></a>
             
     <div class="post-author-info">
      
               <a title="Go to the profile of <?=$fname?> <?=$lname?>" class="post-author-name" href="/<?=$uname?>" rel="author"><?=$fname?> <?=$lname?></a>
               
      <p>      
                 Curious Chronicler, Crafty Designer, Cultural Learner CCO of IDEO: <a href="http://www.ideo.com/people/paul-bennett" target="_blank" rel="nofollow">http://www.ideo.com/people/paul-bennett</a> <a title="Twitter profile for @pbennett101" href="http://twitter.com/pbennett101" target="_blank">@pbennett101</a> <a href="http://curiositychronicles.tumblr.com" target="_blank" rel="nofollow">http://curiositychronicles.tumblr.com</a>
                
      </p>
      <p></p>
     </div>
     <div class="post-published-date">      
               <strong>Published</strong>
               
      <p>       
         <time class="post-date"><?=$date?></time>             
      </p>

     </div>
    </div>
   </div>
  </div>
 </div>
</div>
</section>
</article>
<link rel="stylesheet" href="/medium/css/medium.editor.css">
    <script src="/medium/js/medium.editor.js"></script>
<?php if ((logged_in() === true) && $session_user_id == $userid) :?>	
	
    	<script>
		$('button').click(function(e) {
			var val = $(this).data( "action" );
			switch (val) {
			case 'edit' :
			  $(".post-body-field").addClass('editable');
				var editor = new MediumEditor('.editable');	
				$(this).css('display','none');
				$('button[data-action="update"]').css('display','');
				$('button[data-action="save-draft"]').css('display','');
				$('button[data-action="publish"]').css('display','');
			  break;
			case 'delete-post' :
			
				$('.metabar-message').html('Deleting..');
				var pid = $('.post-body-field').attr('id').replace('post_','');					
					var dataString = 'post_id=' + pid;
						$.ajax({
						type: "POST",
						url: "/ajax/post_d.php",
						data: dataString,
						cache: false,
						success: function(response){
							$('.metabar-message').html('Deleted');
							window.location = "index.php";
						}
					});
			  break;
			  
			  case 'save-draft' :
					$('.metabar-message').html('Saving..');
					var pid = $('.post-body-field').attr('id').replace('post_','');	
					var post_data = $('.post-body-field').html();
					var dataString = 'post_id=' + pid + '&post_data=' + post_data;
						$.ajax({
						type: "POST",
						url: "/ajax/post_s.php",
						data: dataString,
						cache: false,
						success: function(response){
							$('.metabar-message').html('Saved');
							window.location = "index.php";
							$(".post-field").removeClass('editable');
							$('button[data-action="update"]').css('display','none');
							$('button[data-action="publish"]').css('display','none');
							$('button[data-action="save-draft"]').css('display','none');
							$('button[data-action="edit"]').css('display','');							
						}
					});
				  break;				
			case 'update' :
					$('.metabar-message').html('Upadting..');
					var pid = $('.post-body-field').attr('id').replace('post_','');	
					var post_data = $('.post-body-field').html();
					var dataString = 'post_id=' + pid + '&post_data=' + post_data;
					alert(dataString);
						$.ajax({
						type: "POST",
						url: "/medium/ajax/post_u.php",
						data: dataString,
						cache: false,
						success: function(response){
							$('.metabar-message').html('Updated');
							$(".post-body-field").removeClass('editable');
							$('button[data-action="update"]').css('display','none');
							$('button[data-action="edit"]').css('display','');							
						}
					});
				  break;
			case 'publish' :
					$('.metabar-message').html('Publishing..');
					var pid = $('.post-body-field').attr('id').replace('post_','');	
					var post_data = $('.post-body-field').html();
					var dataString = 'post_id=' + pid + '&post_data=' + post_data;
						$.ajax({
						type: "POST",
						url: "/ajax/post_p.php",
						data: dataString,
						cache: false,
						success: function(response){
							$('.metabar-message').html('Published');
							$(".post-field").removeClass('editable');
							$('button[data-action="save-draft"]').css('display','none');
							$('button[data-action="update"]').css('display','none');
							$('button[data-action="publish"]').css('display','none');
							$('button[data-action="edit"]').css('display','');			
						}
					});
				  break;	  
		  }	
			
});		
	
    </script>
<?php endif;?>
	

</body>
<?php
 endwhile;
 
?>