<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'db_connection.php'; 

// Definir la función obtenerNombreDeUsuario si no está definida
if (!function_exists('obtenerNombreDeUsuario')) {
    function obtenerNombreDeUsuario() {
        global $pdo;

        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            $stmt = $pdo->prepare("SELECT nombre FROM usuarios WHERE id = ?");
            $stmt->execute([$user_id]);
            $result = $stmt->fetch();

            if ($result) {
                $_SESSION['nombre'] = $result['nombre'];
                return $result['nombre'];
            }
        }
    }
}

// Si $_SESSION['nombre'] no está definido, intenta obtenerlo
if (!isset($_SESSION['nombre'])) {
    $_SESSION['nombre'] = obtenerNombreDeUsuario();
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
<link rel="stylesheet" href="assets/css/main.css">
<header>
    <nav class="header__nav w-120">
        <div class="header__logo">
            <a href="index.php">
                <img src="assets/img/LogoRESNOUverdeC.png" alt="Logo">
            </a>
        </div>
        <div class="header__nav__content">
            <div class="nav-close-icon"></div>
            <ul class="header__menu">
                <?php
                if (isset($_SESSION['user_id'])) {
                    if (!empty($_SESSION['nombre'])) {
                        echo '<li><strong>Hola, ' . htmlspecialchars($_SESSION['nombre']) . '</strong></li>';
                    } else {
                        echo '<li><strong>Hola, [nombre]</strong></li>';
                    }

                    $rolUsuario = $_SESSION['rol'];

                    switch ($rolUsuario) {
                        case 'administrador':
                            echo '<li class="menu__item"><a href="admin.php" class="menu__link">Mantenimiento</a></li>';            
                            echo '<li class="menu__item"><a href="estadisticas_pedidos.php" class="menu__link">Reservas</a></li>';
                            echo '<li class="menu__item"><a href="ventas.php" class="menu__link">Ventas</a></li>';
                            echo '<li class="menu__item"><a href="perfil.php" class="menu__link">Perfil</a></li>';
                            break;
                        case 'empleado':
                            echo '<li class="menu__item"><a href="empleado.php" class="menu__link">Mantenimiento</a></li>';            
                            echo '<li class="menu__item"><a href="perfil.php" class="menu__link">Perfil</a></li>';
                            break;
                        case 'cliente':
                            echo '<li class="menu__item"><a href="mis_reservas.php" class="menu__link">Reservas</a></li>';
                            echo '<li class="menu__item"><a href="cliente.php" class="menu__link">Perfil</a></li>';
                            break;
                        default:
                            break;
                    }
                }
                ?>
                <li class="menu__item">
                    <a href="index.php" class="menu__link active">Home</a>
                </li>
                <li class="menu__item">
                    <a href="clases.php" class="menu__link">Clases</a>
                </li>
                <li class="menu__item">
                    <a href="servicios.php" class="menu__link">Servicios</a>
                </li>
                <li class="menu__item">
                    <a href="galeria.php" class="menu__link">Galería</a>
                </li>
                <li class="menu__item">
                    <a href="contacto.php" class="menu__link">Contacto</a>
                </li>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<li class="menu__item"><a href="cerrar_sesion.php" class="menu__link"><strong>Cerrar Sesión</strong></a></li>';
                } else {
                    echo '  <div class="header__signup">
                    <a href="login.php" class="btn btn__signup">
                        <i class="fas fa-user-plus"></i> Iniciar Sesión
                    </a>
                </div>
            </div>';
                }
                ?>
            </ul>
        </div>
        <div class="hamburger-menu-wrap">
            <div class="hamburger-menu">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </div>
    </nav>
</header>
