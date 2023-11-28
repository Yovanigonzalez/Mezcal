<?php
include 'conexion.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validar que se hayan ingresado los campos requeridos
    if (empty($username) || empty($password)) {
        $error = "Por favor, ingresa tu correo electrónico y contraseña.";
    } else {
        // Verificar si el correo electrónico existe en la base de datos
        $sql = "SELECT * FROM usuarios WHERE email = '$username'";
        $result = $mysqli->query($sql);

        if ($result && $result->num_rows > 0) {
            // El correo electrónico existe, verificar las credenciales
            $row = $result->fetch_assoc();

            if ($row['password'] === $password) {
                // Las credenciales son correctas, verificar el rol del usuario
                $rol = $row['rol'];
                if ($rol === 'administrador' || $rol === 'usuario') {
                    // Inicio de sesión exitoso como administrador o usuario
                    session_start();
                    $_SESSION['rol'] = $rol;
                    $_SESSION['name'] = $row['name']; // Configurar el nombre del usuario

                    // Redirigir al panel correspondiente
                    if ($rol === 'administrador') {
                        header('Location: Admin/admin_panel.php');
                    } else {
                        header('Location: user/bebida.php');
                    }
                    exit();
                } else {
                    // Rol desconocido, mostrar mensaje de error
                    $error = "No se puede identificar el rol del usuario.";
                }
            } else {
                // Contraseña incorrecta, mostrar mensaje de error
                $error = "Contraseña incorrecta.";
            }
        } else {
            // El correo electrónico no existe, mostrar mensaje de error
            $error = "El correo electrónico no existe en la base de datos.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inicio de sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css">

    <style>
        body {
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        .login-form-container {
            max-width: 500px; /* Tamaño máximo en la computadora */
            width: 100%;
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-form .form-group {
            margin-bottom: 20px;
        }

        .login-form label {
            font-weight: bold;
        }

        .login-form .btn-block {
            margin-top: 20px;
        }

        .login-form p {
            text-align: center;
            margin-top: 20px;
        }

        .login-form p a {
            color: #007bff;
            text-decoration: none;
        }

        .login-form img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        /* Estilos responsivos para dispositivos móviles */
        @media (max-width: 767.98px) {
            .login-container {
                padding: 10px;
            }

            .login-form-container {
                max-width: 100%; /* Tamaño máximo en dispositivos móviles */
            }

            .login-form img {
                display: none; /* Ocultar la imagen en dispositivos móviles */
            }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <img src="imagen/L.jpg" alt="Imagen" class="img-fluid d-md-block" style="border-radius: 10px;">
        </div>
        <div class="col-md-6">
            <div class="login-container">
                <div class="login-form-container">
                    <div class="login-form">
                        <h2> Iniciar sesión</h2>
                        <?php if (!empty($error)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php } ?>
                        
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            
                            <div class="form-group">
                                <label for="username"><span class="oi oi-envelope-closed"></span> Correo electrónico:</label>
                                <input type="text" class="form-control" id="username" name="username" required placeholder="Ejemplo: ejemplo@gmail.com">
                            </div>
                            
                            <div class="form-group">
                                <label for="password"><span class="oi oi-key"></span> Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Contraseña que tienes registadro en la pagina web">
                            </div>
                            
                            
                            <button type="submit" class="btn btn-primary btn-block"><span class="oi oi-account-login"></span> Iniciar sesión</button>
                            
                            <a href="index.php" class="btn btn-primary btn-block"><span class="oi oi-arrow-left"></span> Regresar</a>
 
                        </form>
                        <p>¿No tienes una cuenta? <a href="registro.php">Regístrate</a></p>
                        <p><a href="recuperar.php">¿Olvidaste tu contraseña?</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

