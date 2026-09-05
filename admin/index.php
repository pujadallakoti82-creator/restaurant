<?php include('partials/menu.php'); ?>


<!---Main conntent section starts--->
        <div class="main-content">
             <div class="wrapper">
                <div class="page-hero">
                    <div>
                        <span class="eyebrow">Overview</span>
                        <h1>DASHBOARD</h1>
                    </div>
                    <div class="hero-status">
                        <span class="online-dot"></span>
                        System running
                    </div>
                </div>

     <?php
        if(isset($_SESSION['login']))
        {
            echo $_SESSION['login'];
            unset ($_SESSION['login']);
        }
        ?>
<br><br>
                <div class="dashboard-grid">
                    <div class="col-4">
                        <?php
                             $sql = "SELECT * FROM category";
                             $res = mysqli_query($conn, $sql);
                             $count = mysqli_num_rows($res);
                        ?>
                        <span class="stat-label">Categories</span>
                        <h1><?php echo $count; ?></h1>
                    </div>

                     <div class="col-4">
                       <?php
                         $sql2 = "SELECT * FROM food";
                         $res2 = mysqli_query($conn, $sql2);
                         $count2 = mysqli_num_rows($res2);
                    ?>
                        <span class="stat-label">Foods</span>
                        <h1><?php echo $count2; ?></h1>
                    </div>

                     <div class="col-4">
                         <?php
                         $sql3 = "SELECT * FROM tbl_order";
                         $res3 = mysqli_query($conn, $sql3);
                         $count3 = mysqli_num_rows($res3);
                    ?>
                        <span class="stat-label">Total Orders</span>
                        <h1><?php echo $count3; ?></h1>
                    </div>

                     <div class="col-4">
                     <?php
                     $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";
                     $res4 = mysqli_query($conn, $sql4);
                     $row4 = mysqli_fetch_assoc($res4);
                     $total_revenue = $row4['Total'];
                     ?>
                        <span class="stat-label">Revenue</span>
                        <h1>Rs <?php echo $total_revenue; ?> </h1>
                    </div>
                </div>

                <div class="dashboard-panels">
                    <div class="panel dashboard-panel">
                        <div class="panel-header">
                            <h3>Quick Actions</h3>
                        </div>
                        <div class="quick-actions">
                            <a href="manage-food.php" class="action-btn"><span>+</span> Add Food</a>
                            <a href="manage-category.php" class="action-btn"><span>+</span> Add Category</a>
                            <a href="manage-order.php" class="action-btn"><span>✓</span> View Orders</a>
                            <a href="view-contact.php" class="action-btn"><span>✉</span> Messages</a>
                        </div>
                    </div>

                    <div class="panel dashboard-panel">
                        <div class="panel-header">
                            <h3>Recent Orders</h3>
                        </div>

                        <table class="mini-table">
                            <tr>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>

                            <?php
                            $recent_sql = "SELECT * FROM tbl_order ORDER BY id DESC LIMIT 5";
                            $recent_res = mysqli_query($conn, $recent_sql);

                            if(mysqli_num_rows($recent_res) > 0)
                            {
                                while($recent_row = mysqli_fetch_assoc($recent_res))
                                {
                                    $customer_name = $recent_row['customer_name'];
                                    $total = $recent_row['total'];
                                    $status = $recent_row['status'];
                                    ?>
                                    <tr>
                                        <td><?php echo $customer_name; ?></td>
                                        <td>Rs <?php echo $total; ?></td>
                                        <td><span class="status-badge <?php echo strtolower(str_replace(' ', '-', $status)); ?>"><?php echo $status; ?></span></td>
                                    </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <td colspan="3">No recent orders</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>


                 <div class="clearfix"></div>
                 

            </div>
            
       </div>

        <!---Main conntent section ends--->


    <?php include('partials/footer.php'); ?>

    