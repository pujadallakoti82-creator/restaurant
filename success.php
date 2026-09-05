<?php

// Load database connection
include('config/constants.php');

// --------------------------------------------------
// CHECK ESEWA RESPONSE
// --------------------------------------------------

if (!isset($_GET['data'])) {
    die("Payment response not received from eSewa.");
}


// --------------------------------------------------
// DECODE ESEWA RESPONSE
// --------------------------------------------------

$decoded_data = base64_decode($_GET['data']);

if ($decoded_data === false) {
    die("Invalid payment response.");
}


// Convert JSON into PHP array
$response = json_decode($decoded_data, true);

if (!is_array($response)) {
    die("Unable to read eSewa payment response.");
}


// --------------------------------------------------
// GET RESPONSE VALUES
// --------------------------------------------------

$status = $response['status'] ?? '';
$transaction_uuid = $response['transaction_uuid'] ?? '';
$total_amount = $response['total_amount'] ?? '';
$product_code = $response['product_code'] ?? '';
$transaction_code = $response['transaction_code'] ?? '';
$received_signature = $response['signature'] ?? '';
$signed_field_names = $response['signed_field_names'] ?? '';


// Check required values
if (
    empty($status) ||
    empty($transaction_uuid) ||
    empty($total_amount) ||
    empty($product_code) ||
    empty($received_signature) ||
    empty($signed_field_names)
) {
    die("Incomplete payment response.");
}


// --------------------------------------------------
// VERIFY SIGNATURE
// --------------------------------------------------

$secret_key = "8gBm/:&EnhH.1/q";


// eSewa tells us which fields were signed
$fields = explode(',', $signed_field_names);

$message_parts = [];

foreach ($fields as $field) {

    if (!isset($response[$field])) {
        die("Invalid signed fields.");
    }

    $message_parts[] = $field . "=" . $response[$field];
}

$message = implode(',', $message_parts);


// Generate our own signature
$generated_signature = base64_encode(
    hash_hmac(
        'sha256',
        $message,
        $secret_key,
        true
    )
);


// Compare signatures
if (!hash_equals($received_signature, $generated_signature)) {
    die("Payment verification failed: Invalid signature.");
}


// --------------------------------------------------
// CHECK PAYMENT STATUS
// --------------------------------------------------

if ($status !== 'COMPLETE') {
    die("Payment was not completed. Status: " . htmlspecialchars($status));
}


// --------------------------------------------------
// FIND ORDER USING TRANSACTION ID
// --------------------------------------------------

// IMPORTANT:
// eSewa transaction_uuid is stored in tbl_order.transaction_id

$transaction_uuid_safe = mysqli_real_escape_string(
    $conn,
    $transaction_uuid
);

$sql = "SELECT * FROM tbl_order
        WHERE transaction_id = '$transaction_uuid_safe'
        LIMIT 1";

$res = mysqli_query($conn, $sql);


if (!$res) {
    die("Database error: " . mysqli_error($conn));
}


if (mysqli_num_rows($res) != 1) {
    die(
        "Order not found.<br><br>" .
        "Transaction ID received from eSewa: " .
        htmlspecialchars($transaction_uuid)
    );
}


$order = mysqli_fetch_assoc($res);


// --------------------------------------------------
// CHECK PAYMENT AMOUNT
// --------------------------------------------------

$order_total = (float)$order['total'];
$paid_total = (float)$total_amount;


if (abs($order_total - $paid_total) > 0.01) {

    die(
        "Payment amount does not match the order amount.<br><br>" .
        "Order Amount: Rs. " . htmlspecialchars($order_total) . "<br>" .
        "Paid Amount: Rs. " . htmlspecialchars($paid_total)
    );

}


// --------------------------------------------------
// UPDATE ORDER STATUS
// --------------------------------------------------

$order_id = $order['id'];

$update_sql = "UPDATE tbl_order
               SET payment_status = 'Paid'
               WHERE id = '$order_id'";

$update_result = mysqli_query($conn, $update_sql);


if (!$update_result) {
    die("Payment was successful, but order status could not be updated.");
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Payment Successful</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .success-container {
            width: 450px;
            max-width: 90%;
            margin: 80px auto;
            background: white;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
            text-align: center;
        }

        h1 {
            color: #28a745;
            margin-bottom: 25px;
        }

        p {
            font-size: 17px;
            margin: 12px 0;
        }

        .btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 25px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #218838;
        }

    </style>

</head>

<body>

<div class="success-container">

    <h1>Payment Successful!</h1>

    <p>
        Your payment has been successfully completed.
    </p>

    <p>
        <strong>Order ID:</strong>
        <?php echo htmlspecialchars($order_id); ?>
    </p>

    <p>
        <strong>Transaction ID:</strong>
        <?php echo htmlspecialchars($transaction_uuid); ?>
    </p>

    <p>
        <strong>eSewa Transaction Code:</strong>
        <?php echo htmlspecialchars($transaction_code); ?>
    </p>

    <p>
        <strong>Amount Paid:</strong>
        Rs. <?php echo htmlspecialchars($total_amount); ?>
    </p>

    <a href="foods.php" class="btn">
        Order More
    </a>

</div>

</body>

</html>