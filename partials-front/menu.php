<?php include('config/constants.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Ordering Website</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
       <!-- HEADER -->
<header class="nav">
    <div class="logo"><h1>Foodie<b>Us</b></h1></div>
    <nav>
        <ul>
            <li> <a href="<?php echo SITEURL; ?>home.php">Home</a> </li>
           <li><a href="<?php echo SITEURL; ?>categories.php">Categories</a> </li>
          <li> <a href="<?php echo SITEURL; ?>foods.php">Menu</a> </li>
           <li><a href="#">Contact</a></li>
        </ul>
    </nav>
    </header>