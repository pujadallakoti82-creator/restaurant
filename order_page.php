<?php
include('config/constants.php');

// Check login before any HTML output
if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
}

include('partials-front/menu.php');
?>

<?php
// -------------------- FETCH FOOD DETAILS --------------------

// Check if food_id exists in URL
if (isset($_GET['food_id'])) {

    $food_id = $_GET['food_id'];

    // Fetch food data
    $sql = "SELECT * FROM food WHERE id=$food_id";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $price = $row['price'];
        $image_name = $row['image_name'];
    } else {
        header('location:' . SITEURL);
        exit();
    }

} else {
    header('location:' . SITEURL);
    exit();
}

$user_id = $_SESSION['user_id'];

// Get the logged-in user's email (because tbl_order stores customer_email)
$sql_user = "SELECT email, name FROM users WHERE id='$user_id'";
$res_user = mysqli_query($conn, $sql_user);

if ($res_user && mysqli_num_rows($res_user) === 1) {
    $user_data = mysqli_fetch_assoc($res_user);
    $user_email = $user_data['email'] ?? '';
    $user_name = $user_data['name'] ?? '';
} else {
    header('location:login.php');
    exit();
}

// -------------------- PROCESS ORDER BEFORE HTML OUTPUT --------------------
if (isset($_POST['submit'])) {

    // Get form data
    $food = $_POST['food'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Calculate total securely in PHP
    $total = $price * $quantity;

    $order_date = date("Y-m-d H:i:s");
    $status = "Ordered";

    $customer_name = $_POST['full-name'];
    $customer_contact = $_POST['contact'];
    $customer_email = $_POST['email'];
    $customer_address = $_POST['address'];
    $payment_method = $_POST['payment_method'] ?? 'cash';

    // Insert into database
    $sql2 = "INSERT INTO tbl_order SET
        food = '$food',
        price = $price,
        quantity = $quantity,
        total = $total,
        order_date = '$order_date',
        status = '$status',
        payment_status = 'Pending',
        customer_name = '$customer_name',
        customer_contact = '$customer_contact',
        customer_email = '$customer_email',
        customer_address = '$customer_address'
    ";

    $res2 = mysqli_query($conn, $sql2);
    if ($res2 == true) {

        // Get the newly created order ID
        $order_id = mysqli_insert_id($conn);

        if ($payment_method === 'esewa') {
            // Create a unique transaction ID for eSewa
            $transaction_id = "TXN-" . date("YmdHis") . "-" . $order_id . "-" . rand(1000, 9999);

            // Save transaction ID in database
            $update_sql = "UPDATE tbl_order
                           SET transaction_id='$transaction_id', payment_status='Pending'
                           WHERE id='$order_id'";

            mysqli_query($conn, $update_sql);

            // Go to payment page
            header("Location: payment.php?order_id=$order_id&transaction_id=$transaction_id&amount=$total&payment_method=esewa");
            exit();
        } else {
            $cash_transaction = "CASH-" . date("YmdHis") . "-" . $order_id;

            $update_sql = "UPDATE tbl_order
                           SET transaction_id='$cash_transaction', payment_status='Cash on Delivery'
                           WHERE id='$order_id'";

            mysqli_query($conn, $update_sql);

            $_SESSION['order_success'] = "<div class='success'>Order placed successfully. Please pay cash on delivery.</div>";
            header("Location: " . SITEURL . "foods.php");
            exit();
        }
    } else {
        echo "<script>
            alert('Order failed');
        </script>";
    }
}
?>



<!-- -------------------- ORDER FORM -------------------- -->
<section class="food-search">
<div class="container">

<h2 class="text-center text-black">
    Fill this form to confirm your order
</h2>

<form action="" method="POST" class="order" onsubmit="return validateOrderForm()">

<!-- -------------------- SELECTED FOOD -------------------- -->
<fieldset>
<legend>Selected Food</legend>

<div class="selected-food-box">
    <div class="food-menu-img">
    <?php if ($image_name != "") { ?>
        <img src="<?php echo SITEURL; ?>image/food/<?php echo $image_name; ?>"
             class="img-responsive img-curve">
    <?php } else {
        echo "<div class='error'>Image not available</div>";
    } ?>
    </div>

    <div class="food-menu-desc">

        <!-- Food title -->
        <h3><?php echo $title; ?></h3>

        <!-- Food price display -->
        <p class="food-price">Rs <?php echo $price; ?></p>

        <!-- Hidden values for backend -->
        <input type="hidden" name="food" value="<?php echo $title; ?>">
        <input type="hidden" name="price" class="price" value="<?php echo $price; ?>">

        <div class="selected-food-meta">
            <div>
                <div class="order-label">Quantity</div>
                <input type="number"
                       name="quantity"
                       class="quantity input-responsive"
                       value="1"
                       min="1"
                       max="10"
                       required>
            </div>

            <div class="order-total-box">
                <span>Total</span>
                <strong>Rs <span class="total-price"><?php echo $price; ?></span></strong>
            </div>
        </div>
    </div>
</div>
</fieldset>

<!-- -------------------- DELIVERY DETAILS -------------------- -->
<fieldset>
<legend>Delivery Details</legend>

                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Pooja Dallakoti" class="input-responsive" required minlength="3" pattern="[A-Za-z ]+" title="Only letters and spaces allowed" value="<?php echo htmlspecialchars($user_name); ?>" readonly>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 98/97{xxxxxxxx}" class="input-responsive" required  pattern="98[0-9]{8}|97[0-9]{8}" title="Enter a valid 10-digit mobile number">

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. hi@pujadk.com" class="input-responsive" readonly value="<?php echo htmlspecialchars($user_email); ?>">

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required  minlength="5"  title="Minimum 5 characters required"></textarea>

                <div class="order-label">Payment Method</div>
                <div class="payment-method-group">
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="cash" checked>
                        <span>Cash on Delivery</span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="esewa">
                        <span>Pay via eSewa</span>
                    </label>
                </div>

<input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">

</fieldset>
</form>

</div>
</section>

<!-- Load JS AFTER HTML -->
<script src="main.js"></script>

<?php include('partials-front/footer.php'); ?>
