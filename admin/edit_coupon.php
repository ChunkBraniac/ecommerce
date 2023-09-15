<?php 
require "includes/dbconnection.php";
require "includes/functions.php";
require "includes/sessions.php";

$coupon_ID = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_GET['coupon_id'])));


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit - Coupon <?php echo $coupon_ID?></title>
    <?php require "css.php";?>
</head>
<body>
    <?php require "_header.php";?>

    <div class="container-fluid mt-4">
        <div class="col-xl-9 m-auto">
            <form action="" method="post">
                <div class="row">
                    <div class="col-xl-6">
                        <label for="">Coupon Code</label>
                        <input type="text" class="form-control" name="couponId" value="">
                    </div>

                    <div class="col-xl-6">
                        <label for="">Amount Removed</label>
                        <input type="text" class="form-control" name="couponId" value="">
                    </div>

                    <div class="col-xl-12">
                        <label for="" class="mt-3">Coupon Used</label>
                        <input type="text" class="form-control" name="couponId" value="">
                    </div>
                </div>

                <div class="mt-3">
                    <button name="update_coupon" class="btn btn-success btn-md" type="submit">Update Coupon</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>