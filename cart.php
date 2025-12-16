<?php include('partials-front/menu.php'); ?>
<div class="container">
    <h2>Your Cart</h2>

    <?php
    if(!isset($_SESSION['user_id'])){
        echo "<p>Please login to see your cart.</p>";
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Remove item
    if(isset($_GET['remove'])){
        $remove_id = $_GET['remove'];
        mysqli_query($conn, "DELETE FROM cart WHERE id=$remove_id AND user_id=$user_id");
        header('location:cart.php');
        exit();
    }

    // Update quantity
    if(isset($_GET['update']) && isset($_GET['qty'])){
        $cart_id = $_GET['update'];
        $qty = $_GET['qty'];
        if($qty <= 0){
            mysqli_query($conn, "DELETE FROM cart WHERE id=$cart_id AND user_id=$user_id");
        } else {
            mysqli_query($conn, "UPDATE cart SET quantity=$qty, total_price=item_price*$qty WHERE id=$cart_id AND user_id=$user_id");
        }
        header('location:cart.php');
        exit();
    }

    $res = mysqli_query($conn, "SELECT * FROM cart WHERE user_id=$user_id");
    if(mysqli_num_rows($res) > 0){
        echo "<table border='1' cellpadding='10'>
                <tr>
                    <th>Image</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>";

        $grand_total = 0;

        while($row = mysqli_fetch_assoc($res)){
            $grand_total += $row['total_price'];
            echo "<tr>
                    <td><img src='image/food/".$row['image_name']."' width='50'></td>
                    <td>".$row['item_name']."</td>
                    <td>".$row['item_price']."</td>
                    <td>
                        <a href='cart.php?update=".$row['id']."&qty=".($row['quantity']-1)."'>-</a>
                        ".$row['quantity']."
                        <a href='cart.php?update=".$row['id']."&qty=".($row['quantity']+1)."'>+</a>
                    </td>
                    <td>".$row['total_price']."</td>
                    <td><a href='cart.php?remove=".$row['id']."'>Remove</a></td>
                </tr>";
        }

        echo "<tr>
                <td colspan='4'><b>Grand Total</b></td>
                <td colspan='2'><b>".$grand_total."</b></td>
            </tr>";
        echo "</table>";
    } else {
        echo "<p>Your cart is empty.</p>";
    }
    ?>
</div>
<?php include('partials-front/footer.php'); ?>
