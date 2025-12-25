<?php include('partials-front/menu.php'); ?>

<?php
// Check login
if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
}

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
?>

<!-- FOOD ORDER FORM -->
<section class="food-search">
    <div class="container">
        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order" onsubmit="return validateOrderForm()">
            <fieldset>
                <legend>Selected Food</legend>

                <?php $grandTotal = 0; ?>

                <?php foreach($items as $item): ?>
                    <div class="food-menu-box">
                        <?php if($item['image'] != ""): ?>
                            <img src="<?php echo SITEURL; ?>image/food/<?php echo $item['image']; ?>" width="80">
                        <?php else: ?>
                            <p>Image not available</p>
                        <?php endif; ?>

                        <h3><?php echo $item['title']; ?></h3>
                        <p>Price: $<?php echo $item['price']; ?></p>
                        <p>Qty: <?php echo $item['qty']; ?></p>
                        <?php $total = $item['price'] * $item['qty']; $grandTotal += $total; ?>
                        <p><b>Total: $<?php echo $total; ?></b></p>

                        <input type="hidden" name="food_id[]" value="<?php echo $item['id']; ?>">
                        <input type="hidden" name="qty[]" value="<?php echo $item['qty']; ?>">
                    </div>
                    <hr>
                <?php endforeach; ?>

                <h3>Grand Total: $<?php echo $grandTotal; ?></h3>
            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Pooja Dallakoti" class="input-responsive" required minlength="3" pattern="[A-Za-z ]+" title="Only letters and spaces allowed">

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 98/97{xxxxxxxx}" class="input-responsive" required  pattern="98[0-9]{8}|97[0-9]{8}" title="Enter a valid 10-digit mobile number">

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. hi@pujadk.com" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required  minlength="5"  title="Minimum 5 characters required"></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>
        </form>

        <?php
        // Process order on submit
        if(isset($_POST['submit'])){
            $customer_name = $_POST['full-name'];
            $customer_contact = $_POST['contact'];
            $customer_email = $_POST['email'];
            $customer_address = $_POST['address'];
            $order_date = date("Y-m-d H:i:s");
            $status = "Ordered";

            $food_ids = $_POST['food_id'];
            $qtys = $_POST['qty'];
            $grand_total = 0;

            foreach($food_ids as $index => $fid){
                $qty = $qtys[$index];

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
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'
                ";

                mysqli_query($conn, $sql_order);
            }

            // If order was from cart, clear the cart
            if(isset($_GET['from']) && $_GET['from'] == 'cart'){
                $user_id = $_SESSION['user_id'];
                mysqli_query($conn, "DELETE FROM cart WHERE user_id=$user_id");
            }

            echo "<script>
                alert('Ordered successfully!');
                window.location = 'foods.php';
            </script>";
        }
        ?>
    </div>
</section>

<script src="main.js"></script>

<?php include('partials-front/footer.php'); ?>
