<?php
include 'conexion.php';

// Conexión a la base de datos (debes configurarla con tus propios datos)
$mysqli = new MySQLi("localhost", "mezcalmi_Yovani","1Blancamama", "mezcalmi_mezcal1");

// Verificar la conexión
if ($mysqli->connect_errno) {
    echo "Error en la conexión: " . $mysqli->connect_error;
    exit();
}

// Definir variables para los mensajes de error
$name_error = $email_error = $phone_error = $password_error = '';

// Obtener los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Verificar si el correo ya está registrado
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        // El correo ya está registrado, mostrar mensaje de error
        $email_error = "El correo ya está registrado";
    }

    // Verificar que las contraseñas coincidan
    if ($password !== $confirm_password) {
        // Las contraseñas no coinciden, mostrar mensaje de error
        $password_error = "Las contraseñas no coinciden";
    }

    // Encriptar la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el nuevo registro en la base de datos si no hay errores
    if (empty($email_error) && empty($password_error)) {
        $sql = "INSERT INTO usuarios (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$hashed_password')";
        if ($mysqli->query($sql)) {
            // Registro exitoso, mostrar mensaje y redireccionar a la página de inicio de sesión
            $message = "Registrado correctamente";
            header("Location: login.php?message=" . urlencode($message));
            exit();
        } else {
            // Error en la inserción, mostrar mensaje de error
            $error = "Error en el registro";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Crear cuenta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css">
  
  <style>
    body {
      background-color: #fff;
      margin: 0;
      padding: 0;
    }

    .register-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      padding: 20px;
    }

    .register-form-container {
      max-width: 500px; /* Tamaño máximo en la computadora */
      width: 100%;
    }

    .register-form h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .register-form .form-group {
      margin-bottom: 20px;
    }

    .register-form label {
      font-weight: bold;
    }

    .register-form .btn-block {
      margin-top: 20px;
    }

    .register-form p {
      text-align: center;
      margin-top: 20px;
    }

    .register-form p a {
      color: #007bff;
      text-decoration: none;
    }

    .register-form img {
      max-width: 100%;
      height: auto;
    }

    /* Estilos responsivos para dispositivos móviles */
    @media (max-width: 767.98px) {
      .register-container {
        padding: 10px;
      }

      .register-form-container {
        max-width: 100%; /* Tamaño máximo en dispositivos móviles */
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
        <div class="register-container">
          <div class="register-form-container">
            <div class="register-form">
              <h2><span class="oi oi-person"></span> Crear cuenta</h2>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                  <label for="name"><span class="oi oi-person"></span> Nombre:</label>
                  <input type="text" class="form-control" id="name" name="name" required placeholder="Ejemplo: Juan Perez">
                </div>
                <div class="form-group">
                  <label for="email"><span class="oi oi-envelope-closed"></span> Correo Electronico:</label>
                  <input type="email" class="form-control" id="email" name="email" required placeholder="Ejemplo: ejemplo@gmail.com">
                  <?php if (!empty($email_error)) : ?>
                    <span class="text-danger"><?php echo $email_error; ?></span>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label for="phone"><span class="oi oi-phone"></span> Número de Teléfono:</label>
                  <input type="text" class="form-control" id="phone" name="phone" required placeholder="Ejemplo: 1234567890" pattern="[0-9]{10}" maxlength="10" title="Ingresa un número de teléfono válido de 10 dígitos">
                </div>
                <div class="form-group">
                  <label for="password"><span class="oi oi-lock-locked"></span> Contraseña:</label>
                  <input type="password" class="form-control" id="password" name="password" required placeholder="Inserta contraseña para tu registro">
                </div>
                <div class="form-group">
                  <label for="confirm_password"><span class="oi oi-lock-locked"></span> Confirmar contraseña:</label>
                  <input type="password" class="form-control" id="confirm_password" name="confirm_password" required placeholder="Inserta la contraseña nuevamente">
                  <?php if (!empty($password_error)) : ?>
                    <span class="text-danger"><?php echo $password_error; ?></span>
                  <?php endif; ?>
                </div>
<button type="submit" class="btn btn-primary btn-block"><span class="oi oi-account-login"></span> Crear cuenta</button>

              </form>
              <p>¿Ya tienes una cuenta? <a href="login.php">Iniciar sesión</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
