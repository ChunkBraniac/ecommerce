<?php 
require "includes/dbconnection.php";
require "includes/functions.php";
require "includes/sessions.php";

$getCouponId = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_GET['coupon_id'])));

#delete the coupon by its id
$deleteCoupon = "DELETE FROM coupons WHERE coupon_id = '$getCouponId'";
$conDelete = mysqli_query($connection, $deleteCoupon);

if($conDelete) {
    $_SESSION['successMsg'] = "Coupon deleted";
    redirect_me_to('coupons.php');
}
else {
    $_SESSION['errorMsg'] = "Something went wrong";
    redirect_me_to('coupons.php');
}

echo myErrorMsg();
echo mySuccessMsg();

?>