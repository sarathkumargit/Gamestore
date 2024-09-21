<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateway</title>
    <link rel="stylesheet" href="payment.css">
</head>
<body>
<div class="payment-container">
    <h2>Payment Gateway</h2>
    <form action="" method="POST" class="payment-form" onsubmit="return displayPending()">
        <div class="form-group">
            <label>Card Type</label>
            <div class="card-type">
                <input type="radio" id="visa" name="cardType" value="Visa" required>
                <label for="visa"><img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa"></label>
                <input type="radio" id="mastercard" name="cardType" value="MasterCard" required>
                <label for="mastercard"><img src="https://img.icons8.com/color/48/000000/mastercard.png" alt="MasterCard"></label>
            </div>
        </div>
        <div class="form-group">
            <label for="cardName">Cardholder Name</label>
            <input type="text" id="cardName" name="cardName" required>
        </div>
        <div class="form-group">
            <label for="cardNumber">Card Number</label>
            <input type="text" id="cardNumber" name="cardNumber" maxlength="19" pattern="\d{4} \d{4} \d{4} \d{4}" required>
        </div>
        <div class="form-group">
            <label for="expiryDate">Expiry Date</label>
            <input type="month" id="expiryDate" name="expiryDate" required>
        </div>
        <div class="form-group">
            <label for="cvv">CVV</label>
            <input type="text" id="cvv" name="cvv" maxlength="3" pattern="\d{3}" required>
        </div>
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="text" id="amount" name="amount" required>
        </div>
        <button type="submit" class="submit-btn">Pay Now</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalAmount = localStorage.getItem('totalAmount');
        console.log('Total Amount from localStorage:', totalAmount); // Debugging line
        if (totalAmount) {
            document.getElementById('amount').value = totalAmount;
        }
    });

    document.getElementById('cardNumber').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        let formattedValue = '';
        for (let i = 0; i < value.length; i += 4) {
            if (i > 0) formattedValue += ' ';
            formattedValue += value.substring(i, i + 4);
        }
        e.target.value = formattedValue;
    });

    function displayPending() {
        const modal = document.getElementById('paymentModal');
        const span = document.getElementsByClassName('close-btn')[0];
        const modalMessage = document.getElementById('modalMessage');

        // Show the modal
        modal.style.display = 'block';

        // After 3 seconds, change the message
        setTimeout(function() {
            modalMessage.innerHTML = '<p>Payment Successful!<br/>Your Game is Downloading Now!</p>';
        }, 3000);

        // Close button functionality
        span.onclick = function() {
            modal.style.display = 'none';
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }

        // Prevent form submission for demonstration purposes
        return false;
    }
</script>

<!-- Modal -->
<div id="paymentModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <div id="modalMessage">
            <div class="spinner"></div>
            <p>Payment Pending...</p>
        </div>
    </div>
</div>

</body>
</html>
