<?php
include 'db_connection.php';
include 'header.php';

if (isset($_SESSION['user_id']) && $_SESSION['rol'] === 'cliente') {
    $user_id = $_SESSION['user_id'];

    $stmt_user = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt_user->execute([$user_id]);
    $user = $stmt_user->fetch();

    $stmt_orders = $pdo->prepare("SELECT * FROM reservas WHERE UsuarioID = ? AND activo = true");
    $stmt_orders->execute([$user_id]);
    $orders = $stmt_orders->fetchAll();
    


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Procesar la actualización del EstadoPedido
        if (isset($_POST['updateOrder'])) {
            $ReservaID = $_POST['ReservaID'];
            $EstadoReserva = $_POST['EstadoReserva'];

            $stmt_update_order = $pdo->prepare("UPDATE reservas SET EstadoReserva = ? WHERE ReservaID = ?");
            $stmt_update_order->execute([$nuevoEstado, $pedidoID]);
        }

        // Procesar la cancelación del pedido dentro de las primeras 24 horas
        if (isset($_POST['cancelOrder'])) {
            $ReservaID = $_POST['ReservaID'];

            $stmt_get_order_date = $pdo->prepare("SELECT Fecha FROM reservas WHERE ReservaID = ?");
            $stmt_get_order_date->execute([$ReservaID]);
            $fechaReserva = $stmt_get_order_date->fetchColumn();

            $fechaActual = date('Y-m-d');
            $diferenciaFechas = strtotime($fechaActual) - strtotime($fechaReserva);
            $diferenciaHoras = $diferenciaFechas / (60 * 60);

            if ($diferenciaHoras <= 24) {
                // Desactivar el pedido (cambiar activo a false)
                $stmt_desactivar_pedido = $pdo->prepare("UPDATE reservas SET activo = false WHERE ReservaID = ?");
                $stmt_desactivar_pedido->execute([$pedidoID]);
            } else {
                $error_message = "No se puede cancelar el pedido después de 24 horas.";
            }
    }
    
    }
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mis Reservas</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="icon" type="image/png" href="assets/img/LogoRESNOUNegroC.svg">
        <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <style>  

.wrapper {
    margin-top: 150px; 
    margin-bottom: 120px;
    display: flex;
    justify-content: center;
    text-align:center;
    flex-direction: column;
    align-items: center;
    max-width: auto;
}

.container {
    max-width: 800px;
    width: 120%;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    flex: 1; 
}
#content {
            margin-top: 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #content h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .order {
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-left: auto;
            margin-right: auto;
            width: 70%;
            margin: 0 auto;
        }

        .order p {
            margin: 0 0 10px;
        }

        .order ul {
            list-style: none;
            padding: 0;
        }

        .order li {
            margin-bottom: 5px;
        }

        .order li strong {
            margin-right: 5px;
        }
         /* Estilos para el formulario de actualizar EstadoPedido */
         .update-form {
             margin-top: 10px;
         }
         
         .update-form label {
             margin-right: 10px;
         }
         
         .update-form select {
             width: 80px; 
             padding: 5px;
             margin-right: 10px;
         }
         
         .update-form button {
             padding: 10px 15px; 
             margin-top: 10px;
             margin-bottom: 10px;
             background-color: #007bff; 
             color: #fff; 
             border: none;
             cursor: pointer;
         }
         
         .update-form button:hover {
             background-color: #0056b3; 
         }
         
         .cancelOrder-form {
           margin-left: auto; 
           }
         .cancelOrder-form button {
             padding: 10px 15px; 
             margin-top: 10px;
             margin-bottom: 10px; 
             background-color: #dc3545; 
             color: #fff; 
             border: none;
             cursor: pointer;
         }
         
         .cancelOrder-form button:hover {
             background-color: #c82333; 
         }

         .error-message {
    color: #dc3545; 
    margin-top: 10px;
    font-weight: bold;
     }
     
     /* Estilo específico para el formulario de actualizar Forma de Envío */
     .update-form.shipping-form {
         margin-top: 20px;
     }
     
     .update-form.shipping-form label {
         margin-right: 10px;
     }
     
     .update-form.shipping-form select {
         width: 150px; 
         padding: 5px;
         margin-right: 10px;
     }
     
     .update-form.shipping-form button {
         padding: 10px 15px;
         margin-top: 10px;
         margin-bottom: 10px;
         background-color: #007bff;
         color: #fff;
         border: none;
         cursor: pointer;
     }
     
     .update-form.shipping-form button:hover {
         background-color: #0056b3;
     }

    </style>
</head>
    <body>
    <div class="wrapper">
    <div id="container">

        <div id="content">
            <h2>Historial de Reservas de <?= htmlspecialchars($user['nombre']) ?></h2>

            <?php foreach ($orders as $order): ?>
                <?php
                $stmt_order_details = $pdo->prepare("SELECT * FROM reservas WHERE ReservaID = ?");
                $stmt_order_details->execute([$order['ReservaID']]);
                $order_details = $stmt_order_details->fetchAll();

                // Obtener la información de la clase reservada
                $stmt_get_class_info = $pdo->prepare("SELECT Nombre, Precio FROM clases WHERE ClaseID = ?");
                $stmt_get_class_info->execute([$order['ClaseID']]);
                $class_info = $stmt_get_class_info->fetch();
                ?>

                <div class="order">
                    <p><strong>Número de Reserva:</strong> <?= htmlspecialchars($order['ReservaID']) ?></p>
                    <p><strong>Fecha:</strong> <?= htmlspecialchars($order['Fecha']) ?></p>
                    <p><strong>Estado:</strong> <?= htmlspecialchars($order['EstadoReserva']) ?></p>

                    <h3>Información de la Clase:</h3>
                    <p><strong>Nombre:</strong> <?= htmlspecialchars($class_info['Nombre']) ?></p>
                    <p><strong>Precio:</strong> <?= htmlspecialchars($class_info['Precio']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div>

    
    <?php include 'footer.php'; ?>

    </body>
    </html>

    <?php
} else {
    header("Location: login.php");
    exit();
}
?>
