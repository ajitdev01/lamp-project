
<?php
require("./admin/assets/lib/razorpay-php/Razorpay.php"); // Ensure you have the Razorpay PHP SDK

use Razorpay\Api\Api;

$api_key = 'Enter Your Api Key';
$api_secret = 'Enter Your Secret Key';
$api = new Api($api_key, $api_secret);

// $amount = $_POST['amount'] * 100; // Amount in paise

// $orderData = [
//     'receipt'         => 'order_rcptid_11',
//     'amount'          => $amount, // 2000 rupees in paise
//     'currency'        => 'INR',
//     'payment_capture' => 1 // auto capture
// ];

// $razorpayOrder = $api->order->create($orderData);

// echo json_encode($razorpayOrder);

if (isset($_POST['amount'])) {
    $amount = intval($_POST['amount']); // Ensure amount is an integer in paise

    $orderData = [
        'receipt'         => 'order_rcptid_11',
        'amount'          => $amount, // Amount in paise
        'currency'        => 'INR',
        'payment_capture' => 1 // auto capture
    ];

    try {
        $order = $api->order->create($orderData);
        echo json_encode([
            'id'     => $order->id,
            'amount' => $order->amount // This should be in paise
        ]);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>

