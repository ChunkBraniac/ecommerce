<?php 
require 'includes/dbconnection.php';
require 'includes/functions.php';
require 'includes/sessions.php';

require 'mailer/src/PHPMailer.php';
require 'mailer/src/Exception.php';
require 'mailer/src/SMTP.php';
        
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['register'])) {
    # getting the input fields
    $first_name = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['first_name'])));
    $last_name = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['last_name'])));
    $email = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['email'])));
    $password = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['password'])));
    $confirm_pass = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['confirm_pass'])));
    $datet = strftime('%A %h %Y %R');

    //hashing the passwords
    $hashedPassword = md5($password);
    $hashedConfirmPass = md5($confirm_pass);

    //generating code for email verification
    $rand = '0123456789';
    $verificationCode = substr(str_shuffle($rand), 0, 6);

    //setting the verified proof
    $verified = 0;

    //cleaning up the forms
    if(empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_pass))
    {
        $_SESSION['errorMsg'] = "All fields are required";
        redirect_me_to('register.php');
    }
    elseif(!preg_match("/^[a-zA-Z ]*$/", $first_name))
    {
        $_SESSION['errorMsg'] = "Letters only";
        redirect_me_to('register.php');
    }
    elseif($password < 6 || $confirm_pass < 6)
    {
        $_SESSION['errorMsg'] = "Password must be greater than six";
        redirect_me_to('register.php');
    }
    elseif($password != $confirm_pass)
    {
        $_SESSION['errorMsg'] = "Passwords does not match";
        redirect_me_to('register.php');
    }
    else
    {
        //checking for any existing email in the database
        $getEmails = "SELECT email FROM users WHERE email = '$email'";
        $conEmails = mysqli_query($connection, $getEmails);

        while($allMails = mysqli_fetch_assoc($conEmails))
        {
            $theEmail = $allMails['email'];
        }

        if($theEmail > 0)
        {
            $_SESSION['errorMsg'] = "Email has been taken";
            redirect_me_to('register.php');
        }
        else
        {
            //inserting into the database
            $insertData = "INSERT INTO users(first_name, last_name, email, password, confirm_pass, code, verified, datet) VALUES('$first_name', '$last_name', '$email', '$hashedPassword', '$hashedConfirmPass', '$verificationCode', '$verified', '$datet')";
            $acceptConnection = mysqli_query($connection, $insertData);

            if($acceptConnection)
            {
                $_SESSION['successMsg']= "Account created successfully";
                redirect_me_to('register.php');
            }
            else
            {
                $_SESSION['errorMsg'] = "Something went wrong";
                redirect_me_to('register.php');
            }
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
    <title> Register || limupa - Digital Products Store eCommerce</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <?php require 'css.php'; ?>
</head>
<body>
    <!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
        <!-- Begin Body Wrapper -->
        <div class="body-wrapper">
            <!-- Begin Login Content Area -->
            <div class="page-section mb-60">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-xl-6 m-auto col-lg-6 col-xs-12">
                            <?php echo myErrorMsg(); echo mySuccessMsg();?>
                            <form action="" method="post">
                                <div class="login-form">
                                    <h4 class="login-title">Register</h4>
                                    <div class="row">
                                        <div class="col-md-6 col-12 mb-20">
                                            <label>First Name*</label>
                                            <input class="mb-0" type="text" placeholder="First Name" name="first_name" required autocomplete="off">
                                        </div>
                                        <div class="col-md-6 col-12 mb-20">
                                            <label>Last Name*</label>
                                            <input class="mb-0" type="text" placeholder="Last Name" name="last_name" required autocomplete="off">
                                        </div>
                                        <div class="col-md-12 mb-20">
                                            <label>Email Address*</label>
                                            <input class="mb-0" type="email" placeholder="Email Address" name="email" required autocomplete="off">
                                        </div>
                                        <div class="col-md-6 mb-20">
                                            <label>Password*</label>
                                            <input class="mb-0" type="password" placeholder="Password" name="password" required autocomplete="off">
                                        </div>
                                        <div class="col-md-6 mb-20">
                                            <label>Confirm Password*</label>
                                            <input class="mb-0" type="password" placeholder="Confirm Password" name="confirm_pass" required autocomplete="off">
                                        </div>
                                        <div class="col-12">
                                            <button class="register-button mt-0" name="register" type="submit" style="border-radius: 0px;">Register</button>
                                        </div>
                                    </div>
                                    <div class="text-left mt-3">
                                        <p>Already have an account? <a href="login.php">Login</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Login Content Area End Here -->
            
            <!-- Footer Area End Here -->
        </div>
        <!-- Body Wrapper End Here -->
        <!-- jQuery-V1.12.4 -->
        <?php require 'scripts.php'; ?>
</body>

<!-- login-register31:27-->
</html>
