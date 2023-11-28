<?php
session_start();

if (empty($_SERVER['HTTP_REFERER'])) {
    // El acceso se está realizando directamente desde la URL
    header('Location: error.php');
    exit();
}

// Verificar si se ha enviado el formulario de eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_comprobante'])) {
    // Conexión a la base de datos (debes configurarla con tus propios datos)
    $mysqli = new mysqli("localhost", "mezcalmi_Yovani", "1Blancamama", "mezcalmi_mezcal1");

    // Verificar si la conexión fue exitosa
    if ($mysqli->connect_errno) {
        die("Error de conexión a la base de datos: " . $mysqli->connect_error);
    }

    // Obtener el ID del comprobante a eliminar
    $comprobante_id = $_POST['comprobante_id'];

    // Eliminar el comprobante de la base de datos
    $eliminar = $mysqli->query("DELETE FROM comprobantes_pago WHERE id = $comprobante_id");

    if ($eliminar) {
        // Redirigir a la página actual con un mensaje de éxito
        $_SESSION['mensaje'] = "El comprobante de pago se ha eliminado correctamente.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Mostrar un mensaje de error
        $_SESSION['error'] = "Error al eliminar el comprobante de pago. Inténtalo nuevamente.";
    }

    // Cerrar la conexión a la base de datos
    $mysqli->close();
}

// Conexión a la base de datos (debes configurarla con tus propios datos)
$mysqli = new mysqli("localhost", "mezcalmi_Yovani", "1Blancamama", "mezcalmi_mezcal1");

// Verificar si la conexión fue exitosa
if ($mysqli->connect_errno) {
    die("Error de conexión a la base de datos: " . $mysqli->connect_error);
}

// Obtener el nombre del usuario administrador desde la base de datos
$sql = "SELECT name FROM usuarios WHERE rol = 'administrador' LIMIT 1";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
}

// Obtener los comprobantes de pago de la base de datos
$comprobantes = array();
$resultado = $mysqli->query("SELECT * FROM comprobantes_pago");

// Verificar si se encontraron comprobantes de pago
if ($resultado->num_rows > 0) {
    // Recorrer los resultados y almacenarlos en el array de comprobantes
    while ($row = $resultado->fetch_assoc()) {
        $comprobantes[] = $row;
    }
}

// Cerrar la conexión a la base de datos
$mysqli->close();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Visualizar Comprobantes de Pago</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    h1 {
        text-align: center;
        margin-top: 50px;
    }

    .comprobantes-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }

    .comprobante {
        border: 1px solid #ccc;
        padding: 20px;
        margin: 20px;
        width: 300px; /* Ajusta el ancho según tus necesidades */
        box-sizing: border-box; /* Incluir el relleno y el borde en el ancho total */
    }

    .comprobante h3 {
        margin: 0;
    }

    .comprobante img {
        max-width: 100%;
        margin-top: 10px;
    }

    .comprobante p {
        margin-bottom: 10px;
    }

    .ver-comprobante {
        text-align: center;
        margin-top: 10px;
    }

    .ver-comprobante a {
        display: inline-block;
        padding: 10px 20px;
        background-color: #3498db;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }

    .ver-comprobante a:hover {
        background-color: #2980b9;
    }
    
                        
                /* Estilos adicionales para el footer */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .container {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
        }

        footer {
            flex-shrink: 0;
            width: 100%;
            background-color: white;
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
            background-color: #343a40;
            color: #fff;
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
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="#">Panel de Administración</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_panel.php">
                            <i class="fas fa-user"></i>
                            <span><?php echo "$name"; ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="administrar.php">
                            <i class="fas fa-cogs"></i>
                            <span>Administrar</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-link" href="logout.php">
                            <i class="fas fa-sign-out-alt" style="color: red;"></i>
                            <span style="color: red;">Cerrar sesión</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>


    
    <h1>Comprobantes de Pago</h1>
<div align="center" class="alerta">
    <?php
                // Verificar si hay un mensaje de éxito
            if (isset($_SESSION['mensaje'])) {
                echo '<div class="alert alert-success">' . $_SESSION['mensaje'] . '</div>';
                unset($_SESSION['mensaje']); // Limpiar el mensaje de éxito después de mostrarlo
            }

            // Verificar si hay un mensaje de error
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']); // Limpiar el mensaje de error después de mostrarlo
            }
            ?>
</div>
    <div class="comprobantes-container">
            <?php

            // Verificar si hay comprobantes de pago
            if (!empty($comprobantes)) {
                foreach ($comprobantes as $comprobante) {
                    // Mostrar los detalles de cada comprobante de pago
                    $comprobante_id = $comprobante['id'];
                    $nombre = $comprobante['nombre'];
                    $numero = $comprobante['numero'];
                    $direccion = $comprobante['direccion'];
                    $fecha_creacion = $comprobante['fecha_creacion'];
                    $archivo = $comprobante['archivo']; // Ruta o nombre del archivo de comprobante

                    echo '<div class="comprobante">';
                    echo '<p>Nombre: ' . $nombre . '</p>';
                    echo '<p>Teléfono: ' . $numero . '</p>';
                    echo '<p>Dirección: ' . $direccion . '</p>';
                    echo '<p>Fecha: ' . $fecha_creacion . '</p>';
                    echo '<div class="ver-comprobante">';
                    echo '<a href="' . $archivo . '" target="_blank">Ver Comprobante</a>';

                    // Agregar el formulario de eliminación del comprobante
                    echo '<form method="POST" style="margin-top: 10px;">';
                    echo '<input type="hidden" name="comprobante_id" value="' . $comprobante_id . '">';
                    echo '<button type="submit" name="eliminar_comprobante" class="btn btn-danger btn-sm">Eliminar</button>';
                    echo '</form>';

                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No se encontraron comprobantes de pago.</p>';
            }
            ?>
    </div>
</div>
    
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  
    
                <footer>
  <div class="footer-bottom">
    &copy; 2023 Todos los derechos reservados | Casa Mezcalera Mixtle
  </div>
</footer>
    
</body>
</html>





