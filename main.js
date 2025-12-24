function signin() {
    window.location.href = "login.php";
}

function signup() {
    window.location.href = "register.php";
}
function index_redirect(){
    window.location.href = "index.php";

}



// ---------------------calculation of menu price--------------------
// --------------------- REAL-TIME PRICE CALCULATION ---------------------

document.addEventListener("DOMContentLoaded", function () {

    // Get quantity input
    const quantityInput = document.querySelector(".quantity");

    // Get price and total elements
    const priceInput = document.querySelector(".price");
    const totalSpan = document.querySelector(".total-price");

    // Initial total when page loads
    let price = parseFloat(priceInput.value);
    let qty = parseInt(quantityInput.value);
    totalSpan.innerText = (price * qty).toFixed(2);

    // Update total when quantity changes
    quantityInput.addEventListener("input", function () {

        let qty = parseInt(this.value);

        // Prevent zero or negative values
        if (qty < 1 || isNaN(qty)) {
            qty = 1;
            this.value = 1;
        }

        let total = price * qty;
        totalSpan.innerText = total.toFixed(2);
    });
});


// -----------------------------register validation--------------------
function validateForm() {
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value;

    // ---------- NAME VALIDATION ----------
    if (name === "") {
        alert("Full Name is required");
        return false;
    }

    if (name.length < 3) {
        alert("Name must be at least 3 characters");
        return false;
    }

    // Allow only letters and spaces
    let namePattern = /^[A-Za-z ]+$/;
    if (!namePattern.test(name)) {
        alert("Name can contain only letters and spaces");
        return false;
    }

    // Prevent multiple spaces
    if (name.includes("  ")) {
        alert("Name should not contain multiple spaces");
        return false;
    }

    // ---------- EMAIL VALIDATION ----------
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email === "") {
        alert("Email is required");
        return false;
    }

    if (!emailPattern.test(email)) {
        alert("Enter a valid email address");
        return false;
    }

    // ---------- PASSWORD VALIDATION ----------
    if (password === "") {
        alert("Password is required");
        return false;
    }

    if (password.length < 6) {
        alert("Password must be at least 6 characters");
        return false;
    }

    return true; // allow form submit
}
// ----------------order validation-----------------
function validateOrderForm() {
    // Get form values
    let quantity = document.getElementById("quantity").value;
    let price = document.getElementById("price").value;
    let name = document.querySelector("input[name='full-name']").value.trim();
    let contact = document.querySelector("input[name='contact']").value.trim();
    let email = document.querySelector("input[name='email']").value.trim();
    let address = document.querySelector("textarea[name='address']").value.trim();

    // Quantity validation
    if (quantity === "" || quantity <= 0) {
        alert("Please enter a valid quantity (minimum 1).");
        return false;
    }

    // Price validation
    if (price === "" || price <= 0) {
        alert("Invalid price for the selected food.");
        return false;
    }

    // Total price validation
    let total = price * quantity;
    if (total <= 0) {
        alert("Total price is invalid.");
        return false;
    }

    // Full name validation (letters only, at least 3 characters)
    let namePattern = /^[A-Za-z ]{3,}$/;
    if (name === "") {
        alert("Full name is required.");
        return false;
    }
    if (!namePattern.test(name)) {
        alert("Full name should contain only letters and be at least 3 characters long.");
        return false;
    }

    // Phone number validation (Nepal format)
    let phonePattern = /^(97|98|96)\d{8}$/;
    if (contact === "") {
        alert("Phone number is required.");
        return false;
    }
    if (!phonePattern.test(contact)) {
        alert("Enter a valid Nepal phone number (e.g., 98XXXXXXXX).");
        return false;
    }

    // Email validation
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email === "") {
        alert("Email is required.");
        return false;
    }
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    // Address validation
    if (address === "") {
        alert("Delivery address is required.");
        return false;
    }
    if (address.length < 10) {
        alert("Address must be at least 10 characters long.");
        return false;
    }

    return true; // allow form submit
}


//------------------Add Admin Validation---------------
function validateAdminForm() {
    let fullName = document.querySelector("input[name='full_name']").value.trim();
    let username = document.querySelector("input[name='username']").value.trim();
    let password = document.querySelector("input[name='password']").value;

    // Full Name validation
    if (fullName === "") {
        alert("Full Name is required");
        return false;
    }
    if (fullName.length < 3) {
        alert("Full Name must be at least 3 characters");
        return false;
    }
    if (!/^[A-Za-z\s]+$/.test(fullName)) {
        alert("Full Name should contain only letters and spaces");
        return false;
    }

    // Username validation
    if (username === "") {
        alert("Username is required");
        return false;
    }
    if (username.length < 4) {
        alert("Username must be at least 4 characters");
        return false;
    }
    if (!/^[A-Za-z0-9_]+$/.test(username)) {
        alert("Username can contain only letters, numbers, and underscore");
        return false;
    }

    // Password validation
    if (password === "") {
        alert("Password is required");
        return false;
    }
    if (password.length < 6) {
        alert("Password must be at least 6 characters");
        return false;
    }

    return true; // allow form submission
}

//---------------add-category validation-------------
function validateCategoryForm() {
    let title = document.querySelector("input[name='title']").value.trim();
    let image = document.querySelector("input[name='image']").value;
    let featured = document.querySelector("input[name='featured']:checked");
    let active = document.querySelector("input[name='active']:checked");

    // Title validation
    if (title === "") {
        alert("Category title is required");
        return false;
    }
    if (title.length < 3) {
        alert("Category title must be at least 3 characters");
        return false;
    }
    if (!/^[A-Za-z\s]+$/.test(title)) {
        alert("Category title should contain only letters and spaces");
        return false;
    }

    // Image validation (optional but if selected)
    if (image !== "") {
        let allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
        if (!allowedExtensions.exec(image)) {
            alert("Please upload JPG, JPEG, or PNG image only");
            return false;
        }
    }

    // Featured validation
    if (featured === null) {
        alert("Please select Featured option");
        return false;
    }

    // Active validation
    if (active === null) {
        alert("Please select Active option");
        return false;
    }

    return true; // allow submit
}


//------------add food validation------------
function validateFoodForm()
{
    let title = document.querySelector("input[name='title']").value.trim();
    let description = document.querySelector("textarea[name='description']").value.trim();
    let price = document.querySelector("input[name='price']").value;
    let category = document.querySelector("select[name='category']").value;
    let image = document.querySelector("input[name='image']").value;

    // Title validation
    if(title === "")
    {
        alert("Food title is required.");
        return false;
    }

    if(title.length < 3)
    {
        alert("Food title must be at least 3 characters.");
        return false;
    }

    // Description validation
    if(description === "")
    {
        alert("Food description is required.");
        return false;
    }

    // Price validation
    if(price === "")
    {
        alert("Price is required.");
        return false;
    }

    if(isNaN(price) || price <= 0)
    {
        alert("Please enter a valid price.");
        return false;
    }

    // Category validation
    if(category == 0)
    {
        alert("Please select a category.");
        return false;
    }

    // Image validation (optional)
    if(image !== "")
    {
        let allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

        if(!allowedExtensions.exec(image))
        {
            alert("Only JPG, JPEG, and PNG images are allowed.");
            return false;
        }
    }

    // Featured validation
    let featured = document.querySelector("input[name='featured']:checked");
    if(!featured)
    {
        alert("Please select Featured (Yes or No).");
        return false;
    }

    // Active validation
    let active = document.querySelector("input[name='active']:checked");
    if(!active)
    {
        alert("Please select Active (Yes or No).");
        return false;
    }

    return true; // form will submit
}

//---------------update-admin validation-----------
function validateUpdateAdmin()
{
    let fullName = document.querySelector("input[name='full_name']").value.trim();
    let username = document.querySelector("input[name='username']").value.trim();

    // Full Name validation
    if(fullName === "")
    {
        alert("Full Name is required.");
        return false;
    }

    if(fullName.length < 3)
    {
        alert("Full Name must be at least 3 characters long.");
        return false;
    }

    // Allow only letters and spaces
    let namePattern = /^[A-Za-z\s]+$/;
    if(!namePattern.test(fullName))
    {
        alert("Full Name can contain only letters and spaces.");
        return false;
    }

    // Username validation
    if(username === "")
    {
        alert("Username is required.");
        return false;
    }

    if(username.length < 4)
    {
        alert("Username must be at least 4 characters long.");
        return false;
    }

    // Username format
    let usernamePattern = /^[a-zA-Z0-9_]+$/;
    if(!usernamePattern.test(username))
    {
        alert("Username can contain only letters, numbers, and underscore.");
        return false;
    }

    return true; // form will submit
}

//------------------update-category-------------------
function validateCategoryUpdate()
{
    let title = document.querySelector("input[name='title']").value.trim();
    let image = document.querySelector("input[name='image']").value;
    let featured = document.querySelector("input[name='featured']:checked");
    let active = document.querySelector("input[name='active']:checked");

    // Title validation
    if(title === "")
    {
        alert("Category title is required.");
        return false;
    }

    if(title.length < 3)
    {
        alert("Category title must be at least 3 characters long.");
        return false;
    }

    // Allow letters, numbers & spaces only
    let titlePattern = /^[A-Za-z0-9\s]+$/;
    if(!titlePattern.test(title))
    {
        alert("Title can contain only letters, numbers, and spaces.");
        return false;
    }

    // Image validation (if user selects new image)
    if(image !== "")
    {
        let allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        if(!allowedExtensions.exec(image))
        {
            alert("Only JPG, JPEG, PNG, or GIF images are allowed.");
            return false;
        }
    }

    // Featured validation
    if(featured === null)
    {
        alert("Please select Featured option.");
        return false;
    }

    // Active validation
    if(active === null)
    {
        alert("Please select Active option.");
        return false;
    }

    return true; // submit form
}


//-----------------update-food validation---------------
function validateUpdateFood()
{
    let title = document.querySelector("input[name='title']").value.trim();
    let description = document.querySelector("textarea[name='description']").value.trim();
    let price = document.querySelector("input[name='price']").value;
    let image = document.querySelector("input[name='image']").value;
    let category = document.querySelector("select[name='category']").value;
    let featured = document.querySelector("input[name='featured']:checked");
    let active = document.querySelector("input[name='active']:checked");

    // Title validation
    if(title === "")
    {
        alert("Food title is required.");
        return false;
    }

    if(title.length < 3)
    {
        alert("Food title must be at least 3 characters.");
        return false;
    }

    let titlePattern = /^[A-Za-z0-9\s]+$/;
    if(!titlePattern.test(title))
    {
        alert("Title can contain only letters, numbers, and spaces.");
        return false;
    }

    // Description validation
    if(description === "")
    {
        alert("Food description is required.");
        return false;
    }

    if(description.length < 10)
    {
        alert("Description must be at least 10 characters long.");
        return false;
    }

    // Price validation
    if(price === "")
    {
        alert("Price is required.");
        return false;
    }

    if(isNaN(price) || price <= 0)
    {
        alert("Please enter a valid price greater than 0.");
        return false;
    }

    // Category validation
    if(category === "0" || category === "")
    {
        alert("Please select a valid category.");
        return false;
    }

    // Image validation (only if new image selected)
    if(image !== "")
    {
        let allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        if(!allowedExtensions.exec(image))
        {
            alert("Only JPG, JPEG, PNG, or GIF images are allowed.");
            return false;
        }
    }

    // Featured validation
    if(featured === null)
    {
        alert("Please select Featured option.");
        return false;
    }

    // Active validation
    if(active === null)
    {
        alert("Please select Active option.");
        return false;
    }

    return true; // allow submit
}

//------------------update-order validation------------------
function validateOrderForm()
{
    let status = document.querySelector("select[name='status']").value;

    // Status validation
    if(status === "")
    {
        alert("Please select order status.");
        return false;
    }


    return true; // allow form submit
}

//--------------------update-password validation----------------
function validatePasswordForm()
{
    let currentPassword = document.querySelector("input[name='current_password']").value;
    let newPassword = document.querySelector("input[name='new_password']").value;
    let confirmPassword = document.querySelector("input[name='confirm_password']").value;

    // Current password validation
    if(currentPassword === "")
    {
        alert("Current password is required.");
        return false;
    }

    // New password validation
    if(newPassword === "")
    {
        alert("New password is required.");
        return false;
    }

    if(newPassword.length < 6)
    {
        alert("New password must be at least 6 characters long.");
        return false;
    }

    // Strong password check (optional but recommended)
    let passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,}$/;
    if(!passwordPattern.test(newPassword))
    {
        alert("Password must contain at least one letter and one number.");
        return false;
    }

    // Confirm password validation
    if(confirmPassword === "")
    {
        alert("Please confirm your new password.");
        return false;
    }

    if(newPassword !== confirmPassword)
    {
        alert("New password and confirm password do not match.");
        return false;
    }

    // Prevent using old password again
    if(currentPassword === newPassword)
    {
        alert("New password must be different from current password.");
        return false;
    }

    return true; // allow form submission
}


