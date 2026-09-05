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

    const quantityInput = document.querySelector(".quantity");
    const priceInput = document.querySelector(".price");
    const totalSpan = document.querySelector(".total-price");
    const maxQty = 10;

    if (!quantityInput || !priceInput || !totalSpan) {
        return;
    }

    let price = parseFloat(priceInput.value);
    let qty = parseInt(quantityInput.value);
    totalSpan.innerText = (price * qty).toFixed(2);

    quantityInput.addEventListener("input", function () {
        let qty = parseInt(this.value);

        if (isNaN(qty) || qty < 1) {
            qty = 1;
        } else if (qty > maxQty) {
            qty = maxQty;
        }

        this.value = qty;

        let total = price * qty;
        totalSpan.innerText = total.toFixed(2);
    });
});


// -----------------------------register validation--------------------
function validateForm() {

    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value;

    let isValid = true;

    // Clear previous errors
    document.getElementById("nameError").innerHTML = "";
    document.getElementById("emailError").innerHTML = "";
    document.getElementById("passwordError").innerHTML = "";

    // ---------- NAME VALIDATION ----------
    if (name === "") {
        document.getElementById("nameError").innerHTML = "Full Name is required";
        isValid = false;
    }
    else if (name.length < 3) {
        document.getElementById("nameError").innerHTML = "Name must be at least 3 characters";
        isValid = false;
    }
    else {
        let namePattern = /^[A-Za-z ]+$/;
        if (!namePattern.test(name)) {
            document.getElementById("nameError").innerHTML = "Name can contain only letters and spaces";
            isValid = false;
        }

        if (name.includes("  ")) {
            document.getElementById("nameError").innerHTML = "Name should not contain multiple spaces";
            isValid = false;
        }
    }

    // ---------- EMAIL VALIDATION ----------
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email === "") {
        document.getElementById("emailError").innerHTML = "Email is required";
        isValid = false;
    }
    else if (!emailPattern.test(email)) {
        document.getElementById("emailError").innerHTML = "Enter a valid email address";
        isValid = false;
    }

    // ---------- PASSWORD VALIDATION ----------
    if (password === "") {
        document.getElementById("passwordError").innerHTML = "Password is required";
        isValid = false;
    }
    else if (password.length < 6) {
        document.getElementById("passwordError").innerHTML = "Password must be at least 6 characters";
        isValid = false;
    }

    return isValid;
}
//helper function
function showError(input, message) {
    let error = document.createElement("div");
    error.className = "error-message";
    error.style.color = "red";
    error.style.fontSize = "14px";
    error.innerText = message;

    input.parentNode.appendChild(error);
}

function clearErrors(){
    document.querySelectorAll(".error-message").forEach(e => e.remove());
}
//----------------order validation-----------------
function validateOrderForm(){

    clearErrors();
    let isValid = true;

    let quantity = document.querySelector("input[name='quantity']");
    let price = document.querySelector("input[name='price']");
    let name = document.querySelector("input[name='full-name']");
    let contact = document.querySelector("input[name='contact']");
    let email = document.querySelector("input[name='email']");
    let address = document.querySelector("textarea[name='address']");

    if (quantity && price) {
        if (quantity.value === "" || Number(quantity.value) <= 0) {
            showError(quantity, "Please enter a valid quantity (minimum 1).");
            isValid = false;
        }

        if (Number(quantity.value) > 10) {
            showError(quantity, "Maximum quantity is 10 per order.");
            isValid = false;
        }

        if (price.value === "" || Number(price.value) <= 0) {
            showError(quantity, "Invalid price.");
            isValid = false;
        }
    }

    let namePattern=/^[A-Za-z ]{3,}$/;

    if(name.value.trim()===""){
        showError(name,"Full name is required.");
        isValid=false;
    }
    else if(!namePattern.test(name.value.trim())){
        showError(name,"Name must contain only letters (min 3).");
        isValid=false;
    }

    let phonePattern=/^(97|98|96)\d{8}$/;

    if(contact.value.trim()===""){
        showError(contact,"Phone number required.");
        isValid=false;
    }
    else if(!phonePattern.test(contact.value.trim())){
        showError(contact,"Enter valid Nepal phone number.");
        isValid=false;
    }

    let emailPattern=/^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if(email.value.trim()===""){
        showError(email,"Email required.");
        isValid=false;
    }
    else if(!emailPattern.test(email.value.trim())){
        showError(email,"Enter valid email.");
        isValid=false;
    }

    if(address.value.trim()===""){
        showError(address,"Address required.");
        isValid=false;
    }
    else if(address.value.trim().length<10){
        showError(address,"Address must be at least 10 characters.");
        isValid=false;
    }

    return isValid;
}


//------------------Add Admin Validation---------------
function validateAdminForm(){

    clearErrors();
    let isValid=true;

    let fullName=document.querySelector("input[name='full_name']");
    let username=document.querySelector("input[name='username']");
    let password=document.querySelector("input[name='password']");

    if(fullName.value.trim()===""){
        showError(fullName,"Full Name required");
        isValid=false;
    }
    else if(fullName.value.trim().length<3){
        showError(fullName,"Full Name must be at least 3 characters");
        isValid=false;
    }
    else if(!/^[A-Za-z\s]+$/.test(fullName.value.trim())){
        showError(fullName,"Letters and spaces only");
        isValid=false;
    }

    if(username.value.trim()===""){
        showError(username,"Username required");
        isValid=false;
    }
    else if(username.value.trim().length<4){
        showError(username,"Username must be at least 4 characters");
        isValid=false;
    }
    else if(!/^[A-Za-z0-9_]+$/.test(username.value.trim())){
        showError(username,"Letters, numbers, underscore only");
        isValid=false;
    }

    if(password.value===""){
        showError(password,"Password required");
        isValid=false;
    }
    else if(password.value.length<6){
        showError(password,"Password must be at least 6 characters");
        isValid=false;
    }

    return isValid;
}

//---------------add-category validation-------------
function validateCategoryForm(){

    clearErrors();
    let isValid=true;

    let title=document.querySelector("input[name='title']");
    let image=document.querySelector("input[name='image']");
    let featured=document.querySelector("input[name='featured']:checked");
    let active=document.querySelector("input[name='active']:checked");

   if(title.value.trim() === ""){
    showError(title,"Category title required");
    isValid = false;
}
else if(title.value.trim().length < 3){
    showError(title,"Minimum 3 characters required");
    isValid = false;
}
else if(!/^[A-Za-z\s]+$/.test(title.value.trim())){
    showError(title,"Title must contain only alphabets and spaces");
    isValid = false;
}
    if(image.value!==""){
        let allowed=/(\.jpg|\.jpeg|\.png)$/i;
        if(!allowed.exec(image.value)){
            showError(image,"Only JPG JPEG PNG allowed");
            isValid=false;
        }
    }

    if(!featured){
        showError(document.querySelector("input[name='featured']"),"Select featured option");
        isValid=false;
    }

    if(!active){
        showError(document.querySelector("input[name='active']"),"Select active option");
        isValid=false;
    }

    return isValid;
}


//------------add food validation------------
function validateFoodForm(){

clearErrors();
let isValid=true;

let title=document.querySelector("input[name='title']");
let description=document.querySelector("textarea[name='description']");
let price=document.querySelector("input[name='price']");
let category=document.querySelector("select[name='category']");
let image=document.querySelector("input[name='image']");
let featured=document.querySelector("input[name='featured']:checked");
let active=document.querySelector("input[name='active']:checked");

if(title.value.trim() === ""){
    showError(title,"Food title is required");
    isValid = false;
}
else if(title.value.trim().length < 3){
    showError(title,"Food title must be at least 3 characters");
    isValid = false;
}
else if(!/^[A-Za-z\s]+$/.test(title.value.trim())){
    showError(title,"Food title must contain only letters and spaces");
    isValid = false;
}
else if(/\s{2,}/.test(title.value.trim())){
    showError(title,"Food title cannot have multiple consecutive spaces");
    isValid = false;
}

if(description.value.trim() === ""){
    showError(description,"Description is required");
    isValid = false;
}
else if(description.value.trim().length < 10){
    showError(description,"Description must be at least 10 characters");
    isValid = false;
}

if(price.value.trim() === "" || isNaN(price.value) || Number(price.value) <= 0){
    showError(price,"Enter valid price greater than 0");
    isValid = false;
}

if(category.value === "0" || category.value === ""){
    showError(category,"Please select a category");
    isValid = false;
}

if(image.value === ""){
    showError(image,"Food image is required");
    isValid = false;
}
else {
    let allowed = /(\.jpg|\.jpeg|\.png)$/i;
    if(!allowed.exec(image.value)){
        showError(image,"Only JPG, JPEG, or PNG images are allowed");
        isValid = false;
    }
}

if(!featured){
    showError(document.querySelector("input[name='featured']"),"Please select featured option");
    isValid = false;
}

if(!active){
    showError(document.querySelector("input[name='active']"),"Please select active option");
    isValid = false;
}

return isValid;
}

//---------------update-admin validation-----------
function validateUpdateAdmin(){

    clearErrors();
    let isValid = true;

    let fullName = document.querySelector("input[name='full_name']");
    let username = document.querySelector("input[name='username']");

    if(fullName.value.trim() === ""){
        showError(fullName,"Full Name is required.");
        isValid = false;
    }
    else if(fullName.value.trim().length < 3){
        showError(fullName,"Full Name must be at least 3 characters.");
        isValid = false;
    }
    else if(!/^[A-Za-z\s]+$/.test(fullName.value.trim())){
        showError(fullName,"Full Name can contain only letters and spaces.");
        isValid = false;
    }

    if(username.value.trim() === ""){
        showError(username,"Username is required.");
        isValid = false;
    }
    else if(username.value.trim().length < 4){
        showError(username,"Username must be at least 4 characters.");
        isValid = false;
    }
    else if(!/^[a-zA-Z0-9_]+$/.test(username.value.trim())){
        showError(username,"Username can contain only letters, numbers and underscore.");
        isValid = false;
    }

    return isValid;
}

//------------------update-category-------------------
function validateCategoryUpdate(){

    clearErrors();
    let isValid = true;

    let title = document.querySelector("input[name='title']");
    let image = document.querySelector("input[name='image']");
    let featured = document.querySelector("input[name='featured']:checked");
    let active = document.querySelector("input[name='active']:checked");

  if(title.value.trim() === ""){
    showError(title,"Category title is required.");
    isValid = false;
}
else if(title.value.trim().length < 3){
    showError(title,"Title must be at least 3 characters.");
    isValid = false;
}
else if(!/^[A-Za-z0-9\s]+$/.test(title.value.trim())){
    showError(title,"Title must contain only letters, numbers and spaces.");
    isValid = false;
}

    if(image.value !== ""){
        let allowed = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        if(!allowed.exec(image.value)){
            showError(image,"Only JPG, JPEG, PNG or GIF allowed.");
            isValid = false;
        }
    }

    if(!featured){
        showError(document.querySelector("input[name='featured']"),"Please select Featured option.");
        isValid = false;
    }

    if(!active){
        showError(document.querySelector("input[name='active']"),"Please select Active option.");
        isValid = false;
    }

    return isValid;
}


//-----------------update-food validation---------------
function validateUpdateFood(){

    clearErrors();
    let isValid = true;

    let title = document.querySelector("input[name='title']");
    let description = document.querySelector("textarea[name='description']");
    let price = document.querySelector("input[name='price']");
    let image = document.querySelector("input[name='image']");
    let category = document.querySelector("select[name='category']");
    let featured = document.querySelector("input[name='featured']:checked");
    let active = document.querySelector("input[name='active']:checked");

   if(title.value.trim() === ""){
    showError(title,"Food title is required.");
    isValid = false;
}
else if(title.value.trim().length < 3){
    showError(title,"Food title must be at least 3 characters.");
    isValid = false;
}
else if(!/^[A-Za-z\s]+$/.test(title.value.trim())){
    showError(title,"Food title must contain only letters and spaces.");
    isValid = false;
}
else if(/\s{2,}/.test(title.value.trim())){
    showError(title,"Food title cannot have multiple consecutive spaces.");
    isValid = false;
}

if(description.value.trim() === ""){
    showError(description,"Description is required.");
    isValid = false;
}
else if(description.value.trim().length < 10){
    showError(description,"Description must be at least 10 characters.");
    isValid = false;
}

if(price.value.trim() === "" || isNaN(price.value) || Number(price.value) <= 0){
    showError(price,"Enter valid price greater than 0.");
    isValid = false;
}

if(category.value === "0" || category.value === ""){
    showError(category,"Please select a valid category.");
    isValid = false;
}

if(image.value !== ""){
    let allowed = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if(!allowed.exec(image.value)){
        showError(image,"Only JPG, JPEG, PNG or GIF allowed.");
        isValid = false;
    }
}

    if(!featured){
        showError(document.querySelector("input[name='featured']"),"Please select Featured option.");
        isValid = false;
    }

    if(!active){
        showError(document.querySelector("input[name='active']"),"Please select Active option.");
        isValid = false;
    }

    return isValid;
}

//------------------update-order validation------------------
function validateOrderForm(){

    clearErrors();
    let isValid = true;

    let status = document.querySelector("select[name='status']");

    if(status.value === ""){
        showError(status,"Please select order status.");
        isValid = false;
    }

    return isValid;
}

//--------------------update-password validation----------------
function validatePasswordForm(){

clearErrors();
let isValid=true;

let current=document.querySelector("input[name='current_password']");
let newPass=document.querySelector("input[name='new_password']");
let confirm=document.querySelector("input[name='confirm_password']");

if(current.value===""){
showError(current,"Current password required");
isValid=false;
}

if(newPass.value===""){
showError(newPass,"New password required");
isValid=false;
}
else if(newPass.value.length<6){
showError(newPass,"Minimum 6 characters");
isValid=false;
}

if(confirm.value===""){
showError(confirm,"Confirm password required");
isValid=false;
}
else if(newPass.value!==confirm.value){
showError(confirm,"Passwords do not match");
isValid=false;
}

if(current.value===newPass.value){
showError(newPass,"New password must be different");
isValid=false;
}

return isValid;
}

//--------------------admin-login validation-------------------
function validateAdminLogin(){
    clearErrors();
    let isValid = true;

    let username = document.querySelector("input[name='username']");
    let password = document.querySelector("input[name='password']");

    if(username.value.trim() === ""){
        showError(username,"Username is required.");
        isValid = false;
    }
    else if(username.value.trim().length < 4){
        showError(username,"Username must be at least 4 characters.");
        isValid = false;
    }

    if(password.value === ""){
        showError(password,"Password is required.");
        isValid = false;
    }
    else if(password.value.length < 6){
        showError(password,"Password must be at least 6 characters.");
        isValid = false;
    }

    return isValid;
}

//--------------------user-login validation-------------------
function validateUserLogin(){
    clearErrors();
    let isValid = true;

    let email = document.querySelector("input[name='email']");
    let password = document.querySelector("input[name='password']");

    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if(email.value.trim() === ""){
        showError(email,"Email is required.");
        isValid = false;
    }
    else if(!emailPattern.test(email.value.trim())){
        showError(email,"Enter a valid email address.");
        isValid = false;
    }

    if(password.value === ""){
        showError(password,"Password is required.");
        isValid = false;
    }
    else if(password.value.length < 6){
        showError(password,"Password must be at least 6 characters.");
        isValid = false;
    }

    return isValid;
}

//--------------------contact form validation-------------------
function validateContactForm(){
    clearErrors();
    let isValid = true;

    let name = document.querySelector("input[name='name']");
    let email = document.querySelector("input[name='email']");
    let phone = document.querySelector("input[name='phone']");
    let message = document.querySelector("textarea[name='message']");

    let namePattern = /^[A-Za-z ]{3,}$/;
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let phonePattern = /^(97|98|96)\d{8}$|^\d{10}$/;

    if(name.value.trim() === ""){
        showError(name,"Full name is required.");
        isValid = false;
    }
    else if(!namePattern.test(name.value.trim())){
        showError(name,"Name must contain only letters and spaces (min 3 characters).");
        isValid = false;
    }

    if(email.value.trim() === ""){
        showError(email,"Email is required.");
        isValid = false;
    }
    else if(!emailPattern.test(email.value.trim())){
        showError(email,"Enter a valid email address.");
        isValid = false;
    }

    if(phone.value.trim() !== ""){
        if(!phonePattern.test(phone.value.trim())){
            showError(phone,"Enter a valid phone number (10 digits or Nepal format).");
            isValid = false;
        }
    }

    if(message.value.trim() === ""){
        showError(message,"Message is required.");
        isValid = false;
    }
    else if(message.value.trim().length < 10){
        showError(message,"Message must be at least 10 characters.");
        isValid = false;
    }

    return isValid;
}
