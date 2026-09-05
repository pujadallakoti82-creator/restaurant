<?php
include('../config/constants.php');

if(isset($_SESSION['user']))
{
    header('location:'.SITEURL.'admin/index.php');
    exit();
}
?>

<html>
    <head>
        <title>Admin Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body class="admin-auth-body">
        <div class="auth-shell">
            <div class="auth-card">
                <div class="auth-brand">
                    <span class="brand-mark">R</span>
                    <div>
                        <strong>Restaurant Admin</strong>
                        <small>Secure Login</small>
                    </div>
                </div>

                <h1>Welcome back</h1>
                <p class="auth-subtitle">Sign in to manage your restaurant dashboard.</p>

                <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset ($_SESSION['login']);
                }
                ?>

                 <?php
                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset ($_SESSION['no-login-message']);
                }
                ?>

                <form action="" method="POST" onsubmit="return validateAdminLogin()">
                    <div class="field-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter Username">
                    </div>

                    <div class="field-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter Password">
                    </div>

                    <button type="submit" name="submit" class="btn-primary auth-btn">Login</button>
                </form>

                <p class="text-center auth-footer">Powered by <a href="">Pooja & Grishma</a></p>
            </div>
        </div>
    </body>
</html>


    <?php

//check whether the submit button is clicked or not
if(isset($_POST['submit']))
{
    //process for login
    //1. Get the data from login form
   // $username = $_POST['username'];
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = md5($_POST['password']);

   //2. SQL to check whether the user with username and password exists or not
   $sql = "SELECT * FROM admin WHERE  username='$username' AND password='$password'";

   //3.Execute the query
    $res = mysqli_query($conn, $sql);

    //4. Count rows to check whether the user exists or not
    $count = mysqli_num_rows($res);

    if($count==1)
    {
        //user available and login success
        $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
        $_SESSION['user'] = $username;   //to check whether the user is logged in or not and logout will unset it


        //redirect to home page dashboard
        header('location:'.SITEURL.'admin/index.php');
        exit();
    }
    else{
        //user not available and login fail
        $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
        //redirect to home page dashboard
        header('location:'.SITEURL.'admin/login.php');
        exit();
    }

}

    ?>

    <script src="../main.js"></script>
