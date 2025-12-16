<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php 
             if(isset($_SESSION['add']))//chceking whether the session is set or not
             {
                echo $_SESSION['add'];//display the session message if set
                unset ($_SESSION['add']); //remove session message
             }

        ?>

        <form action="" method="POST" onsubmit="return validateAdminForm()">

        <table class="tbl-30">
            <tr>
                <td>Full Name:</td>
                <td> <input type="text" name="full_name" placeholder="Enter your name" ></td>
            </tr>

            <tr>
                <td>Username:</td>
                <td><input type="text" name="username" placeholder="Your Username"></td>
            </tr>

             <tr>
                <td>Password:</td>
                <td><input type="password" name="password" placeholder="Your Password"></td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
            </td>
            </tr>


        </table>

        </form>    
    </div>
</div>

<?php include('partials/footer.php'); ?>


<?php
//Process the value from form and save it in database

//check whether the button is clicked or not 

if(isset($_POST['submit']))
{
    //Button Clicked
   // echo"Button Clicked";

   //1. get the data from form
   $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $password = md5($_POST['password']);  //Password encryption with md5

   //2. sql query to save data into database
   $sql = "insert into admin SET  
           full_name = '$full_name',
           username = '$username',
           password = '$password'
           ";

         //3. this code is inside config in constants
          
         
         //4. Executing query and saving data into database
         $result = mysqli_query($conn, $sql) or die(mysqli_error());


         //5. check whether the (Query is executed) data is inserted or not and display appropriate message
         if($result==TRUE)
         {
            //Data inserted
            //echo "Data inserted";

            //create a session variable to display message
            $_SESSION['add'] = "<div class='success'>Admin Added Successfully.</div>";
            //Redirect page
            header("location:".SITEURL.'admin/manage-admin.php');


         }
         else
         {
            //failed to insert data
           // echo "Failed to insert data";

           //create a session variable to display message
            $_SESSION['add'] = "<div class='error'>Failed to add admin.</div>";
            //Redirect page to add admin
            header("location:".SITEURL.'admin/add-admin.php');


         }


}



?>