<!DOCTYPE html>
<html>
<head>
    <title>Payment Gateway</title>
    <!-- Include Bootstrap CSS from CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom styles for the form */
        body {
            background: #f5f5f5;
            background-image: linear-gradient(120deg, #f5f5f5, #e8f0ff);
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            border-radius: 3px;
        }

        .btn {
            border-radius: 3px;
            background-color: #007bff;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Your payment form goes here -->
                <form method="post" action="process_payment.php">
                    <!-- Order section -->
                    <div class="form-group">
                        <label for="amount">Price (amount):</label>
                        <input type="number" class="form-control" name="amount" value="100" required>
                    </div>

                    <div class="form-group">
                        <label for="currency">Currency:</label>
                        <select class="form-control" name="currency" required>
                            <option value="USD" selected>USD</option>
                            <option value="EUR">EUR</option>
                            <option value="THB">THB</option>
                            <option value="HKD">HKD</option>
                            <option value="SGD">SGD</option>
                            <option value="AUD">AUD</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="customer_name">Customer Full name:</label>
                        <input type="text" class="form-control" name="customer_name" value="John Doe" required>
                    </div>

                    <!-- Payment section -->
                    <div class="form-group">
                        <label for="card_holder_name">Credit card holder name:</label>
                        <input type="text" class="form-control" name="card_holder_name" value="John Doe" required>
                    </div>

                    <div class="form-group">
                        <label for="card_number">Credit card number:</label>
                        <input type="text" class="form-control" name="card_number" value="4111111111111111" required>
                    </div>

                    <div class="form-group">
                        <label>Expiration Date:</label>
                        <div class="d-flex">
                            <select class="form-control mr-2" name="expiration_month" required>
                                <option value="" disabled>Month</option>
                                <option value="01" selected>January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>

                            <input type="number" class="form-control" name="expiration_year" value="2025" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cvv">Credit card CCV:</label>
                        <input type="text" class="form-control" name="cvv" value="111" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
