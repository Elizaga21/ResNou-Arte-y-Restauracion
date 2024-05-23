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
                </div>
                <div class="header__nav__content">
                    <div class="nav-close-icon"></div>
                    <ul class="header__menu">
                    <?php
      if (isset($_SESSION['user_id'])) {

        if (!empty($_SESSION['nombre'])) {
            echo '<li><strong>Hola, ' . $_SESSION['nombre'] . '</strong></li>';
        } else {
            echo '<li><strong>Hola, [nombre]</strong></li>';
        }
    
        $rolUsuario = $_SESSION['rol'];
    
        switch ($rolUsuario) {
            case 'administrador':
                echo '<li><a href="admin.php">Mantenimiento</a></li>';            
                echo '<li><a href="estadisticas_pedidos.php">Reservas</a></li>';
                echo '<li><a href="ventas.php">Ventas</a></li>';
                echo '<li><a href="perfil.php">Perfil</a></li>';
                break;
            case 'empleado':
              echo '<li><a href="empleado.php">Mantenimiento</a></li>';            
                echo '<li><a href="perfil.php">Perfil</a></li>';
                break;
            case 'cliente':
                echo '<li><a href="mis_pedidos.php">Reservas</a></li>';
                echo '<li><a href="cliente.php">Perfil</a></li>';
              
          echo '</a></li>';
          break;


    
            default:
                break;
        }
    
        echo '<li><a href="cerrar_sesion.php"><strong>Cerrar Sesión</strong></a></li>';
    } else {
       
echo '</a></li>';
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
                    </ul>
                    <div class="header__signup">
                        <a href="login.php" class="btn btn__signup">
                            <i class="fas fa-user-plus"></i> Iniciar Sesión
                        </a>
                    </div>
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

