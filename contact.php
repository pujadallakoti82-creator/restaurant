<?php
include('partials-front/menu.php');


// Check login
if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
}





if(isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if($name != "" && $email != "" && $message != "") {
        $sql = "INSERT INTO tbl_contact SET
                name='$name',
                email='$email',
                phone='$phone',
                message='$message',
                created_at=NOW()";
        $res = mysqli_query($conn, $sql);

        if($res) {
            // Store a session message
            $_SESSION['contact_success'] = "Message sent successfully. We will contact you soon.";
        } else {
            $_SESSION['contact_error'] = "Failed to send message. Try again later.";
        }

        // Redirect to avoid resubmission
        header("Location: contact.php");
        exit();
    } else {
        $_SESSION['contact_error'] = "Please fill all required fields.";
        header("Location: contact.php");
        exit();
    }
}
?>

<!-- Contact Section Starts Here -->
<section class="contact">
    <div class="container">
        <h2 class="text-center">Contact Us</h2>

        <?php
        // Show success or error message
        if(isset($_SESSION['contact_success'])) {
            echo "<div class='success'>".$_SESSION['contact_success']."</div>";
            unset($_SESSION['contact_success']);
        }

        if(isset($_SESSION['contact_error'])) {
            echo "<div class='error'>".$_SESSION['contact_error']."</div>";
            unset($_SESSION['contact_error']);
        }
        ?>

        <div class="contact-content">
            <!-- Contact Form -->
            <div class="contact-form">
                <form action="" method="POST" onsubmit="return validateContactForm();">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <input type="text" name="phone" placeholder="Phone Number (Optional)">
                    <textarea name="message" placeholder="Your Message" rows="8" required></textarea>
                    <input type="submit" name="submit" value="Send Message" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section Ends Here -->



        <div class="contact-content">
            <!-- Contact Info -->
            <div class="contact-info">
                <h3>Our Info</h3>
                <p><strong>Phone:</strong> +977 9843000000</p>
                <p><strong>Email:</strong> info@foodieus.com</p>
                <p><strong>Address:</strong> Chitwan, Nepal</p>
            </div>
    </div>



<script>
function validateContactForm() {

    let name = document.querySelector("input[name='name']").value.trim();
    let email = document.querySelector("input[name='email']").value.trim();
    let phone = document.querySelector("input[name='phone']").value.trim();
    let message = document.querySelector("textarea[name='message']").value.trim();

    // Name validation
    if (name.length < 3) {
        alert("Name must be at least 3 characters long");
        return false;
    }

    // Email validation
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address");
        return false;
    }

    // Phone validation (optional)
    if (phone !== "") {
        let phonePattern = /^(97|98|96)\d{8}$/;
        if (!phonePattern.test(phone)) {
            alert("Enter a valid phone number");
            return false;
        }
    }

    // Message validation
    if (message.length < 10) {
        alert("Message must be at least 10 characters long");
        return false;
    }

    return true; // allow form submit
}
</script>



<?php include('partials-front/footer.php'); ?> 
