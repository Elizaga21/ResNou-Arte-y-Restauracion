<?php
session_start();
require 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proceso de Pago</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="assets/img/LogoRESNOUNegroC.svg">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>   
    <script src="https://js.stripe.com/v3/"></script>

    <style>

.container-pasarela {
    max-width: 600px;
    margin: 140px auto 50px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

#ideal-bank-container {
    margin-top: 20px; 
    margin-bottom: 20px;
}

form {
    width: 100%;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.form-control {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    box-sizing: border-box;
}

.form-control:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
}

select.form-control {
    height: 45px;
}

#payButton {
    width: 100%;
    padding: 10px;
    font-size: 18px;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

#payButton:hover {
    background-color: #0056b3;
}

#payButton:focus {
    outline: none;
}

#payButton:active {
    background-color: #004085;
}
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container-pasarela">
        <div id="ideal-bank-container">
            <div id="ideal-bank-element"></div>
        </div>
        <form id="payment-form" action="payment_process.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="card-number">Card Number</label>
                <input type="text" class="form-control" id="card-number" name="card-number" required>
            </div>

            <div class="form-group">
                <label for="expiration-date">Expiration Date</label>
                <input type="text" class="form-control" id="expiration-date" name="expiration-date" placeholder="Ej: 12/36" required>
            </div>

            <div class="form-group">
                <label for="cvc">CVC</label>
                <input type="text" class="form-control" id="cvc" name="cvc" placeholder="xxx" required>
            </div>

            <div class="form-group">
                <label for="name-on-card">Name on Card</label>
                <input type="text" class="form-control" id="name-on-card" name="name-on-card" required>
            </div>

            <div class="form-group">
                <label for="country">Country</label>
                <select class="form-control" id="country" name="country" required>
                    <option value="United States">United States</option>
                    <option value="Canada">Canada</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Brazil">Brazil</option>
                    <option value="España">España</option>
                </select>
            </div>

            <input type="hidden" name="paymentMethodId" id="paymentMethodId" value="">
            <button type="button" id="payButton" class="btn btn-primary">Pagar</button>
        </form>
    </div>


    <?php include 'footer.php'; ?>

    <script>
        var stripe = Stripe('pk_test_51OdDwPEKHkfLvKZ82d07UlaG3aUGH6Ooct7aSpsveedoJtl2btOMOSwgjNSHbKzEPNEfTdlJfe3dPgH6eiyd801g00lV1WKP9j');
        var elements = stripe.elements();

        var options = {
            style: {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4',
                    },
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a',
                },
            },
        };

        var idealBank = elements.create('idealBank', options);
        idealBank.mount('#ideal-bank-element');

        var form = document.getElementById('payment-form');
        var payButton = document.getElementById('payButton');

        payButton.addEventListener('click', function () {
            stripe.createPaymentMethod({
                type: 'ideal',
                ideal: idealBank,
                billing_details: {
                    name: document.getElementById('name-on-card').value,
                },
            }).then(function (result) {
                if (result.error) {
                    console.error(result.error);
                } else {
                    document.getElementById('paymentMethodId').value = result.paymentMethod.id;
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>
