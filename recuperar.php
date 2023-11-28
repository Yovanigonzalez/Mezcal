<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "mezcalmi_Yovani";
$password = "1Blancamama";
$dbname = "mezcalmi_mezcal1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Inicializar la variable del mensaje
$message = '';

// Validar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correoElectronico = $_POST['correoElectronico'];

    // Validar el formato del correo electrónico
    if (!filter_var($correoElectronico, FILTER_VALIDATE_EMAIL)) {
        $message = "<span style='color: red;'>El formato del correo electrónico no es válido.</span>";
    } else {
        // Escapar caracteres especiales para evitar inyección de SQL
        $correoElectronico = $conn->real_escape_string($correoElectronico);

        // Consultar si el correo electrónico existe en la base de datos
        $sql = "SELECT password FROM usuarios WHERE email = '$correoElectronico'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            // El correo electrónico existe en la base de datos
            $row = $result->fetch_assoc();
            $password = $row['password'];

            // Aquí puedes realizar las acciones correspondientes, como enviar el correo para recuperar la contraseña
            $subject = "Recuperación de contraseña";

            $message = "<html>
            <head>
                <style>
                    /* Estilos CSS para el mensaje de correo */
                    body {
                        font-family: Arial, sans-serif;
                    }
                    
                    .container {
                        width: 500px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #f2f2f2;
                        border-radius: 4px;
                    }
                    
                    h1 {
                        color: #007bff;
                        margin-bottom: 20px;
                    }
                    
                    p {
                        margin-bottom: 10px;
                    }
                    
                    .button {
                        display: inline-block;
                        padding: 10px 20px;
                        background-color: #007bff;
                        color: #fff;
                        text-decoration: none;
                        border-radius: 4px;
                    }
                    
                    .button:hover {
                        background-color: #0056b3;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>Recuperación de Contraseña</h1>
                    <p>Estimado usuario,</p>
                    <p>Hemos recibido una solicitud para recuperar tu contraseña. A continuación, encontrarás la información necesaria:</p>
                    <p>Contraseña: <strong>$password</strong></p>
                    <p>Por favor, utiliza esta contraseña para acceder a tu cuenta.</p>
                    <p>Si no solicitaste recuperar tu contraseña, te recomendamos que cambies tu contraseña de inmediato y tomes las medidas necesarias para proteger tu cuenta.</p>
                    <a class='button' href='https://mezcalera.mezcal-mixtle.mx/login.php'>Iniciar Sesión</a>
                    <p>Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos.</p>
                    <p>Atentamente,</p>
                    <p>El equipo de Casa Mezcalera Mixtle</p>
                </div>
            </body>
            </html>";

            $headers = "From: lic.ulloa92@outlook.es\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            if (mail($correoElectronico, $subject, $message, $headers)) {
                $message = "<span style='color: green;'>Se ha enviado un correo electrónico a $correoElectronico con las instrucciones para recuperar tu contraseña.</span>";
            } else {
                $message = "<span style='color: red;'>No se pudo enviar el correo electrónico.</span>";
            }
        } else {
            // El correo electrónico no existe en la base de datos
            $message = "<span style='color: red;'>El correo electrónico $correoElectronico no está registrado.</span>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recuperar Contraseña</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css">

    <style>
        body {
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            margin: 0 auto;
        }

        .login-form {
            background-color: #f2f2f2;
            padding: 30px;
            border-radius: 4px;
        }

        .login-form h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-form label {
            font-weight: bold;
        }

        .login-form input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .login-form .message {
            margin-top: 20px;
            padding: 10px;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: center;
        }

        .login-form .message p {
            margin: 0;
        }

        .login-form .btn-regresar {
            display: block;
            margin-top: 20px;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        .login-form .btn-regresar:hover {
            background-color: #0056b3;
        }

        .login-image-container {
            width: 100%;
            max-width: 400px;
            margin-right: 20px;
        }

        .login-image-container img {
            width: 100%;
            height: auto;
        }

        @media (max-width: 767px) {
            .container {
                flex-direction: column;
            }

            .login-image-container {
                margin-bottom: 20px;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="login-image-container">
            <img src="imagen/L.jpg" alt="Imagen" class="img-fluid d-md-block" style="border-radius: 10px;">
    </div>
    <div class="login-container">
        <div class="login-form">
            <h1>Recuperar Contraseña</h1>
            <?php if (!empty($message)) { ?>
                <div class="message">
                    <?php echo $message; ?>
                </div>
            <?php } ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="correoElectronico"><span class="oi oi-envelope-closed"></span> Correo electrónico:</label>
                    <input type="email" class="form-control" id="correoElectronico" name="correoElectronico" required placeholder="Inserta tu correo">
                </div>
                <input type="submit" value="Recuperar Contraseña" class="btn btn-primary btn-block">
            </form>
            <br><a href="index.php" class="btn btn-primary btn-block">
  <span class="oi oi-arrow-left"></span> Regresar
</a>

        </div>
    </div>
</div>
</body>
</html>

