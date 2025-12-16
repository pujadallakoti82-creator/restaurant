<?php
include('config/constants.php'); // your database connection

if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
}

if(isset($_GET['food_id'])){
    $food_id = $_GET['food_id'];
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM food WHERE id=$food_id";
    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) == 1){
        $row = mysqli_fetch_assoc($res);
        $food_title = $row['title'];
        $food_price = $row['price'];
        $food_image = $row['image_name'];
        $quantity = 1;
        $total_price = $food_price * $quantity;

        $sql_check = "SELECT * FROM cart WHERE user_id=$user_id AND item_id=$food_id";
        $res_check = mysqli_query($conn, $sql_check);

        if(mysqli_num_rows($res_check) > 0){
            $row_cart = mysqli_fetch_assoc($res_check);
            $new_qty = $row_cart['quantity'] + 1;
            $new_total = $new_qty * $food_price;
            mysqli_query($conn, "UPDATE cart SET quantity=$new_qty, total_price=$new_total WHERE user_id=$user_id AND item_id=$food_id");
        } else {
            mysqli_query($conn, "INSERT INTO cart (user_id,item_id,item_name,item_price,quantity,total_price,image_name) VALUES ($user_id,$food_id,'$food_title',$food_price,$quantity,$total_price,'$food_image')");
        }

        // Redirect back to the page where the user clicked "Add to Cart"
         $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'foods.php';
         header('location:'.$redirect);
exit();
    } else {
        header('location:index.php');
        exit();
    }
} else {
    header('location:index.php');
    exit();
}
?>
