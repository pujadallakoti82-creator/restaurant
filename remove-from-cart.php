<?php
include('config/constants.php');

if(isset($_GET['id'])){
    $cart_id = $_GET['id'];
    $sql = "DELETE FROM cart WHERE id='$cart_id'";
    mysqli_query($conn, $sql);
    header("location:cart.php");
    exit();
}
?>
