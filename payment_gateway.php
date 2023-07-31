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
        
        echo "<pre>"; 
           print_r($payment_gateway);
           print_r($response);
        echo "</pre>";
        exit;

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

        // Set API endpoint based on the environment
        $api_endpoint = $environment === 'sandbox' ? 'https://api.sandbox.paypal.com/v1' : 'https://api.paypal.com/v1';

        // Prepare the payment payload
        //VISA, MASTERCARD, AMEX, DISCOVER, DINERS, MAESTRO, ELO, HIPER, SWITCH, JCB, HIPERCARD, CUP, RUPAY
        $payload = [
            'intent' => 'sale',
            'payer' => [
                'payment_method' => 'credit_card',
                'funding_instruments' => [
                    [
                        'credit_card' => [
                            'type' => 'VISA',
                            'number' => $card_number,
                            'expire_month' => $expiration_month,
                            'expire_year' => $expiration_year,
                            'cvv2' => $cvv,
                            'first_name' => $card_holder_name,
                            'last_name' => $customer_name
                        ]
                    ]
                ]
            ],
            'transactions' => [
                [
                    'amount' => [
                        'total' => $amount,
                        'currency' => $currency
                    ]
                ]
            ]
        ];

        // Convert the payload to JSON
        $payload_json = json_encode($payload);

        // Prepare the cURL request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_endpoint . '/payments/payment');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload_json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($client_id . ':' . $secret)
        ]);

        // Execute the cURL request
        $response_json = curl_exec($ch);
        curl_close($ch);

        // Parse the response JSON
        $response = json_decode($response_json, true);

        echo "<pre>"; 
        print_r($response);
        echo "</pre>";

        // Check if the payment was successful
        if (isset($response['state']) && $response['state'] === 'approved') {
            return ['status' => 'success', 'transaction_id' => $response['id']];
        } else {
            $error_message = isset($response['message']) ? $response['message'] : 'Payment failed.';
            return ['status' => 'error', 'message' => $error_message];
        }
     }   

}


require_once 'vendor/autoload.php'; // Include the Braintree PHP SDK

class BraintreePaymentGateway
{
    public function makePayment($amount, $currency, $customer_name, $card_holder_name, $card_number, $expiration_month, $expiration_year, $cvv)
    {
        $merchant_id = BRAINTREE_MERCHANT_ID;
        $public_key = BRAINTREE_PUBLIC_KEY;
        $private_key = BRAINTREE_PRIVATE_KEY;

        // Initialize Braintree with your sandbox credentials
        \Braintree\Configuration::environment('sandbox');
        \Braintree\Configuration::merchantId($merchant_id);
        \Braintree\Configuration::publicKey($public_key);
        \Braintree\Configuration::privateKey($private_key);

        // Prepare the payment payload
        $payload = [
            'amount' => $amount,
            'creditCard' => [
                'number' => $card_number,
                'expirationMonth' => $expiration_month,
                'expirationYear' => $expiration_year,
                'cvv' => $cvv,
                'cardholderName' => $card_holder_name
            ]
        ];

        // Make the payment request
        $result = \Braintree\Transaction::sale($payload);

        // Check if the payment was successful
        if ($result->success) {
            return ['status' => 'success', 'transaction_id' => $result->transaction->id];
        } else {
            $error_message = $result->message;
            return ['status' => 'error', 'message' => $error_message];
        }
    }
}
