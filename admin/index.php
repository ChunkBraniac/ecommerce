<?php 
require "includes/dbconnection.php";
require "includes/functions.php";
require "includes/sessions.php";

if(isset($_POST['add_items']))
{
    //get the inputs from the form
    $product_name = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['product_name'])));
    $product_price_old = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['product_price_old'])));
    $product_price_new = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['product_price_new'])));
    $product_image = mysqli_real_escape_string($connection, $_FILES['product_image']['name']);
    $product_cartegory = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['product_cartegory'])));
    $product_description = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_POST['product_description'])));

    //setting the target location for the image files
    $target = '../itemImages/'.basename($_FILES['product_image']['name']);

    //setting the max limit of the image
    $imageSizeLimit = 1000000;
    $imageSize = $_FILES['product_image']['size'];

    //checking to make sure all inputs are filled
    if(empty($product_name) || empty($product_price_old) || empty($product_price_new) || empty($product_image) || empty($product_cartegory) || empty($product_description))
    {
        $_SESSION['errorMsg'] = "All fields are required";
        redirect_me_to('index.php');
    }
    elseif($imageSize > $imageSizeLimit)
    {
        $_SESSION['errorMsg'] = "Image too large";
        redirect_me_to('index.php');
    }
    else
    {
        //insert into the database
        $insertItems = "INSERT INTO items(product_name, product_price_old, product_price_new, product_image, product_cartegory, product_description) VALUES('$product_name', '$product_price_old', '$product_price_new', '$product_image', '$product_cartegory', '$product_description')";

        $conDataItems = mysqli_query($connection, $insertItems);

        //making sure the items are sent to the db
        if($conDataItems)
        {
            move_uploaded_file($_FILES['product_image']['tmp_name'], $target);
            $_SESSION['successMsg'] = "Items added successfully";
            redirect_me_to('index.php');
        }
        else
        {
            $_SESSION['errorMsg'] = "Items not added";
            redirect_me_to('index.php');
        }
    }
}

confirmlogin();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home || Limpua</title>
    <?php require "css.php"; ?>
</head>
<body>
    <?php require "_header.php"; ?>
    <br>
    <!-- This is for the form -->
    <div class="container mb-2 mt-1">
        <div class="col-xl-12 m-auto">
            <?php echo myErrorMsg(); echo mySuccessMsg(); ?>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-xl-6">
                        <label for="">Product Name</label>
                        <input type="text" class="form-control" name="product_name" required>
                    </div>
                    <div class="col-xl-6 mt-xl-0 mt-3">
                        <label for="">Product Price Old</label>
                        <input type="text" class="form-control" name="product_price_old" required>
                    </div>

                    <!-- Second tab -->
                    <div class="col-xl-6 mt-xl-3 mt-3">
                        <label for="">Product Price New</label>
                        <input type="text" class="form-control" name="product_price_new" required>
                    </div>
                    <div class="col-xl-6 mt-xl-3 mt-3">
                        <label for="">Product Image</label>
                        <input type="file" class="form-control p-2" name="product_image" accept=".jpeg, .jpg" required>
                    </div>

                    <!-- Third tab -->
                    <div class="col-xl-6 mt-xl-3 mt-3">
                        <label for="">Product Cartegory</label>
                        <input type="text" class="form-control" name="product_cartegory" required>
                    </div>
                    <div class="col-xl-6 mt-xl-3 mt-3">
                        <label for="">Product Description</label>
                        <input type="text" class="form-control" name="product_description" required>
                    </div>
                </div>
                <div class="mt-3">
                    <button class="btn btn-success btn-md" name="add_items">Add to items</button>
                </div>
            </form>
        </div>
    </div>
    <hr>

    <!-- table displaying the products -->
    <div class="container">
        <h2>Products Table</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Product Price Old</th>
                        <th>Product Price New</th>
                        <th>Product Image</th>
                        <th>Product Cartegory</th>
                        <th>Product Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <!-- Fetching all the items to be displayed -->
                    <?php
                        //get the data items
                        $getItems = "SELECT * FROM items ORDER BY product_id asc";
                        $conItems = mysqli_query($connection, $getItems);

                        $serialNumber = 0;

                        while($items = mysqli_fetch_assoc($conItems))
                        {
                            $productId = $items['product_id'];
                            $productName = $items['product_name'];
                            $productPriceOld= $items['product_price_old'];
                            $productPriceNew = $items['product_price_new'];
                            $productImage = $items['product_image'];
                            $productCartegory = $items['product_cartegory'];
                            $productDescription = $items['product_description'];
                            $serialNumber++;
                    ?>
                    <tr>
                        <td><?php echo $serialNumber ?></td>
                        <td><?php echo $productName ?></td>
                        <td><del>$<?php echo $productPriceOld ?></del></td>
                        <td>$<?php echo $productPriceNew ?></td>
                        <td><?php echo $productImage?></td>
                        <td><?php echo $productCartegory?></td>
                        <td><?php echo $productDescription ?></td>
                        <td class="text-center"><a href="edit_item.php?product_id=<?php echo $productId ?>" class="btn btn-success btn-sm">Edit</a> <a href="delete_item.php?product_id=<?php echo $productId ?>" class="btn btn-danger btn-sm mt-1">Delete</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

<?php require "scripts.php";?>
</body>
</html>