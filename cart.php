<?php
include('partials-front/menu.php');
?>

<?php
// Check login
if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
}
?>

<div class="cart-page">
    <div class="container cart-layout">
        <div class="cart-panel">
            <div class="cart-header">
                <div>
                    <span class="cart-badge">Your basket</span>
                    <h2>Your Cart</h2>
                </div>
            </div>

            <?php
            $user_id = $_SESSION['user_id'];

            if(isset($_GET['remove'])){
                $remove_id = $_GET['remove'];
                mysqli_query($conn, "DELETE FROM cart WHERE id=$remove_id AND user_id=$user_id");
                header('location:cart.php');
                exit();
            }

            if(isset($_GET['update']) && isset($_GET['qty'])){
                $cart_id = $_GET['update'];
                $qty = (int) $_GET['qty'];
                $max_quantity = defined('MAX_ORDER_QUANTITY') ? MAX_ORDER_QUANTITY : 10;

                if($qty > $max_quantity){
                    $qty = $max_quantity;
                }

                if($qty <= 0){
                    mysqli_query($conn, "DELETE FROM cart WHERE id=$cart_id AND user_id=$user_id");
                } else {
                    mysqli_query($conn, "
                        UPDATE cart 
                        SET quantity=$qty, total_price=item_price*$qty 
                        WHERE id=$cart_id AND user_id=$user_id
                    ");
                }
                header('location:cart.php');
                exit();
            }

            $res = mysqli_query($conn, "SELECT * FROM cart WHERE user_id=$user_id");

            if(mysqli_num_rows($res) > 0){
                $grand_total = 0;
                ?>

                <div class="cart-items">
                    <?php while($row = mysqli_fetch_assoc($res)) { 
                        $grand_total += $row['total_price'];
                    ?>
                        <div class="cart-item-card">
                            <div class="cart-item-image">
                                <?php if($row['image_name'] != '') { ?>
                                    <img src="image/food/<?php echo $row['image_name']; ?>" alt="<?php echo $row['item_name']; ?>">
                                <?php } else { ?>
                                    <div class="image-placeholder">No Image</div>
                                <?php } ?>
                            </div>

                            <div class="cart-item-info">
                                <h3><?php echo $row['item_name']; ?></h3>
                                <p>Price: Rs <?php echo $row['item_price']; ?></p>
                            </div>

                            <div class="cart-qty-box">
                                <a href="cart.php?update=<?php echo $row['id']; ?>&qty=<?php echo max(0, $row['quantity'] - 1); ?>" class="qty-btn" title="Decrease quantity">-</a>
                                <span><?php echo min(MAX_ORDER_QUANTITY, $row['quantity']); ?></span>
                                <a href="cart.php?update=<?php echo $row['id']; ?>&qty=<?php echo min(MAX_ORDER_QUANTITY, $row['quantity'] + 1); ?>" class="qty-btn" title="Increase quantity">+</a>
                            </div>

                            <div class="cart-item-total">
                                Rs <?php echo $row['total_price']; ?>
                            </div>

                            <a href="cart.php?remove=<?php echo $row['id']; ?>" class="cart-remove-btn">Remove</a>
                        </div>
                    <?php } ?>
                </div>

            <?php } else { ?>
                <div class="empty-cart">
                    <div class="empty-cart-icon"><i class="fa fa-shopping-basket"></i></div>
                    <h3>Your cart is empty</h3>
                    <p>Add a few delicious dishes to continue.</p>
                    <a href="foods.php" class="primary-btn">Browse Menu</a>
                </div>
            <?php } ?>
        </div>

        <?php if(mysqli_num_rows($res) > 0) { ?>
            <aside class="cart-summary">
                <h3>Order Summary</h3>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>Rs <?php echo $grand_total; ?></span>
                </div>
                <div class="summary-row">
                    <span>Delivery</span>
                    <span>Free</span>
                </div>
                <div class="summary-row total-row">
                    <span>Total</span>
                    <span>Rs <?php echo $grand_total; ?></span>
                </div>
                <a href="order.php?from=cart" class="checkout-btn">Proceed to Checkout</a>
            </aside>
        <?php } ?>
    </div>
</div>

<?php
include('partials-front/footer.php');
?>
