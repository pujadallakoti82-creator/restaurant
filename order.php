<?php
include('config/constants.php');

// Check login before any HTML output
if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
}

include('partials-front/menu.php');

// Prepare items array
$items = [];

// CASE 1: Direct order from food item
if (isset($_GET['food_id'])) {
    $food_id = $_GET['food_id'];
    $sql = "SELECT * FROM food WHERE id=$food_id";
    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) == 1){
        $row = mysqli_fetch_assoc($res);
        $items[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'price' => $row['price'],
            'image' => $row['image_name'],
            'qty' => 1
        ];
    } else {
        header('location:' . SITEURL);
        exit();
    }

// CASE 2: Order from cart
} elseif (isset($_GET['from']) && $_GET['from'] == 'cart') {

    $user_id = $_SESSION['user_id'];
    $res_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id=$user_id");

    if(mysqli_num_rows($res_cart) > 0){
        while($row = mysqli_fetch_assoc($res_cart)){
            $items[] = [
                'id' => $row['item_id'],
                'title' => $row['item_name'],
                'price' => $row['item_price'],
                'image' => $row['image_name'],
                'qty' => $row['quantity']
            ];
        }
    } else {
        echo "<p>Your cart is empty.</p>";
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

// Process order on submit before HTML output
if(isset($_POST['submit'])){
    $customer_name = $_POST['full-name'];
    $customer_contact = $_POST['contact'];
    $customer_email = $_POST['email'];
    $customer_address = $_POST['address'];
    $order_date = date("Y-m-d H:i:s");
    $status = "Ordered";
    $payment_method = $_POST['payment_method'] ?? 'cash';

    $food_ids = $_POST['food_id'];
    $qtys = $_POST['qty'];
    $grand_total = 0;
    $first_order_id = null;
    $payment_reference = ($payment_method === 'esewa') ? 'TXN-' . date('YmdHis') . '-' . rand(1000, 9999) : 'CASH-' . date('YmdHis') . '-' . rand(1000, 9999);

    foreach($food_ids as $index => $fid){
        $qty = (int) $qtys[$index];

        $res_food = mysqli_query($conn, "SELECT * FROM food WHERE id=$fid");
        $row_food = mysqli_fetch_assoc($res_food);

        $price = $row_food['price'];
        $total = $price * $qty;
        $grand_total += $total;

        $sql_order = "INSERT INTO tbl_order SET
            food = '".$row_food['title']."',
            price = $price,
            quantity = $qty,
            total = $total,
            order_date = '$order_date',
            status = '$status',
            payment_status = '" . (($payment_method === 'esewa') ? 'Pending' : 'Cash on Delivery') . "',
            transaction_id = '$payment_reference',
            customer_name = '$customer_name',
            customer_contact = '$customer_contact',
            customer_email = '$customer_email',
            customer_address = '$customer_address'
        ";

        mysqli_query($conn, $sql_order);

        if ($first_order_id === null) {
            $first_order_id = mysqli_insert_id($conn);
        }
    }

    // If order was from cart, clear the cart
    if(isset($_GET['from']) && $_GET['from'] == 'cart'){
        $user_id = $_SESSION['user_id'];
        mysqli_query($conn, "DELETE FROM cart WHERE user_id=$user_id");
    }

    if ($payment_method === 'esewa') {
        header("Location: payment.php?order_id=$first_order_id&transaction_id=$payment_reference&amount=$grand_total");
        exit();
    }

    $_SESSION['order_success'] = "<div class='success'>Order placed successfully. Please pay cash on delivery.</div>";
    header("Location: " . SITEURL . "foods.php");
    exit();
}
?>

<!-- FOOD ORDER FORM -->
<section class="food-search">
    <div class="container">
        <h2 class="text-center text-black">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order" onsubmit="return validateOrderForm()">
            <fieldset>
                <legend>Selected Food</legend>

                <?php $grandTotal = 0; ?>

                <?php foreach($items as $item): ?>
                    <?php $total = $item['price'] * $item['qty']; $grandTotal += $total; ?>
                    <div class="selected-food-box">
                        <div class="food-menu-img">
                            <?php if($item['image'] != ""): ?>
                                <img src="<?php echo SITEURL; ?>image/food/<?php echo $item['image']; ?>" class="img-responsive img-curve">
                            <?php else: ?>
                                <p>Image not available</p>
                            <?php endif; ?>
                        </div>

                        <div class="food-menu-desc">
                            <h3><?php echo $item['title']; ?></h3>
                            <p class="food-price">Rs <?php echo $item['price']; ?></p>
                            <div class="selected-food-meta">
                                <div>
                                    <div class="order-label">Qty</div>
                                    <input type="number" class="input-responsive" value="<?php echo $item['qty']; ?>" readonly>
                                </div>
                                <div class="order-total-box">
                                    <span>Total</span>
                                    <strong>Rs <?php echo $total; ?></strong>
                                </div>
                            </div>
                            <input type="hidden" name="food_id[]" value="<?php echo $item['id']; ?>">
                            <input type="hidden" name="qty[]" value="<?php echo $item['qty']; ?>">
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="grand-total-wrap">
                    <h3>Grand Total: <span>Rs <?php echo $grandTotal; ?></span></h3>
                </div>
            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Pooja Dallakoti" class="input-responsive" required minlength="3" pattern="[A-Za-z ]+" title="Only letters and spaces allowed" value="<?php echo htmlspecialchars($user_name); ?>" readonly>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 98/97{xxxxxxxx}" class="input-responsive" required  pattern="98[0-9]{8}|97[0-9]{8}" title="Enter a valid 10-digit mobile number">

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. hi@pujadk.com" class="input-responsive" readonly value="<?php echo htmlspecialchars($user_email); ?>">

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required minlength="5" title="Minimum 5 characters required"></textarea>

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

<script src="main.js"></script>

<?php include('partials-front/footer.php'); ?>
