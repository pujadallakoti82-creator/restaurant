<?php

// Get order ID, transaction ID, and amount
$order_id = $_GET['order_id'] ?? '';
$transaction_id = $_GET['transaction_id'] ?? '';
$amount = $_GET['amount'] ?? '';


// Check required values
if (empty($order_id) || empty($transaction_id) || empty($amount)) {
    die("Invalid payment information.");
}


// --------------------------------------------------
// ESEWA TEST / UAT DETAILS
// --------------------------------------------------

$product_code = "EPAYTEST";
$secret_key = "8gBm/:&EnhH.1/q";


// Format amount
$amount = number_format((float)$amount, 2, '.', '');


// No extra charges for our project
$tax_amount = "0.00";
$product_service_charge = "0.00";
$product_delivery_charge = "0.00";


// Calculate total amount
$total_amount = number_format(
    (float)$amount +
    (float)$tax_amount +
    (float)$product_service_charge +
    (float)$product_delivery_charge,
    2,
    '.',
    ''
);


// --------------------------------------------------
// CREATE ESEWA SIGNATURE
// --------------------------------------------------

// eSewa requires this exact message format
$message = "total_amount=$total_amount,transaction_uuid=$transaction_id,product_code=$product_code";


// Generate HMAC SHA256
$hash = hash_hmac(
    'sha256',
    $message,
    $secret_key,
    true
);


// Convert signature to Base64
$signature = base64_encode($hash);


// --------------------------------------------------
// SUCCESS AND FAILURE URL
// --------------------------------------------------

$success_url = "http://localhost/project/restaurant/success.php";
$failure_url = "http://localhost/project/restaurant/failure.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>eSewa Payment</title>


    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }


        .payment-container {

            width: 450px;

            max-width: 90%;

            margin: 80px auto;

            background: white;

            padding: 30px;

            border-radius: 12px;

            box-shadow: 0 0 10px rgba(0,0,0,0.15);

            text-align: center;

        }


        h2 {

            margin-bottom: 25px;

            color: #333;

        }


        .details {

            text-align: left;

            margin-bottom: 25px;

        }


        .details p {

            font-size: 17px;

            margin: 12px 0;

        }


        .pay-btn {

            width: 100%;

            padding: 14px;

            background-color: #28a745;

            color: white;

            border: none;

            border-radius: 6px;

            font-size: 17px;

            cursor: pointer;

        }


        .pay-btn:hover {

            background-color: #218838;

        }


        .cancel {

            display: block;

            margin-top: 15px;

            text-decoration: none;

            color: #555;

        }

    </style>

</head>


<body>


<div class="payment-container">


    <h2>Online Payment</h2>


    <div class="details">


        <p>

            <strong>Order ID:</strong>

            <?php

            echo htmlspecialchars($order_id);

            ?>

        </p>


        <p>

            <strong>Amount:</strong>

            Rs.

            <?php

            echo htmlspecialchars($total_amount);

            ?>

        </p>


    </div>


    <!--
        eSewa Payment Form
    -->

    <form

        action="https://rc-epay.esewa.com.np/api/epay/main/v2/form"

        method="POST"

    >


        <!-- Amount -->

        <input

            type="hidden"

            name="amount"

            value="<?php echo htmlspecialchars($amount); ?>"

        >


        <!-- Tax Amount -->

        <input

            type="hidden"

            name="tax_amount"

            value="<?php echo htmlspecialchars($tax_amount); ?>"

        >


        <!-- Total Amount -->

        <input

            type="hidden"

            name="total_amount"

            value="<?php echo htmlspecialchars($total_amount); ?>"

        >


        <!-- UNIQUE TRANSACTION UUID -->

        <input

            type="hidden"

            name="transaction_uuid"

            value="<?php echo htmlspecialchars($transaction_id); ?>"

        >


        <!-- Product Code -->

        <input

            type="hidden"

            name="product_code"

            value="<?php echo htmlspecialchars($product_code); ?>"

        >


        <!-- Service Charge -->

        <input

            type="hidden"

            name="product_service_charge"

            value="<?php echo htmlspecialchars($product_service_charge); ?>"

        >


        <!-- Delivery Charge -->

        <input

            type="hidden"

            name="product_delivery_charge"

            value="<?php echo htmlspecialchars($product_delivery_charge); ?>"

        >


        <!-- Success URL -->

        <input

            type="hidden"

            name="success_url"

            value="<?php echo htmlspecialchars($success_url); ?>"

        >


        <!-- Failure URL -->

        <input

            type="hidden"

            name="failure_url"

            value="<?php echo htmlspecialchars($failure_url); ?>"

        >


        <!-- Signed Fields -->

        <input

            type="hidden"

            name="signed_field_names"

            value="total_amount,transaction_uuid,product_code"

        >


        <!-- Signature -->

        <input

            type="hidden"

            name="signature"

            value="<?php echo htmlspecialchars($signature); ?>"

        >


        <!-- Pay Button -->

        <button

            type="submit"

            class="pay-btn"

        >

            Pay Now with eSewa

        </button>


    </form>


    <a href="foods.php" class="cancel">

        Cancel Payment

    </a>


</div>


</body>

</html>