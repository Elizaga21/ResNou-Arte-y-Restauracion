<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Pago</title>
    <link rel="icon" type="image/png" href="assets/img/LogoRESNOUNegroC.svg">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>

        
:root {
    --black: #000000;
    --white: #ffffff;
    --green: #525f48;
    --beige: #b79e94;
    --fern: #a8bba2;
}
.container-confirmar-pago {
    max-width: 600px;
            margin: 50px auto;
            margin-top: 140px;
            margin-bottom: 140px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            text-align: center;
}
p {
    line-height: 1.5; 
}

strong {
    color: var(--green); 
}    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container-confirmar-pago">
        <h2>Confirmar Pago por Bizum</h2>
        <br>
        <p>Por favor, realiza el pago por Bizum al número  <strong>670 33 57 48</strong>.</p>
        <p>En el concepto del pago, especifica tu nombre, el nombre de la clase y el bono seleccionado.</p>

</div>
    <?php include 'footer.php'; ?>
</body>
</html>
