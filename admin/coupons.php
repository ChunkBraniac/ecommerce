<?php 
require "includes/dbconnection.php";
require "includes/functions.php";
require "includes/sessions.php";

if(isset($_POST['add_coupons'])) {
    $couponCode = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['coupon_code'])));
    $amountRemoved = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['amount_removed'])));

    if(empty($amountRemoved)) {
        $_SESSION['errorMsg'] = "The amount field is required";
        redirect_me_to('coupons.php');
    }
    else {
        //insert the coupons into the db
        $insertedCoupon = "INSERT INTO coupons(coupon_code, amount_removed, used) VALUES('$couponCode', '$amountRemoved', 'false')";
        $conCoupon = mysqli_query($connection, $insertedCoupon);

        if($conCoupon) {
            $_SESSION['successMsg'] = "Coupon addedd successfully";
            redirect_me_to('coupons.php');
        }
        else {
            $_SESSION['errorMsg'] = "Coupon was not added";
            redirect_me_to('coupons.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coupon Code</title>
    <?php require "css.php";?>
</head>
<body>
<?php require "_header.php"; ?>
    <br>
    <!-- This is for the form -->
    <div class="container mb-2 mt-1">
        <div class="col-xl-12 m-auto">
            <?php echo myErrorMsg(); echo mySuccessMsg(); ?>
            <?php 
                //generating coupon code and the amount to be removed
                $coupon_generator = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890';
                // $amount_generator = '01234567890';
                $new_coupon = substr(str_shuffle($coupon_generator), 0, 16);
                // $new_amount = substr(str_shuffle($amount_generator), 0, 3);

            ?>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-xl-6">
                        <label for="">Coupon Code</label>
                        <input type="text" class="form-control" name="coupon_code" required value="<?php echo $new_coupon?>">
                    </div>
                    <div class="col-xl-6 mt-xl-0 mt-3">
                        <label for="">Amount Removed</label>
                        <input type="text" class="form-control" name="amount_removed" required>
                    </div>
                </div>
                <div class="mt-3">
                    <button class="btn btn-success btn-md" name="add_coupons">Add Coupon</button>
                </div>
            </form>
        </div>
    </div>
    <hr>

    <div class="container">
        <h2>Coupon Codes</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Product Price Old</th>
                        <th>Used/Not Used</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <!-- Fetching all the items to be displayed -->
                    <?php
                        //get the data items
                        $getItems = "SELECT * FROM coupons ORDER BY coupon_id asc";
                        $conItems = mysqli_query($connection, $getItems);

                        $serialNumber = 0;

                        while($items = mysqli_fetch_assoc($conItems))
                        {
                            $coupon_id = $items['coupon_id'];
                            $coupon_code = $items['coupon_code'];
                            $amount_removed= $items['amount_removed'];
                            $used = $items['used'];
                            $serialNumber++;
                    ?>
                    <tr>
                        <td><?php echo $serialNumber ?></td>
                        <td><?php echo $coupon_code ?></td>
                        <td>$<?php echo $amount_removed ?></td>
                        <td><?php echo $used ?></td>
                        <td><a href="edit_coupon.php?coupon_id=<?php echo $coupon_id?>" class="btn btn-danger btn-sm">Edit</a> <a href="delete_coupon.php?coupon_id=<?php echo $coupon_id?>" class="btn btn-success btn-sm">Delete</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php require "scripts.php";?>
</body>
</html>