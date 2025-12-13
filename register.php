<?php
include('config/constants.php');

if (isset($_POST['name'], $_POST['email'], $_POST['password'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // md5 password
    $password = md5($_POST['password']);

    $sql = "INSERT INTO users (name, email, password)
            VALUES ('$name', '$email', '$password')";

    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        echo "<script>alert('Registered successfully'); window.location='login.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed.....'); window.location='register.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FoodieUs</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
</head>

<body>

    <header class="nav">
        <div class="logo" onclick="index_redirect()">
            <h1>Foodie<b>Us</b></h1>
        </div>
    </header>
    <div class="body">
        <div class="form-container">
            <h2>Register</h2>
            <form action="register.php" method="POST" onsubmit="return validateForm()">
                <input type="text" name="name" id="name" placeholder="Full Name" required>
                <input type="email" name="email" id="email" placeholder="Your Email" required>
                <input type="password" name="password" id="password" placeholder="Enter Password" required>
                <!-- <select name="role" required>
                    <option value="customer">Customer</option>
                    <option value="admin">Admin</option>
                </select> -->
                <button type="submit">Register</button>
            </form>
            <div class="link">Already have an account? <a href="login.php">Login here</a></div>
        </div>
    </div>
    <script src="main.js"></script>
</body>

</html>