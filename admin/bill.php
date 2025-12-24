<?php include('partials/menu.php'); ?>

<?php
// Check if order_id is set
if(isset($_GET['order_id'])){

    $order_id = $_GET['order_id'];

    // Fetch order details
    $sql = "SELECT * FROM tbl_order WHERE id=$order_id";
    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) == 1){
        $row = mysqli_fetch_assoc($res);

        $food = $row['food'];
        $price = $row['price'];
        $quantity = $row['quantity'];
        $total = $row['total'];
        $order_date = $row['order_date'];
        $customer_name = $row['customer_name'];
        $customer_contact = $row['customer_contact'];
        $customer_email = $row['customer_email'];
        $customer_address = $row['customer_address'];
    } else {
        header('location:manage-order.php');
    }

} else {
    header('location:manage-order.php');
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Order Bill</h1>

        <hr>

        <p><strong>Order ID:</strong> <?php echo $order_id; ?></p>
        <p><strong>Order Date:</strong> <?php echo $order_date; ?></p>

        <hr>

        <h3>Food Details</h3>
        <p>Food Name: <?php echo $food; ?></p>
        <p>Price: $<?php echo $price; ?></p>
        <p>Quantity: <?php echo $quantity; ?></p>
        <p><strong>Total Amount: $<?php echo $total; ?></strong></p>

        <hr>

        <h3>Customer Details</h3>
        <p>Name: <?php echo $customer_name; ?></p>
        <p>Contact: <?php echo $customer_contact; ?></p>
        <p>Email: <?php echo $customer_email; ?></p>
        <p>Address: <?php echo $customer_address; ?></p>

        <br>

        <!-- Print Button -->
        <button onclick="window.print()" class="btn btn-primary">Print Bill</button>

    </div>
</div>

<?php include('partials/footer.php'); ?>
