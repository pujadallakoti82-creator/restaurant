      <?php include('partials-front/menu.php'); ?>

      <?php

        //check whether food is set or not
        if (isset($_GET['food_id'])) {
            //get the food and details of the selected food
            $food_id = $_GET['food_id'];

            //get the details of the selected food
            $sql = "SELECT * FROM food where id=$food_id";

            //execute the query
            $res = mysqli_query($conn, $sql);

            //count the rows
            $count = mysqli_num_rows($res);

            //check whether the data available or not
            if ($count == 1) {
                //we have the data
                //get the data from database
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
            } else {
                //food not available
                //redirect to home page
                header('location:' . SITEURL);
            }
        } else {
            //redirect to home page
            header('location:' . SITEURL);
        }

        ?>



      <!-- fOOD sEARCH Section Starts Here -->
      <section class="food-search">
          <div class="container">

              <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

              <form action="" method="POST" class="order" onsubmit="return validateOrderForm()">
                  <fieldset>
                      <legend>Selected Food</legend>

                      <div class="food-menu-img">

                          <?php

                            //check whether image available or not
                            if ($image_name == "") {
                                //image not available
                                echo "<div class='error'>Image not Available.</div>";
                            } else {
                                //image available
                            ?>
                              <img src="<?php echo SITEURL; ?>image/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                          <?php

                            }

                            ?>

                      </div>

                      <div class="food-menu-desc">
                          <h3><?php echo $title; ?></h3>
                          <input type="hidden" name="food" value="<?php echo $title; ?>">

                          <p class="food-price"><?php echo $price; ?></p>
                          <input type="hidden" id="price" name="price" value="<?php echo $price; ?>">

                          <div class="order-label">Quantity</div>
                          <input type="number" id="quantity" name="quantity" class="input-responsive" value="1"  min="1" required>
                          <p>Total: $<span id="total-price"></span></p>
                      </div>

                  </fieldset>

                  <fieldset>
                      <legend>Delivery Details</legend>
                      <div class="order-label">Full Name</div>
                      <input type="text" name="full-name" placeholder="E.g.Pooja Dallakoti" class="input-responsive" required>

                      <div class="order-label">Phone Number</div>
                      <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                      <div class="order-label">Email</div>
                      <input type="email" name="email" placeholder="E.g. hi@pujadk.com" class="input-responsive" required>

                      <div class="order-label">Address</div>
                      <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                      <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                  </fieldset>

              </form>

              <?php
                //check whether submit button is clicked or not
                if (isset($_POST['submit'])) {
                    //get all the details from the form

                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $quantity = $_POST['quantity'];

                    $total = $price * $quantity; //total = price * quantity

                    $order_date = date("Y-m-d H:i:s");  //order date

                    $status = "Ordered"; //ordered, on delivery, delivered, cancelled

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];


                    //save the order indatabase
                    //create sql to save the data
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
                          ";          //order is reserve keyword in sql so use ''

                    //echo $sql2; die();

                    //execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    //check whether query executed successfully or not
                    if ($res2 == true) {
                        //query executed and order saved
                        $_SESSION['order'] = "Ordered successfully";

                        echo "<script>
        alert('Ordered successfully');
        window.location = 'foods.php';
      </script>";
                    } else {
                        //failed to save order
                        $_SESSION['order'] = "Failed to order food ";

                        echo "<script>
        alert('Failed ');
        window.location = 'foods.php';
      </script>";
                    }
                }
                ?>

          </div>
      </section>
      <!-- fOOD sEARCH Section Ends Here -->
      <script src="main.js"></script>

      <?php include('partials-front/footer.php'); ?>