<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Payment Gateway</title>
</head>
<body>
    <!-- Your payment form goes here -->
    <form method="post" action="process_payment.php">
        <!-- Order section -->
        <label for="amount">Price (amount):</label>
        <input type="number" name="amount" required>

        <label for="currency">Currency:</label>
        <select name="currency" required>
            <option value="USD">USD</option>
            <option value="EUR">EUR</option>
            <option value="THB">THB</option>
            <option value="HKD">HKD</option>
            <option value="SGD">SGD</option>
            <option value="AUD">AUD</option>
        </select>

        <label for="customer_name">Customer Full name:</label>
        <input type="text" name="customer_name" required>

        <!-- Payment section -->
        <label for="card_holder_name">Credit card holder name:</label>
        <input type="text" name="card_holder_name" required>

        <label for="card_number">Credit card number:</label>
        <input type="text" name="card_number" required>

        <label for="expiration_month">Expiration Month:</label>
        <input type="text" name="expiration_month" required>

        <label for="expiration_year">Expiration Year:</label>
        <input type="text" name="expiration_year" required>

        <label for="cvv">Credit card CCV:</label>
        <input type="text" name="cvv" required>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
