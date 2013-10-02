<?php include "core/init.php";
protect_page();
?>
<!DOCTYPE HTML>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">

<html class="screen-scroll wf-fftisawebpro-i4-active wf-fftisawebpro-i7-active wf-fftisawebpro-n4-active wf-fftisawebpro-n7-active wf-freightsanspro-n5-active wf-freightsanspro-n7-active wf-active">
<head>
<title>Broomble - New Post</title>
<link href="css/new-post.css" rel="stylesheet" type="text/css" media="screen">

	<script src="/medium/js/jquery.min.js"></script>

</head>
<?php $prop = md5(time());?>

<body>
<div class="site-nav-overlay"></div>
<button class="site-nav-logo"><span class="icons icons-logo-m"></span></button>
<div class="container" id="container"> 
 <div class="screen-content" id="prerendered">
  <article class="post-article grid-breaking ">
  <div class="metabar active">
   <section class="metabar-status"><span class="metabar-message metabar-error"></span></section>
   <div class="metabar-actions metabar-mode-edit">
    <ul class="metabar-actions-btns">   
     <li>
      <button title="Save Draft" class="btn btn-small" data-action="save-draft">Save Draft</button>
     </li>
     <li>
      <button title="Publish" class="btn btn-primary btn-small btn-publish" data-action="publish">Publish</button>
     </li>
    </ul>
   </div>
  </div>
  <section class="post-page-wrapper  post-page-wrapper-contain">  
   <div class="post-content">
    <div class="post-content-inner">
     <div class="notes-source">
      <header class="post-header post-header-headline">
      <h1 class="post-title editable default-value" id="post_title_<?=$prop?>" name="title" itemprop="name" g_editable="true" role="textbox" contenteditable="true" data-placeholder='Type your title'></h1>
      <h2 class="post-field subtitle editable default-value" name="subtitle" g_editable="true" role="textbox" contenteditable="true" data-placeholder='Type your subtitle (optional)'></h2>
		<p class="post-field content editable default-value" name="subtitle" g_editable="true" role="textbox" contenteditable="true" data-placeholder='Type your post'></p>
      
      </header>
	  </div>
     </div>
     <div class="post-follow-ups post-supplemental"></div>
    </div>
   </div>   
  </div>
  </section>
 </article>
 </div>
</div>
<link rel="stylesheet" href="/medium/css/medium.editor.css">
    <script src="/medium/js/medium.editor.js"></script>
    	<script>
		$( document ).ready(function() {
			var editor = new MediumEditor('.editable');	
		});
		$('button').click(function(e) {
			var val = $(this).data( "action" );
			switch (val) {			
			case 'save-draft' :						
				$('button[data-action="save-draft"]').attr("disabled", "disabled");				
				var post_title = $('#post_title_<?=$prop?>').text();
					var post_sub = $('.subtitle').text();
					var post_data = $('.content').html();
					var post_view = 0;
					if(post_title != ""){
					$(".metabar-message").css('display','').html('Saving..');	
					var dataString = 'post_title=' + post_title + '&post_sub=' + post_sub + '&post_data=' + post_data + '&post_view=' + post_view;
					alert(dataString);
						$.ajax({
						type: "POST",
						url: "ajax/post_p.php",
						data: dataString,
						cache: false,
						success: function(response){
							$(".metabar-message").html('Saved');
							window.location = "index.php";
							
						}
					});
					}else{
						$(".metabar-error").text('Error!');	
					}				 
			  break;
			case 'publish' :	
					
					var post_title = $('#post_title_<?=$prop?>').text();
					var post_sub = $('.subtitle').text();
					var post_data = $('.content').html();
					var post_view = 1;
					if(post_title != "" && post_data != ""){
					$(".metabar-message").css('display','').html('Publishing..');
					var dataString = 'post_title=' + post_title + '&post_sub=' + post_sub + '&post_data=' + post_data + '&post_view=' + post_view;
					alert(dataString);
						$.ajax({
						type: "POST",
						url: "ajax/post_p.php",
						data: dataString,
						cache: false,
						success: function(response){
							$(".metabar-message").html('Published');
							window.location = "index.php";
							
						}
					});
				  }else{					
					$(".metabar-error").text('Error!');
				  }
				  break;
		  }		
});

    </script>

</body>

</html>