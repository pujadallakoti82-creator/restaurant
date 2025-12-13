<?php
include('config/constants.php'); // DB connection + session_start()

if (isset($_POST['email'], $_POST['password'])) {

    // Get & sanitize inputs
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = md5($_POST['password']); // md5 password

    // Validation
    if ($email == "" || $_POST['password'] == "") {
        echo "<script>alert('All fields are required'); window.location='login.php';</script>";
        exit();
    }

    // SQL to check user
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $res = mysqli_query($conn, $sql);

    // Check user exists
    if (mysqli_num_rows($res) == 1) {

        // Fetch user data
        $row = mysqli_fetch_assoc($res);

        // Set session
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_email'] = $row['email'];

        // Success alert + redirect
        echo "<script>
                alert('Login successful!');
                window.location='home.php';
              </script>";
    } else {
        // Login failed
        echo "<script>
                alert('Invalid email or password');
                window.location='login.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FoodieUs</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
</head>
<body">
<header class="nav">
<div class="logo" onclick="index_redirect()"><h1>Foodie<b>Us</b></h1></div>
</header>
    <div class="body">

        <div class="form-container">
            <h2>Login</h2>
            <form action="login.php" method="post">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <div class="link">Don't have an account? <a href="register.php">Register here</a></div>
        </div>
    </div>
    <script src="main.js"></script>

    </body>
</html>