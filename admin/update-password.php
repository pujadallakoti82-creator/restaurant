<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
        if(isset($_GET['id']))
        {
            $id=$_GET['id'];
        }
        ?>

        <form action="" method="POST" onsubmit="return validatePasswordForm()">

          <table class="tbl-30">
            <tr>
                <td>Current Password: </td>
                <td>
                    <input type="password" name="current_password" placeholder="Current Password">
                </td>
            </tr>

            <tr>
                <td>New Password: </td>
                <td>
                    <input type="password" name="new_password" placeholder="New Password">
                </td>
            </tr>

            <tr>
                <td>Confirm Password: </td>
                <td>
                   <input type="password" name="confirm_password" placeholder="Confirm Password">

                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>" >
                    <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                </td>
            </tr>
          </table>

        </form>

        <?php 

        //check whether the submit button is clicked or not
        if(isset($_POST['submit']))
        {
            //echo "Clicked";

            //1.get the data from form
            $id=$_POST['id'];
            $current_password = md5($_POST['current_password']);
            $new_password = md5($_POST['new_password']);
           $confirm_password = md5($_POST['confirm_password']);


            //2. check whether the user with current id and current password exists or not
            $sql1 = "SELECT * FROM ADMIN WHERE id=$id AND password='$current_password'";


            //3. check whether the new password and confirm the password match or not
            $result = mysqli_query($conn, $sql1);
            if($result==true)
            {
                //check whether data is available or not
                $count = mysqli_num_rows($result);

                if($count==1)
                {
                    //user exists and password can be changed
                   // echo "User Found";

                   //check whether the new password and confirm password match or nor
                   if($new_password==$confirm_password)
                   {
                    //update the password
                    $sql2 = "UPDATE admin SET
                       password = '$new_password'
                       WHERE id=$id
                       ";
                   
                   //Execute the query
                   $result2 = mysqli_query($conn, $sql2);

                   //check whether the query executed or not
                   if($result2==true)
                   {
                    //display the success message
                    //redirect to manage admin page with success message
                     $_SESSION['change-pwd'] = "<div class='success'>Passowrd Changed Successfully. </div>";
                    //redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                   }
                   else{
                    //display the error message
                     //redirect to manage admin page with error message
                     $_SESSION['change-pwd'] = "<div class='error'>Failed to change password. </div>";
                    //redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');

                   }
                }

                   else{
                    //redirect to manage admin page with error message
                     $_SESSION['pwd-not-match'] = "<div class='error'>Passowrd didnot match. </div>";
                    //redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                   }

                }
                else{
                    //user does not exist set message and redirect
                    $_SESSION['user-not-found'] = "<div class='error'>User Not Found. </div>";
                    //redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
                
            }


            //4. change password if all above id true
        }


        ?>



    </div>
</div>






<?php include('partials/footer.php'); ?>