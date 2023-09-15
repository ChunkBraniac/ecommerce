<?php 
require "includes/dbconnection.php";
require "includes/functions.php";
require "includes/sessions.php";

$id = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($_GET['product_id'])));

//setting the delete handler
$deleteItem = "DELETE FROM items WHERE product_id = '$id'";
$conDeletion = mysqli_query($connection, $deleteItem);

if($conDeletion)
{
    $_SESSION['successMsg'] = "Item deleted successfully";
    redirect_me_to('index.php');
}

echo myErrorMsg();
echo mySuccessMsg();

?>