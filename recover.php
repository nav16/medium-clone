<?php
include "core/init.php";
logged_in_redirect();
include "includes/overall/header.php";
?>
<h1>Recover</h1>
<?php
if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
?>
    <p>Thanks, we've emailed you.</p>
<?php
} else {
    $mode_allowed = array('username', 'password');
    if (isset($_GET['mode']) === true && in_array($_GET['mode'], $mode_allowed) === true) {
//   echo $_GET['mode'];
        if (isset($_POST['email']) === true && empty($_POST['email']) === false) {
            if (email_exists($_POST['email']) === true) {
//            echo 'ok';
                recover($_GET['mode'], $_POST['email']);
                header('Location: recover.php?success');
                exit();
            } else {
                echo '<p>Oops, we couldnt\'t find that email address!</p>';
            }
        }
        ?>

        <form action="" method="post">
            <ul>
                <li>
                    Please enter your email address:<br>
                    <input type="text" name="email">
                </li>
                <li><input type="submit" value="Recover"></li>
            </ul>
        </form>

        <?php
    } else {
        header('Location: index.php');
    }
}
?>

<?php include "includes/overall/footer.php"; ?>