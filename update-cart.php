<?php
include('config/constants.php');

if(isset($_POST['cart_id']) && isset($_POST['quantity'])){
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    // get item price
    $sql = "SELECT item_price FROM cart WHERE id='$cart_id'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);

    $total_price = $row['item_price'] * $quantity;

    $update_sql = "UPDATE cart SET quantity='$quantity', total_price='$total_price' WHERE id='$cart_id'";
    mysqli_query($conn, $update_sql);

    header("location:cart.php");
    exit();
}
?>
