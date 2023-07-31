<?php

require_once 'paypal_config.php'; // Include the PayPal configuration
require_once 'braintree_config.php'; // Include the Braintree configuration


class PaymentGateway
{
    public function processPayment($amount, $currency, $customer_name, $card_holder_name, $card_number, $expiration_month, $expiration_year, $cvv)
    {
        // Determine the payment gateway based on rules
        $payment_gateway = $this->choosePaymentGateway($currency, $card_number);

        if (!$payment_gateway) {
            return ['status' => 'error', 'message' => 'Payment gateway not supported for this currency or card type.'];
        }

        // Make the payment using the selected gateway
        $response = $payment_gateway->makePayment($amount, $currency, $customer_name, $card_holder_name, $card_number, $expiration_month, $expiration_year, $cvv);

        // Save order data and payment response to the database (You need to implement this)
        $this->saveToDatabase($amount, $currency, $customer_name, $response);

        return ['status' => 'success', 'transaction_id' => $response['transaction_id']];
    }

    private function choosePaymentGateway($currency, $card_number)
    {
        // Determine the payment gateway based on rules
        if ($card_number[0] === '3') {
            return new PaypalPaymentGateway(); // AMEX card, use Paypal
        }

        if (in_array($currency, ['USD', 'EUR', 'AUD'])) {
            return new PaypalPaymentGateway(); // Use Paypal for USD, EUR, AUD currencies
        }

        return new BraintreePaymentGateway(); // Use Braintree for other currencies
    }

    private function saveToDatabase($amount, $currency, $customer_name, $response)
    {
        // Implement database save logic here
        // Store $amount, $currency, $customer_name, and $response['transaction_id'] in the database
    }
}

class PaypalPaymentGateway
{
    public function makePayment($amount, $currency, $customer_name, $card_holder_name, $card_number, $expiration_month, $expiration_year, $cvv)
    {   
        $client_id = PAYPAL_CLIENT_ID;
        $secret = PAYPAL_SECRET;
        $environment = PAYPAL_ENVIRONMENT;
        // Implement PayPal payment logic here
        // Use the PayPal REST API to make the payment
        // Return the payment response, including transaction_id
    }
}

class BraintreePaymentGateway
{
    public function makePayment($amount, $currency, $customer_name, $card_holder_name, $card_number, $expiration_month, $expiration_year, $cvv)
    {   
        $merchant_id = BRAINTREE_MERCHANT_ID;
        $public_key = BRAINTREE_PUBLIC_KEY;
        $private_key = BRAINTREE_PRIVATE_KEY;
        // Implement Braintree payment logic here
        // Use the Braintree API to make the payment
        // Return the payment response, including transaction_id
    }
}
