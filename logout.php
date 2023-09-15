<?php
require 'includes/dbconnection.php';
require 'includes/functions.php';
require 'includes/sessions.php';

//checking if the user is logged in
if (!isset($_SESSION['email'])) {
    // code...
    $_SESSION['errorMsg'] = "You are currently not logged in";
    redirect_me_to('index.php');
}
else {
    $_SESSION['errorMsg'] = "Logged out";
    $_SESSION['id'] = null;
    $_SESSION['email'] = null;
    $_SESSION['first_name'] = null;

    redirect_me_to('index.php');
    session_destroy();
}

?>

<?php echo myErrorMsg() ?>
<?php echo mySuccessMsg() ?>
