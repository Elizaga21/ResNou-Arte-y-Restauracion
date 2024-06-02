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
function actualizarClase($pdo, $claseID, $nombre, $descripcion, $dia, $hora, $duracionMinutos, $precio, $materiales, $categoria, $cupoMaximo, $plazasReservadas) {
    $stmt = $pdo->prepare("UPDATE clases SET 
                           Nombre = ?,
                           Descripcion = ?,
                           Dia = ?,
                           Hora = ?,
                           DuracionMinutos = ?,
                           Precio = ?,
                           Materiales = ?,
                           Categoria = ?,
                           CupoMaximo = ?,
                           PlazasReservadas = ?
                           WHERE ClaseID = ?");
    return $stmt->execute([$nombre, $descripcion, $dia, $hora, $duracionMinutos, $precio, $materiales, $categoria, $cupoMaximo, $plazasReservadas, $claseID]);
}

// Función para insertar una nueva clase
function insertarClase($pdo, $nombre, $descripcion, $dia, $hora, $duracionMinutos, $precio, $materiales, $categoria, $cupoMaximo) {
    $stmt = $pdo->prepare("INSERT INTO clases (Nombre, Descripcion, Dia, Hora, DuracionMinutos, Precio, Materiales, Categoria, CupoMaximo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$nombre, $descripcion, $dia, $hora, $duracionMinutos, $precio, $materiales, $categoria, $cupoMaximo]);
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
                $dia = $_POST['dia'];
                $hora = $_POST['hora'];
                $duracionMinutos = $_POST['duracion_minutos'];
                $precio = $_POST['precio'];
                $materiales = $_POST['materiales'];
                $categoria = $_POST['categoria'];
                $cupoMaximo = $_POST['cupo_maximo'];
                $plazasReservadas = $_POST['plazas_reservadas'];

                if (actualizarClase($pdo, $claseID, $nombre, $descripcion, $dia, $hora, $duracionMinutos, $precio, $materiales, $categoria, $cupoMaximo, $plazasReservadas)) {
                    $_SESSION['mensaje_exito'] = "Clase actualizada correctamente.";
                    echo "<script>window.location.href = 'mantenimiento_categorias.php';</script>"; // Redirige para evitar reenvío del formulario
                    exit();
                } else {
                    echo "Error al actualizar la clase.";
                }
                break;

            case 'insertar':
                // Procesar formulario de inserción
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $dia = $_POST['dia'];
                $hora = $_POST['hora'];
                $duracionMinutos = $_POST['duracion_minutos'];
                $precio = $_POST['precio'];
                $materiales = $_POST['materiales'];
                $categoria = $_POST['categoria'];
                $cupoMaximo = $_POST['cupo_maximo'];

                if (insertarClase($pdo, $nombre, $descripcion, $dia, $hora, $duracionMinutos, $precio, $materiales, $categoria, $cupoMaximo)) {
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
                    $_SESSION['mensaje_exito'] = "Clase eliminada correctamente.";
                    echo "<script>window.location.href = 'mantenimiento_categorias.php';</script>"; // Redirige para evitar reenvío del formulario
                    exit();
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
    max-width: 900px;
    margin: 50px auto;
    margin-top: 140px;
    background-color: var(--white);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2, h3 {
    color: var(--green);
    text-align: center;
    margin-bottom: 30px;
}

form {
    margin-bottom: 20px;
    border: 1px solid var(--beige);
    padding: 20px;
    border-radius: 10px;
    transition: border-color 0.3s;
}

form:hover {
    border-color: var(--green);
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color: var(--black);
}

input[type="text"], input[type="number"], input[type="time"], textarea, select {
    width: calc(100% - 22px);
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid var(--beige);
    border-radius: 5px;
    transition: border-color 0.3s;
}

input[type="text"]:focus, input[type="number"]:focus, input[type="time"]:focus, textarea:focus, select:focus {
    border-color: var(--green);
}

button {
    background-color: var(--green);
    color: var(--white);
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: var(--beige);
}

.clase {
    margin-bottom: 20px;
    padding: 20px;
    background-color: var(--fern);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.clase:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

hr {
    border: 0;
    height: 1px;
    background: var(--beige);
    margin: 20px 0;
}

/* Responsive Styles */
@media (max-width: 768px) {
    body {
        padding: 10px;
    }

    .container-clase {
        padding: 15px;
    }

    form, .clase {
        padding: 15px;
    }

    input[type="text"], input[type="number"], input[type="time"], textarea, select {
        width: calc(100% - 20px);
        margin-bottom: 15px;
    }

    button {
        width: 100%;
        padding: 15px;
    }
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
            <label>Día:</label>
            <select name="dia" required>
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miércoles">Miércoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sábado">Sábado</option>
                <option value="Domingo">Domingo</option>
            </select>
            <label>Hora:</label>
            <input type="time" name="hora" required>
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
            <button type="submit">Insertar</button>
        </form>

        <hr>

    <!-- Listado de clases -->
    <h3>Clases Existentes</h3>
    <?php foreach ($clases as $clase): ?>
        <div class="clase">
            <form method="post">
                <input type="hidden" name="clase_id" value="<?php echo $clase['ClaseID']; ?>">
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($clase['Nombre']); ?>" required>
                <label>Descripción:</label>
                <textarea name="descripcion" rows="3"><?php echo htmlspecialchars($clase['Descripcion']); ?></textarea>
                <label>Día:</label>
                <select name="dia" required>
                    <option value="Lunes" <?php echo $clase['Dia'] == 'Lunes' ? 'selected' : ''; ?>>Lunes</option>
                    <option value="Martes" <?php echo $clase['Dia'] == 'Martes' ? 'selected' : ''; ?>>Martes</option>
                    <option value="Miércoles" <?php echo $clase['Dia'] == 'Miércoles' ? 'selected' : ''; ?>>Miércoles</option>
                    <option value="Jueves" <?php echo $clase['Dia'] == 'Jueves' ? 'selected' : ''; ?>>Jueves</option>
                    <option value="Viernes" <?php echo $clase['Dia'] == 'Viernes' ? 'selected' : ''; ?>>Viernes</option>
                    <option value="Sábado" <?php echo $clase['Dia'] == 'Sábado' ? 'selected' : ''; ?>>Sábado</option>
                    <option value="Domingo" <?php echo $clase['Dia'] == 'Domingo' ? 'selected' : ''; ?>>Domingo</option>
                </select>
                <label>Hora:</label>
                <input type="time" name="hora" value="<?php echo htmlspecialchars($clase['Hora']); ?>" required>
                <label>Duración (minutos):</label>
                <input type="number" name="duracion_minutos" value="<?php echo htmlspecialchars($clase['DuracionMinutos']); ?>" required>
                <label>Precio:</label>
                <input type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($clase['Precio']); ?>" required>
                <label>Materiales:</label>
                <textarea name="materiales" rows="3"><?php echo htmlspecialchars($clase['Materiales']); ?></textarea>
                <label>Categoría:</label>
                <select name="categoria" required>
                    <option value="Arte para niños" <?php echo $clase['Categoria'] == 'Arte para niños' ? 'selected' : ''; ?>>Arte para niños</option>
                    <option value="Pintura y dibujo para Adultos" <?php echo $clase['Categoria'] == 'Pintura y dibujo para Adultos' ? 'selected' : ''; ?>>Pintura y dibujo para Adultos</option>
                    <option value="Restauración para Adultos" <?php echo $clase['Categoria'] == 'Restauración para Adultos' ? 'selected' : ''; ?>>Restauración para Adultos</option>
                </select>
                <label>Cupo Máximo:</label>
                <input type="number" name="cupo_maximo" value="<?php echo htmlspecialchars($clase['CupoMaximo']); ?>" required>
                <label>Plazas Reservadas:</label>
                <input type="number" name="plazas_reservadas" value="<?php echo htmlspecialchars($clase['PlazasReservadas']); ?>" required>
                <input type="hidden" name="accion" value="actualizar">
                <button type="submit">Actualizar</button>
            </form>
            <form method="post">
                <input type="hidden" name="clase_id" value="<?php echo $clase['ClaseID']; ?>">
                <input type="hidden" name="accion" value="eliminar">
                <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar esta clase?');">Eliminar</button>
            </form>
        </div>
        <hr>
    <?php endforeach; ?>
</div>
<?php include 'footer.php'; ?>

</body>
</html>
