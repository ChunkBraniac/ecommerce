<?php 
require 'includes/dbconnection.php';
require 'includes/functions.php';
require 'includes/sessions.php';

if(isset($_SESSION['id']))
{
    $_SESSION['errorMsg'] = "You are already logged in";
    redirect_me_to('index.php');
}

if(isset($_POST['login']))
{
    $emailLogin = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['emailLogin'])));
    $passwordLogin = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['passwordLogin'])));

    //hash the password for easy identification
    $hashedPasscode = md5($passwordLogin);

    if(empty($emailLogin) || empty($passwordLogin))
    {
        $_SESSION['errorMsg'] = "Enter your details to login";
        redirect_me_to('login.php');
    }
    else
    {
        //check the logins by fetching the already registered ones
        $getLogins = "SELECT * FROM users WHERE email = '$emailLogin' AND password = '$hashedPasscode'";
        $conLogins = mysqli_query($connection, $getLogins);

        while($logins = mysqli_fetch_assoc($conLogins))
        {
            $userId = $logins['id'];
            $firstName = $logins['first_name'];
            $lastName = $logins['last_name'];
            $userName = $logins[$firstName. ' '.$lastName];
            $userEmail = $logins['email'];
            $userPassword = $logins['password'];
        }

        //comparing inputs and fetched login for authorization
        if($emailLogin == $userEmail && $hashedPasscode == $userPassword)
        {
            $_SESSION['id'] = $userId;
            $_SESSION['first_name'] = $userName;
            $_SESSION['email'] = $userEmail;

            $_SESSION['successMsg'] = "Access granted";
            redirect_me_to('index.php');
        }
        elseif($emailLogin != $userEmail || $passwordLogin != $userPassword)
        {
            $_SESSION['errorMsg'] = "Incorrect email or password combination";
            redirect_me_to('login.php');
        }
        else
        {
            $_SESSION['errorMsg'] = "Something went wrong";
            redirect_me_to('login.php');
        }
    }
}

?>



<!doctype html>
<html class="no-js" lang="zxx">
    
<!-- login-register31:27-->
<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Login || limupa - Digital Products Store eCommerce</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon -->
        <?php require 'css.php'; ?>
    </head>
    <body>
        <!-- Begin Body Wrapper -->
        <div class="body-wrapper">

            <!-- Begin Login Content Area -->
            <div class="page-section mb-60">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 m-auto col-xl-6 col-xs-12 col-lg-6 mb-30">
                            <!-- Login Form s-->
                            <?php echo myErrorMsg(); echo mySuccessMsg();?>
                            <form action="" method="post">
                                <div class="login-form">
                                    <h4 class="login-title">Login</h4>
                                    <div class="row">
                                        <div class="col-md-12 col-12 mb-20">
                                            <label>Email Address*</label>
                                            <input class="mb-0" type="email" name="emailLogin" placeholder="Email Address" required>
                                        </div>
                                        <div class="col-12 mb-20">
                                            <label>Password</label>
                                            <input class="mb-0" type="password" name="passwordLogin" placeholder="Password" required>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="check-box d-inline-block ml-0 ml-md-2 mt-10">
                                                <input type="checkbox" id="remember_me" name="checkbox">
                                                <label for="remember_me">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-10 mb-20 text-left text-md-right">
                                            <a href="#"> Forgotten pasward?</a>
                                        </div>
                                        <div class="col-md-12">
                                            <button class="register-button mt-0" type="submit" name="login">Login</button>
                                        </div>
                                    </div>
                                    <div class="text-left mt-3">
                                        <p>Don't have an account? <a href="register.php">Register</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Login Content Area End Here -->
        </div>
        <!-- Body Wrapper End Here -->
        <!-- jQuery-V1.12.4 -->
        <?php require 'scripts.php'; ?>
    </body>

<!-- login-register31:27-->
</html>
