<?php

include 'menu.php';

$mensajeEnviado = false;

// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "mezcalmi_Yovani";
$password = "1Blancamama";
$dbname = "mezcalmi_mezcal1";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $numero = $_POST['numero'];
    $direccion = $_POST['direccion'];

    // Verificar si se ha seleccionado un archivo
    if (isset($_FILES['comprobante_pago']) && $_FILES['comprobante_pago']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['comprobante_pago']['tmp_name'];
        $fileName = $_FILES['comprobante_pago']['name'];
        $fileSize = $_FILES['comprobante_pago']['size'];
        $fileType = $_FILES['comprobante_pago']['type'];

        // Guardar el archivo en una ubicación específica
        $targetDir = "../uploads/";
        $targetFilePath = $targetDir . $fileName;

        // Mover el archivo a la ubicación final
        if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
            // Insertar los datos en la base de datos
            $sql = "INSERT INTO comprobantes_pago (nombre, numero, direccion, archivo) VALUES ('$nombre', '$numero', '$direccion', '$targetFilePath')";

            if ($conn->query($sql) === true) {
                $mensajeEnviado = true;
            } else {
                echo "Error al insertar los datos en la base de datos: " . $conn->error;
            }
        } else {
            echo "Error al mover el archivo a la ubicación final.";
        }
    } else {
        echo "Error al subir el archivo.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verificación de Pago</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        
        body {
            background-color: #AEE8E2;
        }
        .contact-box {
            background-color: white;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 20px;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        /* Estilos adicionales para el footer */
footer {
    width: 100%;
    position: relative;
    margin-top: auto;
    background-color: white;
    padding: 20px 0;
    text-align: center;
}

/* Estilos para el contenido del footer */
.footer-content {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: flex-start; /* Cambio en la alineación vertical */
    max-width: 1200px;
    margin: 0 auto;
}

/* Estilos para cada sección del footer */
.footer-section {
    flex: 0 0 100%; /* Cambio en el ancho para ocupar toda la línea en dispositivos móviles */
    margin-bottom: 20px;
    text-align: center;
}

.footer-section h2 {
    color: #333;
    font-size: 18px;
    margin-bottom: 10px;
}

.footer-section p,
.footer-section ul {
    color: #777;
    font-size: 14px;
    line-height: 1.5;
}

.footer-section ul li {
    margin-bottom: 5px;
}

/* Estilos para la imagen */
.footer-section img {
    max-width: 100%;
    height: auto;
}

/* Estilos para los iconos */
.footer-section ul li i {
    margin-right: 5px;
}

/* Estilos para el footer inferior */
.footer-bottom {
    background-color: #f9f9f9;
    color: #777;
    padding: 10px;
}

/* Media query para dispositivos móviles */
@media (min-width: 768px) {
    .footer-section {
        flex: 0 0 33.33%; /* Volver al ancho original en pantallas más grandes */
    }

    .footer-section.image-section {
        order: 2; /* Cambio en el orden para que la imagen aparezca después de la información de "Acerca de" */
    }

    .footer-section.about-section {
        order: 1; /* Cambio en el orden para que la información de "Acerca de" aparezca primero */
    }
}
    </style>
</head>
<body>
    <div class="container">
        <div class="contact-box">
            <h1 align="center">Comprobante de Pago </h1>
            <?php if ($mensajeEnviado): ?>
                <div class="success-message">
                    Gracias por enviar tu comprobante de pago.
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre"><i class="fas fa-user" style="color: blue;"></i> Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ejemplo: Juan Pérez">
                </div>
                <div class="form-group">
                    <label for="numero"><i class="fas fa-phone" style="color: red;"></i> Número de teléfono :</label>
                    <input type="text" class="form-control" id="numero" name="numero" required pattern="[0-9]{10}" maxlength="10"placeholder="Ejemplo: 1234567890" title="Ingresa un número de teléfono válido de 10 dígitos">
                </div>
                <div class="form-group">
                    <label for="direccion"><i class="fas fa-map-marker-alt" style="color: green;"></i> Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" required placeholder="Ejemplo: Calle 123, Ciudad, País">
                </div>
<div class="form-group">
    <label for="comprobante_pago">
        <i class="fas fa-file-invoice" style="color: blue;"></i> Comprobante de Pago:
    </label>
    <input type="file" class="form-control-file" id="comprobante_pago" name="comprobante_pago" required>
</div>

                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>
    
    <br>
    
  <footer>
    <div class="footer-content">
      <div class="footer-section">
        <h2>Acerca de</h2>
        <p align="justify">El mezcal Mixtle es una destilado artesanal hecho a partir del agave mezcalero en la región de Oaxaca, México. Su elaboración se realiza siguiendo métodos tradicionales transmitidos de generación en generación. Con un sabor suave y aromático, el mezcal Mixtle ofrece una experiencia única para los amantes del mezcal.</p>
      </div>
      <div class="footer-section">
        <img src="../imagen/Portada.png" alt="Descripción de la imagen" width="200" height="auto">
      </div>
      <div class="footer-section">
        <h2>Contacto</h2>
        <ul>
          <li><i class="fas fa-phone"></i> <a href="tel:+522212803811">522212803811</a></li>
          <li><i class="fas fa-envelope"></i> <a href="mailto:mezcalmixtle2022@gmail.com">mezcalmixtle2022@gmail.com</a></li>
          <li><i class="fas fa-map-marker-alt"></i> <a href="https://goo.gl/maps/ADhCBYows7FKM9ecA" target="_blank">29 norte sin número, barrio San Sebastián, tecamachalco, Puebla</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; 2023 Mezcal Mixtle. Todos los derechos reservados. | Diseñado por Yovani González Rodríguez 
    </div>
  </footer>

</body>
</html>


<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>
