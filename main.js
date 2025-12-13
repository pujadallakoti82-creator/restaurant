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
const priceInput = document.getElementById('price');
const quantityInput = document.getElementById('quantity');
const totalPriceSpan = document.getElementById('total-price');

// Function to calculate total
function calculateTotal() {
    const price = parseFloat(priceInput.value);
    const quantity = parseInt(quantityInput.value);
    const total = price * quantity;
    totalPriceSpan.textContent = total.toFixed(2); // display 2 decimals
}

// Call function when quantity changes
quantityInput.addEventListener('input', calculateTotal);

// Initialize total on page load
calculateTotal();
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
    let quantity = document.getElementById("quantity").value;
    let name = document.querySelector("input[name='full-name']").value.trim();
    let phone = document.querySelector("input[name='contact']").value.trim();
    let email = document.querySelector("input[name='email']").value.trim();
    let address = document.querySelector("textarea[name='address']").value.trim();

    // ---------- QUANTITY ----------
    if (quantity <= 0) {
        alert("Quantity must be at least 1");
        return false;
    }

    // ---------- NAME ----------
    let namePattern = /^[A-Za-z ]+$/;
    if (name === "") {
        alert("Full Name is required");
        return false;
    }
    if (name.length < 3) {
        alert("Name must be at least 3 characters");
        return false;
    }
    if (!namePattern.test(name)) {
        alert("Name can contain only letters and spaces");
        return false;
    }
    if (name.includes("  ")) {
        alert("Name should not contain multiple spaces");
        return false;
    }

    // ---------- PHONE ----------
    let phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(phone)) {
        alert("Enter a valid 10-digit phone number");
        return false;
    }

    // ---------- EMAIL ----------
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("Enter a valid email address");
        return false;
    }

    // ---------- ADDRESS ----------
    if (address.length < 6) {
        alert("Address must be at least 6 characters");
        return false;
    }

    return true; // submit form
}

