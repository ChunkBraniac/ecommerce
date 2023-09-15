<?php 
require "includes/dbconnection.php";
require "includes/functions.php";
require "includes/sessions.php";

if(isset($_POST['adminLogin']))
{
    $adminEmail = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['adminEmail'])));
    $adminPassword = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['adminPassword'])));

    //hashing the password for easy identification
    $hashedPass = md5($adminPassword);

    //checking for empty fields
    if(empty($adminEmail) || empty($adminPassword))
    {
        $_SESSION['errorMsg'] = "Enter your details to login";
        redirect_me_to('login.php');
    }
    else
    {
        //get data from the db to compare with admin inputs
        $getAdminInfo = "SELECT * FROM adminDB WHERE admin_email = '$adminEmail' AND admin_password = '$hashedPass'";
        $conInfo = mysqli_query($connection, $getAdminInfo);

        while($adminInfo = mysqli_fetch_assoc($conInfo))
        {
            $admin_id = $adminInfo['admin_id'];
            $admin_email = $adminInfo['admin_email'];
            $admin_password = $adminInfo['admin_password'];
            $admin_name = $adminInfo['admin_name'];
        }

        //authorizing the admin
        if($adminEmail == $admin_email && $hashedPass == $admin_password)
        {
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_email'] = $admin_email;
            $_SESSION['$admin_name'] = $admin_name;
            $_SESSION['successMsg'] = "Access granted";
            redirect_me_to('index.php');
        }
        elseif($adminEmail != $admin_email || $hashedPass != $admin_password)
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login || Limpua</title>
    <?php require "css.php";?>
</head>
<body class="bg-white">
    <br><br><br><br>
    <div class="container">
        <div class="col-xl-6 m-auto border p-4" style="border-radius: 4px;">
            <?php echo myErrorMsg(); mySuccessMsg();?>
            <form action="" method="post">
                <label for="">Admin Email</label>
                <input type="email" class="form-control" required name="adminEmail">
                <br>
                <label for="">Admin Password</label>
                <input type="password" class="form-control" required name="adminPassword">
                <br>
                <input type="submit" class="btn btn-success btn-md" value="Login" name="adminLogin">

                <div class="mt-2 text-center">
                    <p>Don't have an account? <a href="register_admin.php" class="text-dark">Sign up</a></p>
                </div>
            </form>
        </div>
    </div>

<?php require 'scripts.php'; ?>
</body>
</html>