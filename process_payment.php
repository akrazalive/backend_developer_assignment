<?php
// process_payment.php

// Include the payment gateway library
require_once 'payment_gateway.php';

// Get form data
$amount = $_POST['amount'];
$currency = $_POST['currency'];
$customer_name = $_POST['customer_name'];
$card_holder_name = $_POST['card_holder_name'];
$card_number = $_POST['card_number'];
$expiration_month = $_POST['expiration_month'];
$expiration_year = $_POST['expiration_year'];
$cvv = $_POST['cvv'];

// Create a payment gateway object
$payment_gateway = new PaymentGateway();

// Process the payment
$response = $payment_gateway->processPayment($amount, $currency, $customer_name, $card_holder_name, $card_number, $expiration_month, $expiration_year, $cvv);

// Show success or error message
if ($response['status'] === 'success') {
    echo "Payment successful. Transaction ID: " . $response['transaction_id'];
} else {
    echo "Payment failed. Error message: " . $response['message'];
}
