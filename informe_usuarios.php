<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}



require 'db_connection.php';
//require 'clientes.php';

// Variables para almacenar la información del cliente
$clienteInfo = "";

// Código de búsqueda y visualización de resultados...
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se ha enviado el formulario de búsqueda
    $dni = isset($_POST['dni_buscar']) ? $_POST['dni_buscar'] : '';

    // Crea una instancia de ClienteRepository
    $clienteRepository = new ClienteRepository($pdo);

    // Realiza la búsqueda por DNI
    $cliente = $clienteRepository->buscarPorDni($dni);

    if ($cliente) {
        // Almacena la información del cliente en la variable
        $clienteInfo = "<h3>Información del Cliente:</h3>";
        $clienteInfo .= "DNI: " . $cliente->getDni() . "<br>";
        $clienteInfo .= "Nombre: " . $cliente->getNombre() . "<br>";
        $clienteInfo .= "Apellidos: " . $cliente->getApellidos() . "<br>";
        $clienteInfo .= "Dirección: " . $cliente->getDireccion() . "<br>";
        $clienteInfo .= "Localidad: " . $cliente->getLocalidad() . "<br>";
        $clienteInfo .= "Provincia: " . $cliente->getProvincia() . "<br>";
        $clienteInfo .= "País: " . $cliente->getPais() . "<br>";
        $clienteInfo .= "Código Postal: " . $cliente->getCodPos() . "<br>";
        $clienteInfo .= "Teléfono: " . $cliente->getTelefono() . "<br>";
        $clienteInfo .= "Email: " . $cliente->getEmail() . "<br>";
        $clienteInfo .= "Rol: " . $cliente->getRol() . "<br>";
        $clienteInfo .= "Activo: " . $cliente->getActivo() . "<br>";



    } else {
        // Muestra un mensaje si el cliente no se encuentra
        $clienteInfo = "<p>Cliente no encontrado.</p>";
    }
}
// Configuración de la ordenación
$ordenarPor = isset($_GET['ordenar_por']) ? $_GET['ordenar_por'] : 'nombre';
$ordenAscendente = isset($_GET['orden_ascendente']) ? $_GET['orden_ascendente'] : true;

// Obtener la lista de usuarios ordenada
$orden = $ordenAscendente ? 'ASC' : 'DESC';
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE activo = true ORDER BY $ordenarPor $orden");
$stmt->execute();
$usuarios = $stmt->fetchAll();
    ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="icon" type="image/png" href="assets/img/LogoRESNOUNegroC.svg">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

   <style>
 
 :root {
    --black: #000000;
    --white: #ffffff;
    --green: #525f48;
    --beige: #b79e94;
    --fern: #a8bba2;
}

.container-admin {
    margin-top: 150px; 
    margin-bottom: 150px;
    display: flex;
    justify-content: center;
    text-align:center;
    flex-direction: column;
    padding: 20px;
    align-items: center;
    max-width: auto;
   
}

.user-table {
    width: 100%; 
    border-collapse: collapse;
    margin: 20px auto;
    text-align: center;
    display: table;
}

form {
    margin-top: 20px;
    text-align: center;
}

form input[type="text"] {
    width: 20%; 
    padding: 8px;
    font-size: 14px; 
}

form input[type="submit"] {
    width: auto; 
    padding: 8px 15px;
    font-size: 14px; 
}


h2, h3 {
    color: #525f48;
}

.welcome-text {
    color: #525f48;
}

.user-table th, .user-table td {
    border: 1px solid #525f48;
    padding: 8px;
    text-align: left;
}

.user-table th {
    background-color: #525f48; 
    color: #a8bba2; 
}

.actions {
    display: flex;
    justify-content: space-around;
}

.action-link {
    text-decoration: none;
    color: #525f48;
}

.action-link img {
    width: 20px;
    height: 20px;
}

.action-link:hover {
    color: #a8bba2; 
}

.order-form {
    margin-top: 20px;
}

.order-button {
    background-color: #525f48; 
    color: #ffffff; 
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.order-button:hover {
    background-color: #a8bba2; 
}

.admin-links {
    margin-top: 20px;
    margin-bottom: 20px;
    display: flex;
    flex-wrap: wrap;
    flex-direction: column; 
    align-items: center; 
}

.admin-link {
    text-decoration: none;
    color: #a8bba2;
    padding: 10px;
    margin: 5px;
    border: 1px solid #000;
    border-radius: 4px;
    transition: background-color 0.3s, color 0.3s;
}

.admin-link:hover {
    background-color: #000;
    color: #fff;
}

.admin-links::before {
    content: "Mantenimiento";
    font-weight: bold;
    margin-bottom: 10px;
    color: #000;
}
.back-button-container {
            text-align: center;
            margin-top: 20px; 
        }

        .back-button {
            text-decoration: none;
            background-color: #b79e94;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .back-button:hover {
            background-color: #333; 
        }

        .edit-icon {
    font-size: 30px; 
    color: #000; 
    text-decoration: none; 
}

.delete-icon{
    font-size: 30px; 
    color: #000; 
    text-decoration: none; 
}
.edit-icon:hover {
    opacity: 0.8;
}
.delete-icon:hover {
    opacity: 0.8;
}

.admin-links_users {
    margin-top: 20px;
    display: flex;
    justify-content: flex-end; 
}

.admin-link_user {
    text-decoration: none;
    color: #ffffff; 
    padding: 10px;
    margin: 5px;
    background-color: #525f48; 
    border: 1px solid #000;
    border-radius: 4px;
    transition: background-color 0.3s, color 0.3s;
}

.admin-link_user:hover {
    background-color: #b79e94; 
    color: #000000; 
}

#cliente-info {
    margin-top: 20px;
    max-width: 400px;
    text-align: center;
    width: 100%;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: none; 
    margin: 0 auto; 
}


    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container-admin">

    <?php if (isset($_SESSION['user_id'])) : ?>
            <?php
            $stmt_user = $pdo->prepare("SELECT nombre FROM usuarios WHERE id = ?");
            $stmt_user->execute([$_SESSION['user_id']]);
            $admin = $stmt_user->fetch();
            ?>
        <?php endif; ?>

        <h2>Informe de Usuarios</h2>
        <h3>Usuarios activos registrados:</h3>
        
        <div class="admin-links_users">
    <a href="registro_admin.php" class="admin-link_user">Crear nuevo usuario</a>
</div>
        <table class="user-table">
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Dirección</th>
                <th>Localidad</th>
                <th>Provincia</th>
                <th>País</th>
                <th>Código Postal</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($usuarios as $usuario) : ?>
                <tr>
                    <td><?php echo $usuario['dni']; ?></td>
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['apellidos']; ?></td>
                    <td><?php echo $usuario['direccion']; ?></td>
                    <td><?php echo $usuario['localidad']; ?></td>
                    <td><?php echo $usuario['provincia']; ?></td>
                    <td><?php echo $usuario['pais']; ?></td>
                    <td><?php echo $usuario['codpos']; ?></td>
                    <td><?php echo $usuario['telefono']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td><?php echo $usuario['rol']; ?></td>
                    <td class="actions">
                        <?php if ($_SESSION['user_id'] !== $usuario['id']) : ?>
                            <a href="editar_datos.php?id=<?php echo $usuario['id']; ?>" class="action-link">
                            <span class="material-icons">edit</span>
                            </a>
                            <a href="eliminar_cuenta.php?id=<?php echo $usuario['id']; ?>" class="action-link">
                            <span class="material-icons">delete</span> 
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <form class="order-form" method="get">
            <input type="hidden" name="ordenar_por" value="<?php echo $ordenarPor; ?>">
            <input type="hidden" name="orden_ascendente" value="<?php echo !$ordenAscendente; ?>">
            <button type="submit" class="order-button">Cambiar Orden</button>
        </form>

    </div>

    <form method="POST">
    <input type="text" name="dni_buscar" placeholder="DNI">
    <input type="submit" value="Buscar">
    </form>

    <?php if (!empty($clienteInfo)) : ?>
    <script>
        // Muestra el bloque #cliente-info cuando hay información disponible
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("cliente-info").style.display = "block";
        });
    </script>
    <div id="cliente-info">
        <?php echo $clienteInfo; ?>
    </div>
<?php endif; ?>


    <div class="back-button-container">
            <a href="<?php echo ($_SESSION['rol'] === 'cliente') ? 'cliente.php' : 'admin.php'; ?>" class="back-button">Volver</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
