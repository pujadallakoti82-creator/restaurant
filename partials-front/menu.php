<?php include('config/constants.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Ordering Website</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
       <!-- HEADER -->
<header class="nav">
    <div class="logo"><h1>Foodie<b>Us</b></h1></div>
    <nav>
        <ul>
            <li> <a href="<?php echo SITEURL; ?>home.php">Home</a> </li>
           <li><a href="<?php echo SITEURL; ?>categories.php">Categories</a> </li>
          <li> <a href="<?php echo SITEURL; ?>foods.php">Menu</a> </li>
           <li><a href="<?php echo SITEURL; ?>contact.php">Contact</a></li>
        </ul>
    </nav>
    </header>

    

    <?php
// Get current page name
$current_page = basename($_SERVER['PHP_SELF']);

// Optional: get user_id from session if using login system
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Count items in cart
$cart_count = 0;
if($user_id > 0) {
    $sql = "SELECT SUM(quantity) AS count FROM cart WHERE user_id='$user_id'";
    $res = mysqli_query($conn, $sql);
    if($res) {
        $row = mysqli_fetch_assoc($res);
        $cart_count = $row['count'] ? $row['count'] : 0;
    }
}
?>

<?php if($current_page == 'foods.php' || $current_page == 'category-foods.php'): ?>
    <div class="cart-container">
        <a href="<?php echo SITEURL; ?>cart.php" class="cart-icon">
            <i class="fa fa-shopping-cart"></i>
            <span class="cart-count"><?php echo $cart_count; ?></span>
        </a>
    </div>
<?php endif; ?>
