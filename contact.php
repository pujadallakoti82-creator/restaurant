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

<div class="form-group">
<input type="text" name="name" placeholder="Your Name">
</div>

<div class="form-group">
<input type="email" name="email" placeholder="Your Email">
</div>

<div class="form-group">
<input type="text" name="phone" placeholder="Phone Number (Optional)">
</div>

<div class="form-group">
<textarea name="message" placeholder="Your Message" rows="8"></textarea>
</div>

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
 function showError(input, message) {

    let error = document.createElement("div");
    error.className = "error-message";
    error.style.color = "red";
    error.style.fontSize = "14px";
    error.style.marginTop = "4px";

    error.innerText = message;

    input.insertAdjacentElement("afterend", error);
}

function clearErrors(){
    document.querySelectorAll(".error-message").forEach(e => e.remove());
}
function validateContactForm() {

    clearErrors();
    let isValid = true;

    let name = document.querySelector("input[name='name']");
    let email = document.querySelector("input[name='email']");
    let phone = document.querySelector("input[name='phone']");
    let message = document.querySelector("textarea[name='message']");

    // Name validation
    if (name.value.trim() === "") {
        showError(name,"Name is required");
        isValid = false;
    }
    else if (name.value.trim().length < 3) {
        showError(name,"Name must be at least 3 characters long");
        isValid = false;
    }
    else if(!/^[A-Za-z\s]+$/.test(name.value.trim())){
        showError(name,"Name can contain only letters and spaces");
        isValid = false;
    }

    // Email validation
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if(email.value.trim() === ""){
        showError(email,"Email is required");
        isValid = false;
    }
    else if(!emailPattern.test(email.value.trim())){
        showError(email,"Please enter a valid email address");
        isValid = false;
    }

    // Phone validation (optional)
    if (phone.value.trim() !== "") {
        let phonePattern = /^(97|98|96)\d{8}$/;

        if (!phonePattern.test(phone.value.trim())) {
            showError(phone,"Enter a valid phone number");
            isValid = false;
        }
    }

    // Message validation
    if (message.value.trim() === "") {
        showError(message,"Message is required");
        isValid = false;
    }
    else if (message.value.trim().length < 10) {
        showError(message,"Message must be at least 10 characters long");
        isValid = false;
    }

    return isValid;
}
</script>



<?php include('partials-front/footer.php'); ?> 
