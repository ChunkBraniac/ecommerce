<?php 
require "includes/dbconnection.php";
require "includes/functions.php";
require "includes/sessions.php";

$itemId = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_GET['product_id'])));

if(isset($_POST['update_item']))
{
    $p_name = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['p_name'])));
    $p_price_old = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['p_price_old'])));
    $p_price_new = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['p_price_new'])));
    $p_cartegory = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['p_cartegory'])));
    $p_description = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['p_description'])));

    //check to see if any field is left empty
    if(empty($p_name) || empty($p_price_old) || empty($p_price_new) || empty($p_cartegory) || empty($p_description))
    {
        $_SESSION['errorMsg'] = "All fields are required";
        redirect_me_to('edit_item.php');
    }
    else
    {
        //update the items in the db
        $updateItem = "UPDATE items SET product_name = '$p_name',
        product_price_old = '$p_price_old',
        product_price_new = '$p_price_new',
        product_cartegory = '$p_cartegory',
        product_description = '$p_description' WHERE product_id = '$itemId'";
        //connect the queries
        $conUpdate = mysqli_query($connection, $updateItem);

        if($conUpdate)
        {
            $_SESSION['successMsg'] = "Items Updated successfully";
            redirect_me_to('index.php');
        }
        else
        {
            $_SESSION['errorMsg'] = "Item was not updated";
            redirect_me_to('index.php');
        }
    }
}

echo myErrorMsg();
echo mySuccessMsg();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit item</title>
    <?php require "css.php";?>
</head>
<body>
    <?php require "_header.php";?>
    <br>
    
    <!-- getting all the values of the specified item -->
    <?php 
        $specItem = "SELECT * FROM items WHERE product_id = '$itemId'";
        $conSpec = mysqli_query($connection, $specItem);

        while($specs = mysqli_fetch_assoc($conSpec))
        {
            $specName = $specs['product_name'];
            $specPriceOld = $specs['product_price_old'];
            $specPriceNew = $specs['product_price_new'];
            $specCartegory = $specs['product_cartegory'];
            $specDescription = $specs['product_description'];
        }
    ?>
    <div class="container">
        <div class="col-xl-8 m-auto">
            <form action="" method="post">
                <div class="row">
                    <div class="col-xl-6">
                        <label for="">Product Name</label>
                        <input type="text" class="form-control" name="p_name" value="<?php echo $specName?>" required>
                    </div>
                    <div class="col-xl-6">
                        <label for="">Product Price Old</label>
                        <input type="text" class="form-control" name="p_price_old" value="<?php echo $specPriceOld?>" required>
                    </div>

                    <!-- Second tab -->
                    <div class="col-xl-6 mt-xl-3 mt-3">
                        <label for="">Product Price New</label>
                        <input type="text" class="form-control" name="p_price_new" value="<?php echo $specPriceNew?>" required>
                    </div>

                    <!-- Third tab -->
                    <div class="col-xl-6 mt-xl-3 mt-3">
                        <label for="">Product Cartegory</label>
                        <input type="text" class="form-control" name="p_cartegory" value="<?php echo $specCartegory?>" required>
                    </div>
                    <div class="col-xl-12 mt-xl-3 mt-3">
                        <label for="">Product Description</label>
                        <textarea name="p_description" class="form-control" rows="5"><?php echo $specDescription;?></textarea>
                    </div>
                </div>
                <div class="mt-2">
                    <button class="btn btn-success btn-md" name="update_item">Update</button>
                </div>
            </form>
        </div>
    </div>
    

<?php require "scripts.php";?>
</body>
</html>