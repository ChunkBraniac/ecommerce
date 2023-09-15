<?php 
require "includes/dbconnection.php";
require "includes/functions.php";
require "includes/sessions.php";

$idSession = $_SESSION['id'];
$productId = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_GET['product_id'])));

//removie the item
if (isset($_POST['remove_from_cart'])) {
    $remove_id = $_POST['remove_id'];
    if (isset($_SESSION['cart'][$remove_id])) {
        unset($_SESSION['cart'][$remove_id]);
        $_SESSION['successMsg'] = "Item removed from cart";
    }
}

//updating the cart 
if (isset($_POST['update_cart'])) {
    $update_id = $_POST['update_id'];
    $cart_item_quantity = $_POST['cart_item_quantity'];

    $product2 = [
        'item_quant' => $cart_item_quantity
    ];

    if(isset($_SESSION['cart'][$update_id]) && isset($idSession)) {
        $_SESSION['cart'][$update_id]['item_quant'] += $cart_item_quantity;
        $add_quantity = $cart_item_quantity;
        $_SESSION['successMsg'] = "Item updated successfully";
    }
    else {
        $_SESSION['errorMsg'] = "Item was not updated";
    }

}


?>


<?php

// if(isset($_POST['apply_coupon'])) {
//     $coupon = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['coupon_code'])));
    
//     if(empty($coupon)) {
//         $_SESSION['errorMsg'] = "Field is required";
//     }
//     else {
//         //fetching the coupons
//         $new_amount = 0;
//         $fetchCoupons = "SELECT * FROM coupons WHERE coupon_code = '$coupon'";
//         $conFetchedCoupons = mysqli_query($connection, $fetchCoupons);

//         while($allCoupons = mysqli_fetch_assoc($conFetchedCoupons)) {
//             $couponCodeFetched = $allCoupons['coupon_code'];
//             $amounRemovedFetched = $allCoupons['amount_removed'];
//             $usedFetched = $allCoupons['used'];
//         }

//         //comparing the coupon gotten from user and that is fetched
//         if($coupon == $couponCodeFetched && $usedFetched != 'true') {
//             //setting the used to true
//             $update_coupon = "UPDATE coupons SET used = 'true'";
//             $con_update = mysqli_query($connection, $update_coupon);
//             $add_price = $add_price - $amounRemovedFetched;
//             $_SESSION['successMsg'] = "Coupon code applied";
//             redirect_me_to('shopping-cart.php');
//         }
//         else {
//             $_SESSION['errorMsg'] = "Invalid coupon code";
//             redirect_me_to('shopping-cart.php');
//         }
//     }
// }

echo myErrorMsg();
echo mySuccessMsg();

?>



<!doctype html>
<html class="no-js" lang="zxx">
    
<!-- shopping-cart31:32-->
<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Shopping Cart || limupa - Digital Products Store eCommerce Bootstrap 4 Template</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php require "css.php";?>
    </head>
    <body>
    <!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
        <!-- Begin Body Wrapper -->
        <div class="body-wrapper">
            <!-- Begin Header Area -->
            <?php require "_header.php";?>
            <!-- Header Area End Here -->
            <!-- Begin Li's Breadcrumb Area -->
            <div class="breadcrumb-area" style="margin-top: -20px;">
                <div class="container">
                    <div class="breadcrumb-content">
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li class="active">Shopping Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Li's Breadcrumb Area End Here -->
            <!--Shopping Cart Area Strat-->
            <div class="Shopping-cart-area pt-60 pb-60">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-content table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="li-product-remove">remove</th>
                                                <th class="li-product-thumbnail">images</th>
                                                <th class="cart-product-name">Product</th>
                                                <th class="li-product-price">Unit Price</th>
                                                <th class="li-product-quantity">Quantity</th>
                                                <th class="li-product-subtotal">Total</th>
                                                <th class="li-product-subtotal">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $grandTotal = 0;
                                                $totalUniqueItemsInCart = 0;
                                                $shipping_fee = 200;

                                                if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                                                    foreach ($_SESSION['cart'] as $product_id => $item) {
                                                        $add_name = $item['name'];
                                                        $add_price = number_format($item['price_new'], 2);
                                                        $add_image = $item['image'];
                                                        $add_quantity = $item['quantity'];
                                                        $add_total = number_format($item['price_new'] * $item['quantity'], 2);
                                                        $grandTotal += $add_total;
                                                        $totalUniqueItemsInCart = count($_SESSION['cart']);
                                            ?>

                                            <?php 
                                                //applying coupon code
                                                $new_amount = 0;
                                                if(isset($_POST['apply_coupon'])) {
                                                    $coupon = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['coupon_code'])));
                                                    
                                                    if(empty($coupon)) {
                                                        $_SESSION['errorMsg'] = "Field is required";
                                                    }
                                                    else {
                                                        //fetching the coupons
                                                        $fetchCoupons = "SELECT * FROM coupons WHERE coupon_code = '$coupon'";
                                                        $conFetchedCoupons = mysqli_query($connection, $fetchCoupons);
                                                
                                                        while($allCoupons = mysqli_fetch_assoc($conFetchedCoupons)) {
                                                            $couponCodeFetched = $allCoupons['coupon_code'];
                                                            $amounRemovedFetched = $allCoupons['amount_removed'];
                                                            $usedFetched = $allCoupons['used'];
                                                        }
                                                
                                                        //comparing the coupon gotten from user and that is fetched
                                                        if($coupon == $couponCodeFetched && $usedFetched != 'true') {
                                                            //setting the used to true
                                                            $update_coupon = "UPDATE coupons SET used = 'true'";
                                                            $con_update = mysqli_query($connection, $update_coupon);
                                                            $add_price = $add_price - $amounRemovedFetched;
                                                            $_SESSION['successMsg'] = "Coupon code applied";
                                                            redirect_me_to('shopping-cart.php');
                                                        }
                                                        else {
                                                            $_SESSION['errorMsg'] = "Invalid coupon code";
                                                            redirect_me_to('shopping-cart.php');
                                                        }
                                                    }
                                                }
                                            ?>
                                            
                                            <form action="" method="post">
                                            <tr>
                                                <td>
                                                        <input type="hidden" name="remove_id" value="<?php echo $product_id?>">
                                                        <button type="submit" name="remove_from_cart" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                                                </td>
                                                <td class="li-product-thumbnail"><a href="#"><img src="itemImages/<?php echo $add_image?>" style="height: 100px; width: 100px;" alt="Li's Product Image"></a></td>
                                                <td class="li-product-name"><a href="#"><?php echo $add_name?></a></td>
                                                <td class="li-product-price"><span class="amount">$<?php echo $add_price?></span></td>
                                                <td class="quantity">
                                                    
                                                    <input type="hidden" name="update_id" value="<?php echo $product_id?>">
                                                    <input class="bg-light border-0" value="<?php echo $add_quantity?>" type="number" name="cart_item_quantity">
                                                </td>
                                                <td class="product-subtotal"><span class="amount">$<?php echo $add_total?></span></td>
                                                <td>
                                                    <input class="btn btn-dark btn-sm" style="border-radius: 0px; box-shadow: none;" name="update_cart" value="Update cart" type="submit">
                                                </td>
                                            </tr>
                                            </form>
                                            <?php } }
                                                else {
                                                    echo '<tr><td colspan="4">Your cart is empty.</td></tr>';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="coupon-all">
                                                <div class="coupon">
                                                    <input id="coupon_code" class="input-text" name="coupon_code" value="" placeholder="Coupon code" type="text">
                                                    <input class="button" name="apply_coupon" value="Apply coupon" type="submit">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-md-5 ml-auto">
                                        <div class="cart-page-total">
                                            <h2>Cart totals</h2>
                                            <ul>
                                                <li>Subtotal <span>$<?php echo $grandTotal?></span></li>
                                                <li>Total <span>$<?php echo $grandTotal+$shipping_fee?></span></li>
                                            </ul>
                                            <a href="#">Proceed to checkout</a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Shopping Cart Area End-->
            <!-- Begin Footer Area -->
            <?php require "_footer.php";?>
            <!-- Footer Area End Here -->
        </div>
        <!-- Body Wrapper End Here -->
        <?php require "scripts.php";?>
    </body>
<script type="text/javascript">
	if(window.history.replaceState) {
		window.history.replaceState(null, null);
	}
</script>

<!-- shopping-cart31:32-->
</html>
