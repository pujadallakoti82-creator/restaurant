<?php include('partials-front/menu.php'); ?>

<?php
// Check if user is logged in
if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get the logged-in user's email (because tbl_order stores customer_email)
$sql_user = "SELECT email, name FROM users WHERE id='$user_id'";
$res_user = mysqli_query($conn, $sql_user);
$user_data = mysqli_fetch_assoc($res_user);
$user_email = $user_data['email'];
$user_name = $user_data['name'];

?>

<section class="order-history">
    <div class="container">
        <h2 class="text-center">Your Order History of <?php echo $user_name?></h2>

        <?php
        // Fetch all orders for this user
        $sql = "SELECT * FROM tbl_order WHERE customer_email='$user_email' ORDER BY order_date DESC";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if($count > 0){
            echo "<table class='tbl-order'>
                    <tr>
                        <th>Order ID</th>
                        <th>Food</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Delivery Address</th>
                    </tr>";

                    $sn=1;
            while($row = mysqli_fetch_assoc($res)){
                // Optional: color coding for status
                $status_color = "";
                if($row['status']=="Delivered") $status_color="style='color:green;'";
                elseif($row['status']=="Cancelled") $status_color="style='color:red;'";
                elseif($row['status']=="On Delivery") $status_color="style='color:orange;'";
                echo "<tr>
                        <td>".$sn++."</td>
                        <td>".$row['food']."</td>
                        <td>".$row['price']."</td>
                        <td>".$row['quantity']."</td>
                        <td>".$row['total']."</td>
                        <td $status_color>".$row['status']."</td>
                        <td>".$row['order_date']."</td>
                        <td>".$row['customer_address']."</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "<div class='error'>You have not placed any orders yet.</div>";
        }
        ?>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>
