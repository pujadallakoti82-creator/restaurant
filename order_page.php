<?php include('partials-front/menu.php'); ?>

    <?php
// Check login
 if(!isset($_SESSION['user_id'])){
    header('location:login.php');
     exit();
 }

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
?>

<!-- -------------------- ORDER FORM -------------------- -->
<section class="food-search">
<div class="container">

<h2 class="text-center text-black">
    Fill this form to confirm your order
</h2>

<form action="" method="POST" class="order">

<!-- -------------------- SELECTED FOOD -------------------- -->
<fieldset>
<legend>Selected Food</legend>

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
    <p class="food-price">$<?php echo $price; ?></p>

    <!-- Hidden values for backend -->
    <input type="hidden" name="food" value="<?php echo $title; ?>">
    <input type="hidden" name="price" class="price" value="<?php echo $price; ?>">

    <!-- Quantity input -->
    <div class="order-label">Quantity</div>
    <input type="number"
           name="quantity"
           class="quantity input-responsive"
           value="1"
           min="1"
           required>

    <!-- Live total -->
    <p>Total: $<span class="total-price"><?php echo $price; ?></span></p>

</div>
</fieldset>

<!-- -------------------- DELIVERY DETAILS -------------------- -->
<fieldset>
<legend>Delivery Details</legend>

<div class="order-label">Full Name</div>
<input type="text" name="full-name" placeholder="E.g.Pooja Dallakoti" class="input-responsive" required>

<div class="order-label">Phone Number</div>
<input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

<div class="order-label">Email</div>
<input type="email" name="email"  placeholder="E.g. hi@pujadk.com" class="input-responsive" required>

<div class="order-label">Address</div>
<textarea name="address" rows="5"  placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

<input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">

</fieldset>
</form>

<?php
// -------------------- PROCESS ORDER --------------------
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

    // Insert into database
    $sql2 = "INSERT INTO tbl_order SET
        food = '$food',
        price = $price,
        quantity = $quantity,
        total = $total,
        order_date = '$order_date',
        status = '$status',
        customer_name = '$customer_name',
        customer_contact = '$customer_contact',
        customer_email = '$customer_email',
        customer_address = '$customer_address'
    ";

    $res2 = mysqli_query($conn, $sql2);

    if ($res2 == true) {
        echo "<script>
            alert('Order placed successfully');
            window.location='foods.php';
        </script>";
    } else {
        echo "<script>
            alert('Order failed');
        </script>";
    }
}
?>

</div>
</section>

<!-- Load JS AFTER HTML -->
<script src="main.js"></script>

<?php include('partials-front/footer.php'); ?>
