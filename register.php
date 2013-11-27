<?php
include "core/init.php";
logged_in_redirect();

if (empty($_POST) === false) {
    $required_fields = array('username', 'password', 'password_again',
        'first_name', 'email');
//    echo '<pre>', print_r($_POST, true), '</pre>';    
    foreach ($_POST as $key => $value) {
//        echo $key, ' ';
        if (empty($value) && in_array($key, $required_fields) === true) {
            $errors[] = 'Fields marked with an asterisk are required';
            break 1;
        }

        if (empty($errors) === true) {
            if (user_exists($_POST['username']) === true) {
                $errors[] = 'Sorry, the username \'' . $_POST['username'] . '\' is already taken.';
            }
            if (!preg_match("/^[a-zA-Z0-9]+_?[a-zA-Z0-9]+$/D", $_POST['username']) == true) {
//                $regular_expression = preg_match("/\\s/", $_POST['username']);
//                var_dump($regular_expression);
                $errors[] = 'Your username must contain only alphabets and digits';
            }
            if (strlen($_POST['password']) < 6) {
                $errors[] = 'Your password must be at least 6 characters';
            }
            if ($_POST['password'] !== $_POST['password_again']) {
                $errors[] = 'Your passwords do not match';
            }
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
                $errors[] = 'A valid email address is required';
            }
            if (email_exists($_POST['email']) === true) {
                $errors[] = 'Sorry, the email \'' . $_POST['email'] . '\' is already in use.';
            }
        }
    }
}

// print_r($errors);
//include 'includes/overall/header.php';
?>

<title>Broomble</title>
<link href="css/main.css" rel="stylesheet" type="text/css" media="screen">
	<script src="js/jquery.min.js"></script>
<h2>Register</h2>

<?php
if (isset($_GET['success']) && empty($_GET['success'])) {
    echo 'You\'ve been registered successfully! Please check your email to activate your account.';
} else {
    if (empty($_POST) === false && empty($errors) === true) {
        // register user
        $register_data = array(
            'username'      => $_POST['username'],
            'password'      => $_POST['password'],
            'first_name'    => $_POST['first_name'],
            'last_name'     => $_POST['last_name'],
            'email'         => $_POST['email'],
            'email_code'    => md5($_POST['username'] + microtime())
        );

        register_user($register_data);
        header('Location: register.php?success');
        exit();

//    print_r($register_data);
    } else if (empty($errors) === false) {
        // output errors
        echo output_errors($errors);
    }
    ?>
	
<div id="modal-container">     
 <form class="well span4" method="post" action="register.php" id="sign-up-form">         
  <h1>Broomble!</h1>         
  <p class="subheading">Create an account</p> 
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="first_name">First name*</label>
					<div class="controls">
						<input type="text" class="span4 required" id="first_name" name="first_name" value="" placeholder="Full name">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="last_name">Last name*</label>
					<div class="controls">
						<input type="text" class="span4 required" id="last_name" name="last_name" value="" placeholder="Full name">
					</div>
				</div>
				<div class="control-group" id="usrCheck">
					<label class="control-label" for="username">Username*</label>				
					<div class="controls">
						<input type="text" class="span4 required" id="username" name="username" maxlength="15" value="" placeholder="Choose your username">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="password">Password*</label>				
					<div class="controls">
						<input type="password" class="span4 required" id="password" name="password" placeholder="Create a password">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="password_confirm">Password again*</label>				
					<div class="controls">
						<input type="password" class="span4 required" id="password_again" name="password_again" placeholder="Confirm your password">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="email">Email*</label>				
					<div class="controls">
						<input type="email" class="span4 required" id="email" name="email" value="" placeholder="Email">
					</div>
				</div>

				<div class="control-group">
									</div>
				
				<div class="control-group">
									</div>

			</fieldset>			
			<button type="submit" class="btn btn-primary">Create my account</button>
			<hr>
		  <div class="btm-links">
			   <a id="create-account" href="login.php">Have an account?</a>
		  </div>
		</form>
</div>	
	
    <?php
}
?>
