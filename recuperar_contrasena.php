<?php
require 'db_connection.php';
session_start();

// Función para incluir el encabezado
function incluirEncabezado() {
    include 'header.php';
}

// Función para incluir el pie de página
function incluirPiePagina() {
    include 'footer.php';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se proporcionaron tanto DNI como correo electrónico
    if (isset($_POST['DNI'], $_POST['Email'])) {
        $_SESSION['contrasena_actualizada'] = false;

        $DNI = $_POST['DNI'];
        $Email = $_POST['Email'];

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE dni = ? AND email = ?");
        $stmt->execute([$DNI, $Email]);
        $user = $stmt->fetch();

        if ($user) {
            // Mostrar el formulario para establecer una nueva contraseña
            echo '
            <!DOCTYPE html>
            <html>
            <head>
                <title>Recuperar y Establecer Contraseña</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
                <link rel="stylesheet" href="assets/css/main.css">
                <style>
                /* Estilos CSS */
                body {
                    display: flex;
                    flex-direction: column;
                    min-height: 100vh;
                    margin: 0;
                }
                
                main {
                    flex: 1;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
                
                .password-recovery {
                    max-width: 40rem;
                    width: 100%;
                    padding: 2rem;
                    border-radius: 1rem;
                    background-color: #f7f7f7;
                    box-shadow: 0 0 1rem rgba(0, 0, 0, 0.1);
                }
        
                .password-recovery__title {
                    font-size: 2.4rem;
                    margin-bottom: 2rem;
                }
        
                .password-recovery__input {
                    width: 100%;
                    padding: 1rem;
                    margin-bottom: 1.5rem;
                    border: 1px solid #ccc;
                    border-radius: 0.5rem;
                    font-size: 1.6rem;
                }
        
                .password-recovery__button {
                    width: 100%;
                    padding: 1rem;
                    border: none;
                    border-radius: 0.5rem;
                    background-color: #66BB6A;
                    color: #fff;
                    font-size: 1.6rem;
                    cursor: pointer;
                    transition: background-color 0.3s ease;
                }
        
                .password-recovery__button:hover {
                    background-color: #5a9c5a;
                }
            </style>
            </head>
            <body>';
            incluirEncabezado();
            echo '
            <main>
            <form class="password-recovery" method="POST" onsubmit="mostrarMensaje()">
            <h2 class="password-recovery__title">Recuperar y Establecer Contraseña</h2>
            <input type="hidden" name="id" value="' . $user['id'] . '">
            <input type="password" class="password-recovery__input" name="nueva_contrasena" placeholder="Nueva Contraseña">
            <button type="submit" class="password-recovery__button" name="guardar_contraseña">Guardar Nueva Contraseña</button>
            </form>
            </main>';
            incluirPiePagina();
            echo '
            </body>
            </html>';

        } else {
            echo 'La combinación de DNI y correo electrónico no es válida.';
        }
    } elseif (isset($_POST['guardar_contraseña'])) {
        // Procesar el formulario para establecer una nueva contraseña

        $id = $_POST['id'];
        $nueva_contrasena = password_hash($_POST['nueva_contrasena'], PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE usuarios SET contrasena = ? WHERE id = ?");
        $stmt->execute([$nueva_contrasena, $id]);

        session_write_close();

        // Redirigir a login.php después de actualizar la contraseña
        header("Location: login.php");
    } else {
        echo 'Por favor, proporciona tanto el DNI como el correo electrónico.';
    }
} else {
    // Mostrar el formulario para solicitar DNI y correo electrónico
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Recuperar Contraseña</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
        <link rel="stylesheet" href="assets/css/main.css">
        <style>
        /* Estilos CSS */
        .password-recovery {
            max-width: 40rem;
            margin: auto;
            padding: 2rem;
            border-radius: 1rem;
            background-color: #f7f7f7;
            box-shadow: 0 0 1rem rgba(0, 0, 0, 0.1);
        }

        .password-recovery__title {
            font-size: 2.4rem;
            margin-bottom: 2rem;
        }

        .password-recovery__input {
            width: 100%;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid #ccc;
            border-radius: 0.5rem;
            font-size: 1.6rem;
        }

        .password-recovery__button {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 0.5rem;
            background-color: #66BB6A;
            color: #fff;
            font-size: 1.6rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .password-recovery__button:hover {
            background-color: #5a9c5a;
        }
    </style>
    </head>
    <body>';
    incluirEncabezado();
    echo '
    <form class="password-recovery" method="POST">
    <h2 class="password-recovery__title">Recuperar Contraseña</h2>
    <input type="text" name="DNI" class="password-recovery__input" placeholder="DNI" required>
    <input type="email" name="Email" class="password-recovery__input" placeholder="Correo Electrónico" required>
    <button type="submit" class="password-recovery__button">Recuperar Contraseña</button>
  </form>';
    incluirPiePagina();
    echo '
    </body>
    </html>';
}

session_write_close();

?>
