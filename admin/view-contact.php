<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Contact Messages</h1>
        <br>

        <?php
        if(isset($_SESSION['delete'])){
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        ?>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Message</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>

            <?php
            // Fetch all messages from database
            $sql = "SELECT * FROM tbl_contact ORDER BY created_at DESC";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            $sn = 1;

            if($count > 0){
                while($row = mysqli_fetch_assoc($res)){
                    $id = $row['id'];
                    $name = $row['name'];
                    $email = $row['email'];
                    $phone = $row['phone'];
                    $message = $row['message'];
                    $date = $row['created_at'];
                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $phone; ?></td>
                        <td><?php echo $message; ?></td>
                        <td><?php echo $date; ?></td>
                        <td>
                            <a href="delete-contact.php?id=<?php echo $id; ?>" class="btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='7'><div class='error'>No messages found.</div></td></tr>";
            }
            ?>
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
