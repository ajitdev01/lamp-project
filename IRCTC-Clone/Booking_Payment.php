<?php
require './admin/assets/lib/razorpay-php/Razorpay.php';

use Razorpay\Api\Api;

include "./config/config.php";  // correct DB include

$api_key = 'Enter Your Api key';
$api_secret =  'Enter Your Secret key';
$api = new Api($api_key, $api_secret);

// Fetch the payment details
$payment = $api->payment->fetch($_POST['razorpay_payment_id']);
if ($payment->status == 'captured') {

    session_start();
    $user_id = $_SESSION['user_id'];

    // Collect POST values
    $train_id  = mysqli_real_escape_string($conn, $_POST['train_id']);
    $train_no  = mysqli_real_escape_string($conn, $_POST['train_no']);
    $route_id  = mysqli_real_escape_string($conn, $_POST['route_id']);
    $doj       = mysqli_real_escape_string($conn, $_POST['doj']);
    $totalamt  = mysqli_real_escape_string($conn, $_POST['totalamt']);
    $taxfee    = mysqli_real_escape_string($conn, $_POST['taxefee']);
    $amount    = mysqli_real_escape_string($conn, $_POST['amount']);

    // Payment ID
    $payment_id = mysqli_real_escape_string($conn, $_POST['razorpay_payment_id']);

    // Passengers JSON
    $passengers_json = $_POST['passengers'];
    $passengers_safe_json = mysqli_real_escape_string($conn, $passengers_json);

    // Generate PNR
    $pnr_no = rand(10000000000, 99999999999);

    // Insert Booking
    $bQry = "
        INSERT INTO bookings_tbl 
        (user_id, pnr_no, train_id, train_no, route_id, booking_status, doj, base_fare, tax_fee, total_amt, payment_id, payment_ref, passengers_info, created_at)
        VALUES 
        ('$user_id', '$pnr_no', '$train_id', '$train_no', '$route_id', 'Pending', '$doj', '$totalamt', '$taxfee', '$amount', '$payment_id', 'OnlinePayment', '$passengers_safe_json', NOW())
    ";

    if (mysqli_query($conn, $bQry)) {
        header('Location: thank_you_user.php');
        exit();
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
} else {
    echo "Payment Failed";
}

