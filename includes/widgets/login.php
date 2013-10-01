<div id="modal-container">     
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
</div>