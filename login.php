<h2>Login</h2>
<?php
include 'core/init.php';
logged_in_redirect();
// test:
//if (user_exists('foo')) {
//    echo 'exists';
//}
//die();

if (empty($_POST) === false) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (empty($username) === true || empty($password) === true) {
        $errors[] = 'You need to enter a username and password';
    } else if (user_exists($username) == 0) {
        $errors[] = 'We can\'t find that username. Have you registered?';
    } else if (user_active($username) == 0) {
        $errors[] = 'You haven\'t activated your account;';
    } else {
        if (strlen($password) > 32) {
             $errors[] = 'Password too long';
         }
        $login = login($username, $password);
        if ($login === false) {
            $errors[] ='That username/password combination is incorrect';
        } else {
            // set the user session
             $_SESSION['user_id'] = $login;
            // redirect user to home
             header('Location: index.php');
             exit();
        }
    }
//    print_r($errors);
}
include 'includes/overall/header.php';
// echo output_errors($errors);
if (empty($errors) === false) {
    echo output_errors($errors);
}
?>