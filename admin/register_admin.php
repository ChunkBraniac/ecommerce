<?php 
require "includes/dbconnection.php";
require "includes/functions.php";
require "includes/sessions.php";

if(isset($_POST['register_admin']))
{
    $admin_name = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['admin_name'])));
    $admin_email = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['admin_email'])));
    $admin_password = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['admin_password'])));

    //hashing the password using md5
    $hashedPass = md5($admin_password);

    if(empty($admin_name) || empty($admin_email) || empty($admin_password))
    {
        $_SESSION['errorMsg'] = "All fields are required";
        redirect_me_to('register_admin.php');
    }
    else
    {
        //checking if the email already exists
        $getMails = "SELECT * FROM adminDB WHERE admin_email = '$admin_email'";
        $conMails = mysqli_query($connection, $getMails);

        while($fetchedMails = mysqli_fetch_assoc($conMails))
        {
            $mail = $fetchedMails['admin_email'];
        }

        if($admin_email == $mail)
        {
            $_SESSION['errorMsg'] = "Email is taken";
            redirect_me_to('register_admin.php');
        }
        else
        {
            //insert into the adminDB
            $insertData = "INSERT INTO adminDB(admin_name, admin_email, admin_password) VALUES('$admin_name', '$admin_email', '$hashedPass')";
            $conData = mysqli_query($connection, $insertData);

            if($conData)
            {
                $_SESSION['successMsg'] = "Account created successfully";
                redirect_me_to('register_admin.php');
            }
            else
            {
                $_SESSION['errorMsg'] = "Something went wrong";
                redirect_me_to('register_admin.php');
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register || Limpua</title>
    <?php require "css.php";?>
</head>
<body class="bg-white">
    <br><br><br><br>
    <div class="container">
        <div class="col-xl-6 m-auto border p-4">
            <?php echo myErrorMsg(); echo mySuccessMsg();?>
            <form action="" method="post">
                <div class="row">
                    <div class="col-xl-6">
                        <label for="">Admin Name</label>
                        <input type="text" class="form-control" name="admin_name" required>
                    </div>
                    <div class="col-xl-6">
                        <label for="">Admin Email</label>
                        <input type="email" class="form-control" name="admin_email" required>
                    </div>


                    <div class="col-xl-12 mt-3">
                        <label for="">Admin Password</label>
                        <input type="password" class="form-control" name="admin_password" required>
                    </div>
                </div>

                <input type="submit" class="btn btn-success btn-md mt-3" name="register_admin" value="REGISTER">

                <div class="mt-2 text-center">
                    <p>Alread have an account? <a href="login.php" class="text-dark">Login</a></p>
                </div>
            </form>
        </div>
    </div>

<?php require 'scripts.php'; ?>
</body>
</html>