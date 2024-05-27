<?php
session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['rol'] !== 'empleado' && $_SESSION['rol'] !== 'administrador')) {
    header("Location: login.php");
    exit();
}

require 'db_connection.php';

// Función para obtener todas las clases
function obtenerClases($pdo) {
    $stmt = $pdo->query("SELECT * FROM clases");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener una clase por su ID
function obtenerClasePorID($pdo, $claseID) {
    $stmt = $pdo->prepare("SELECT * FROM clases WHERE ClaseID = ?");
    $stmt->execute([$claseID]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Función para actualizar una clase
function actualizarClase($pdo, $claseID, $nombre, $descripcion, $fechaHoraInicio, $duracionMinutos, $precio, $materiales, $categoria, $cupoMaximo, $plazasReservadas) {
    $stmt = $pdo->prepare("UPDATE clases SET 
                           Nombre = ?,
                           Descripcion = ?,
                           FechaHoraInicio = ?,
                           DuracionMinutos = ?,
                           Precio = ?,
                           Materiales = ?,
                           Categoria = ?,
                           CupoMaximo = ?,
                           PlazasReservadas = ?
                           WHERE ClaseID = ?");
    return $stmt->execute([$nombre, $descripcion, $fechaHoraInicio, $duracionMinutos, $precio, $materiales, $categoria, $cupoMaximo, $plazasReservadas, $claseID]);
}

// Función para insertar una nueva clase
function insertarClase($pdo, $nombre, $descripcion, $fechaHoraInicio, $duracionMinutos, $precio, $materiales, $categoria, $cupoMaximo) {
    $stmt = $pdo->prepare("INSERT INTO clases (Nombre, Descripcion, FechaHoraInicio, DuracionMinutos, Precio, Materiales, Categoria, CupoMaximo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$nombre, $descripcion, $fechaHoraInicio, $duracionMinutos, $precio, $materiales, $categoria, $cupoMaximo]);
}

// Función para eliminar una clase por su ID
function eliminarClase($pdo, $claseID) {
    $stmt = $pdo->prepare("DELETE FROM clases WHERE ClaseID = ?");
    return $stmt->execute([$claseID]);
}

// Procesar formularios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        switch ($accion) {
            case 'actualizar':
                // Procesar formulario de actualización
                $claseID = $_POST['clase_id'];
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $fechaHoraInicio = $_POST['fecha_hora_inicio'];
                $duracionMinutos = $_POST['duracion_minutos'];
                $precio = $_POST['precio'];
                $materiales = $_POST['materiales'];
                $categoria = $_POST['categoria'];
                $cupoMaximo = $_POST['cupo_maximo'];
                $plazasReservadas = $_POST['plazas_reservadas'];

                if (actualizarClase($pdo, $claseID, $nombre, $descripcion, $fechaHoraInicio, $duracionMinutos, $precio, $materiales, $categoria, $cupoMaximo, $plazasReservadas)) {
                } else {
                    echo "Error al actualizar la clase.";
                }
                break;

            case 'insertar':
                // Procesar formulario de inserción
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $fechaHoraInicio = $_POST['fecha_hora_inicio'];
                $duracionMinutos = $_POST['duracion_minutos'];
                $precio = $_POST['precio'];
                $materiales = $_POST['materiales'];
                $categoria = $_POST['categoria'];
                $cupoMaximo = $_POST['cupo_maximo'];

                if (insertarClase($pdo, $nombre, $descripcion, $fechaHoraInicio, $duracionMinutos, $precio, $materiales, $categoria, $cupoMaximo)) {
                    $_SESSION['mensaje_exito'] = "Clase insertada correctamente.";
                    echo "<script>window.location.href = 'mantenimiento_categorias.php';</script>"; // Redirige para evitar reenvío del formulario
                    exit();
                } else {
                    echo "Error al insertar la clase.";
                }
                
                break;

            case 'eliminar':
                // Procesar formulario de eliminación
                $claseID = $_POST['clase_id'];

                if (eliminarClase($pdo, $claseID)) {
                } else {
                    echo "Error al eliminar la clase.";
                }
                break;

            default:
                echo "Acción no reconocida.";
        }
    }
}

// Obtener todas las clases
$clases = obtenerClases($pdo);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento de Clases</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="icon" type="image/png" href="assets/img/LogoRESNOUNegroC.svg">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <style>
    :root {
    --black: #000000;
    --white: #ffffff;
    --green: #525f48;
    --beige: #b79e94;
    --fern: #a8bba2;
}
.container-clase {
    margin-top: 160px; 
    margin-bottom: 150px;
    display: flex;
    justify-content: center;
    text-align:center;
    flex-direction: column;
    padding: 20px;
    align-items: center;
    max-width: auto;
}

h2, h3 {
    color: #000000;
    margin-bottom: 15px;
}

/* Estilos del formulario */
form {
    background-color: #525f48;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

form label {
    display: block;
    margin-bottom: 5px;
}

form input,
form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

form input[type="checkbox"] {
    margin-top: 5px;
}

form input[type="submit"] {
    background-color: #a8bba2;
    color: #fff;
    padding: 12px 20px; 
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}


form input[type="submit"]:hover {
    background-color: #b79e94;
}

/* Estilos de la lista de categorías */
.lista-categoria {
    list-style: none;
    padding: 0;
}

.lista-categoria li {
    margin-bottom: 20px;
    background-color: #525f48;
    padding: 15px;
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.lista-categoria li div {
    flex-grow: 1; 
}

/* Estilos de los botones de actualizar y eliminar */
.lista-categoria li form[style="display: inline;"] {
    display: flex;
}


/* Estilos de los botones de actualizar y eliminar */
.lista-categoria li form[style="display: inline;"] input[type="submit"] {
    background-color: #525f48;
    color: #fff;
    padding: 8px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 10px;
    margin-right: 10px;
}

/* Estilos de los botones de actualizar y eliminar */
<!-- Estilos de los botones de actualizar y eliminar -->
.lista-categoria li form[style="display: inline;"] input[type="submit"][value="Actualizar"] {
    background-color: #000;
    color: #fff;
    padding: 12px 20px;
}

.lista-categoria li form[style="display: inline;"] input[type="submit"][value="Eliminar"] {
    background-color: #525f48;
    color: #fff;
    padding: 12px 20px;
}

/* Estilo para el botón "Actualizar" */
.lista-categoria li form[style="display: inline;"] .btn-actualizar {
    background-color: #525f48;
    color: #fff;
    padding: 12px 20px;
}

/* Estilo para el botón "Eliminar" */
.lista-categoria li form[style="display: inline;"] .btn-eliminar {
    background-color: #525f48;
    color: #fff;
    padding: 12px 20px;
}




    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container-clase">
    <h2>Mantenimiento de Clases</h2>

<!-- Formulario para insertar una nueva clase -->
<form method="post">
    <h3>Nueva Clase</h3>
    <label>Nombre:</label>
    <input type="text" name="nombre" required>
    <label>Descripción:</label>
    <textarea name="descripcion" rows="3"></textarea>
    <label>Fecha y Hora de Inicio:</label>
    <input type="datetime-local" name="fecha_hora_inicio" required>
    <label>Duración (minutos):</label>
    <input type="number" name="duracion_minutos" required>
    <label>Precio:</label>
    <input type="number" step="0.01" name="precio" required>
    <label>Materiales:</label>
    <textarea name="materiales" rows="3"></textarea>
    <label>Categoría:</label>
    <select name="categoria" required>
        <option value="Arte para niños">Arte para niños</option>
        <option value="Pintura y dibujo para Adultos">Pintura y dibujo para Adultos</option>
        <option value="Restauración para Adultos">Restauración para Adultos</option>
    </select>
    <label>Cupo Máximo:</label>
    <input type="number" name="cupo_maximo" required>
    <input type="hidden" name="accion" value="insertar">
    <input type="submit" value="Insertar Clase">
</form>

<!-- Lista de clases existentes con opciones de actualización y eliminación -->
<h3>Clases Existentes</h3>
<ul class="lista-clases">
<?php foreach ($clases as $clase) : ?>
<li>
    <div style="display: flex; align-items: center;">
        <div>
            <strong>Nombre:</strong> <?php echo $clase['Nombre']; ?><br>
            <strong>Fecha y Hora de Inicio:</strong> <?php echo $clase['FechaHoraInicio']; ?><br>
            <strong>Precio:</strong> $<?php echo $clase['Precio']; ?>
        </div>
        <!-- Formulario para actualizar la clase actual -->
        <form method="post">
            <input type="hidden" name="clase_id" value="<?php echo $clase['ClaseID']; ?>">
            <input type="hidden" name="nombre_actual" value="<?php echo $clase['Nombre']; ?>">
            <input type="hidden" name="descripcion_actual" value="<?php echo $clase['Descripcion']; ?>">
            <input type="hidden" name="fecha_hora_inicio_actual" value="<?php echo $clase['FechaHoraInicio']; ?>">
            <input type="hidden" name="duracion_minutos_actual" value="<?php echo $clase['DuracionMinutos']; ?>">
            <input type="hidden" name="precio_actual" value="<?php echo $clase['Precio']; ?>">
            <input type="hidden" name="materiales_actual" value="<?php echo $clase['Materiales']; ?>">
            <input type="hidden" name="categoria_actual" value="<?php echo $clase['Categoria']; ?>">
            <input type="hidden" name="cupo_maximo_actual" value="<?php echo $clase['CupoMaximo']; ?>">
            <input type="hidden" name="plazas_reservadas_actual" value="<?php echo $clase['PlazasReservadas']; ?>">

            <input type="hidden" name="accion" value="actualizar">
            <!-- Campos de entrada actualizados con los valores actuales -->
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $clase['Nombre']; ?>" required>
            <label>Descripción:</label>
            <textarea name="descripcion" rows="3"><?php echo $clase['Descripcion']; ?></textarea>
            <label>Fecha y Hora de Inicio:</label>
            <input type="datetime-local" name="fecha_hora_inicio" value="<?php echo date('Y-m-d\TH:i', strtotime($clase['FechaHoraInicio'])); ?>" required>
            <label>Duración (minutos):</label>
            <input type="number" name="duracion_minutos" value="<?php echo $clase['DuracionMinutos']; ?>" required>
            <label>Precio:</label>
            <input type="number" step="0.01" name="precio" value="<?php echo $clase['Precio']; ?>" required>
            <label>Materiales:</label>
            <textarea name="materiales" rows="3"><?php echo $clase['Materiales']; ?></textarea>
            <label>Categoría:</label>
            <select name="categoria" required>
                <option value="Arte para niños" <?php echo ($clase['Categoria'] == 'Arte para niños') ? 'selected' : ''; ?>>Arte para niños</option>
                <option value="Pintura y dibujo para Adultos" <?php echo ($clase['Categoria'] == 'Pintura y dibujo para Adultos') ? 'selected' : ''; ?>>Pintura y dibujo para Adultos</option>
                <option value="Restauración para Adultos" <?php echo ($clase['Categoria'] == 'Restauración para Adultos') ? 'selected' : ''; ?>>Restauración para Adultos</option>
            </select>
            <label>Cupo Máximo:</label>
            <input type="number" name="cupo_maximo" value="<?php echo $clase['CupoMaximo']; ?>" required>
            <label>Plazas Reservadas:</label>
            <input type="number" name="plazas_reservadas" value="<?php echo $clase['PlazasReservadas']; ?>" required>

            <input type="submit" class="btn-actualizar" value="Actualizar">
        </form>

        <form method="post">
            <input type="hidden" name="clase_id" value="<?php echo $clase['ClaseID']; ?>">
            <input type="hidden" name="accion" value="eliminar">
            <input type="submit" class="btn-eliminar" value="Eliminar" onclick="return confirm('¿Estás seguro?')">
        </form>
    </div>
</li>
<?php endforeach; ?>
</ul>

</div>

<?php include 'footer.php'; ?>

<script>
<?php
if (isset($_SESSION['mensaje_exito'])) {
echo "alert('{$_SESSION['mensaje_exito']}');";
unset($_SESSION['mensaje_exito']); // Limpiar la variable de sesión después de mostrar el mensaje
}
?>
</script>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>