<?php include "core/init.php"; ?>
		<META http-equiv="Content-Type" content="text/html; charset=utf-8">	
<title>Broomble</title>
<link href="css/main.css" rel="stylesheet" type="text/css" media="screen">
	<script src="js/jquery.min.js"></script>
	<link rel="icon" href="/favicon.ico">
<body>

<aside class="cover cover-home img-loaded" data-load-img=".cover-img">
<button class="site-nav-logo"><span class="icons icons-logo-m"></span></button>

<div class="cover-body">
 <div class="cover-body-inner">
<?php     if (logged_in() === true) {
			 $user_data = user_data($session_user_id, 'username', 'first_name', 'last_name');
			 $fname = $user_data['first_name'];
			 $lname = $user_data['last_name'];
			 $uname = $user_data['username'];
			 $pimg = Gravatar($session_user_id);	
?>
				
				
		 <h1 class="cover-title">
		   Broomble
		  </h1>
		  <p class="cover-description">
		   A better place to read and write things that matter.<br /><br />
		  <div class="cover-actions">
			<a href="/<?=$uname?>"><img title="<?=$fname?> <?=$lname?>" class="avatar" src="<?=$pimg?>"/>
				<h2 class="cover-name"><?=$fname?> <?=$lname?></h2></a>
		  </div>
		  <div class="cover-actions">
		   <a class="btn btn-primary" href="new-post.php">New Post</a>
		  </div>
	<?php         
    } else {?>    	

		  <h1 class="cover-title">
		   Broomble
		  </h1>
		  <p class="cover-description">
		   A better place to read and write things that matter.<br /><br />
		  <div class="cover-actions">
		   <a class="btn btn-primary" id="btn-sign">Sign in!</a>
		  </div>
<?php }?>	

 </div>
</div>
</aside>
	<section tabindex="-1" class="wrapper" style="overflow: auto !important;">
				<div class="wrapper-inner">
					<div class="bucket post-bucket homepage-posts">
<?php
			
			$postarray = allPosts();
			
				foreach($postarray as $data){
				 $id=$data['id'];
				 $title=$data['title'];
				 $subtitle=$data['subtitle'];				 
				 $date = $data['datetime'];
				 $date = date('F d Y', $date);
				 $userid =$data['fk_u_id'];
				 $user_data = user_data($userid, 'username', 'first_name', 'last_name', 'type');

				 $fname = $user_data['first_name'];
				 $lname = $user_data['last_name'];
				 $uname = $user_data['username'];
				 $pimg = Gravatar($userid);
?>

<article class="post-item post-status- show-subtitles-variant">
		<a title="Go to the profile of <?=$fname?> <?=$lname?>" href="/<?=$uname?>"></a>
		<a title="Go to the profile of <?=$fname?> <?=$lname?>" href="/<?=$uname?>"><img title="<?=$fname?> <?=$lname?>" class="post-item-avatar" src="<?=$pimg?>" /></a>
		<h3 class="post-item-title">		 
		  <a title="<?=$title?> by <?=$fname?> <?=$lname?>" href="post/<?=$id?>"><?=$title?></a>
		</h3>

		<a class="post-item-snippet" href="post/<?=$id?>">
		<p>
		 <?=$subtitle?>
		</p>

		</a>
		<ul class="post-item-meta">
		 
		  
		 <li class="post-item-meta-item">
		  
			<a title="Go to the profile of <?=$fname?> <?=$lname?>" class="post-item-author" href="/<?=$uname?>"><?=$fname?> <?=$lname?></a>
		   
		 </li>
		 
		  
		 <li class="post-item-meta-item">
		  
			<span class="reading-time"><?=$date?></span>
		   
		 </li>
		 
		</ul>

		</article>

<?php
}		
?>

</div>
</div>
</section>


<div id="forgot-form">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>Account Recovery</h3>
	</div>
	<div class="modal-body">
		<div id="message"></div>
		<form action="forgot.php" method="post" name="forgotform" id="forgotform" class="form-stacked forgotform normal-label">
			<div class="controlgroup forgotcenter">
			<label for="usernamemail">Username or Email Address</label>
				<div class="control">
					<input id="usernamemail" name="usernamemail" type="text"/>
				</div>
			</div>
			<input type="submit" class="hidden" name="forgotten">
		</form>
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary pull-right" id="forgotsubmit">Submit</button>
		<p class="pull-left"> It\'ll be easy, I promise.</p>
	</div>
</div>
<div id="modal-container" style="display: none; margin-top:-160px;">
 
     
 <form class="well span4" id="login-form" method="post" action="login.php">  
     <h1>  Broomble!  </h1> 
        
  <p class="subheading">
   Please Login To Your Account
  </p>
  
        <label>Username </label>
			<input class="span4 required" id="username" name="username" maxlength="15" type="text" />
        <label>Password</label>
        <input class="span4 required" id="password" name="password" size="30" type="password" />
		<input type="hidden" name="token" value="<?php echo $session_user_id; ?>"/>
        <button class="btn btn-primary" id="login-submit" name="login" type="submit">Sign in!</button>
        <label class="checkbox" id="remember-me">Remember Me
          <input type="checkbox" id="remember" name="remember"/>
        </label>
        
  <div class="clear-fix"></div> 
        
  <hr />        
  <div class="btm-links">
   <a data-toggle="modal" href="#forgot-form" id="forgot-password">Forgot Your Password?</a><a id="create-account" href="register.php">Create An Account</a>
  </div>  
      
 </form>
   <div class="modal-backdrop fade in"></div>
</div>

<script>
$('#btn-sign').click(function() 
{
	$("#modal-container").slideDown('slow');
return false;
});

$('.modal-backdrop').click(function() 
{
	$("#modal-container").slideUp('slow');
return false;
});

</script>
</body>
<?php ob_flush(); ?>
<?
//include 'tracker.php';
//include_once 'template/footer.php';
?>