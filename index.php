<?php include('./config/constants.php') ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/StyleIndex.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <title>FoodieUs</title>
</head>
<body>


    <!-- HEADER -->
<header class="nav">
    <div class="logo"><h1>Foodie<b>Us</b></h1></div>
    <nav>
       <!-- <ul>
           <li> <a href="<?php echo SITEURL; ?>index.php">Home</a> </li>
           <li><a href="<?php echo SITEURL; ?>categories.php">Categories</a> </li>
          <li> <a href="<?php echo SITEURL; ?>foods.php">Menu</a> </li>
           <li><a href="#">Contact</a></li>
        </ul> -->
    </nav>

    <div class="auth-buttons">



        <button class="signin" onclick="signin()">Sign In</button>
        <button class="signup" onclick="signup()">Sign Up</button>
    </div>
</header>

<!-- HERO SECTION -->
<section class="hero">
    <div class="content-left">
        <h2>Order Your Best <br> Food Anytime</h2>
        <p>Hey, our delicious food is waiting for you. We deliver fresh items right to your doorstep.</p>
        <button class="explore-btn" onclick="window.location.href='login.php'">Explore Food</button>
        <a href="menu.php" ></a>
    </div>
    <div class="content-right">
        <img src="image/image1.png" alt="Delicious Food" class="hero-img">
    </div>
</section>



<!-- POPULAR DISHES -->
<h3 id="popular_dish_text">Popular Dishes</h3>
<section class="category">

   <?php 
//create sql query to display categories from database
$sql = "SELECT * FROM category WHERE active='Yes' AND featured='Yes'";
//execute the query
$res = mysqli_query($conn, $sql);
//count rows to check whether the category is available or not
$count = mysqli_num_rows($res);

if($count > 0)
{
    //category available
    while($row = mysqli_fetch_assoc($res))
    {
        //get the values like id, title, image_name
        $id = $row['id'];
        $title = $row['title'];
        $image_name = $row['image_name'];
        ?>

        <a href="login.php">
        <div class="card-list">
            <div class="card">

                <?php
                //check whether image is available or not
                if($image_name == "")
                {
                    echo "<div class='error'>Image not Available.</div>";
                }
                else
                {
                    ?>
                    <img src="<?php echo SITEURL; ?>image/category/<?php echo $image_name; ?>" 
                         alt="<?php echo $title; ?>" 
                         class="img-responsive">
                    <?php
                }
                ?>

                <h4><?php echo $title; ?></h4>
            </div>
        </div>
        </a>

        <?php
    }
}
else
{
    echo "<div class='error'>Category not Added.</div>";
}
?>

    


            

    </div>
</section>

<?php include('partials-front/footer.php'); ?>
