<?php

session_start();

if (empty($_SERVER['HTTP_REFERER'])) {
    // El acceso se está realizando directamente desde la URL
    header('Location: error.php');
    exit();
}

// Conexión a la base de datos (debes configurarla con tus propios datos)
$mysqli = new MySQLi("localhost", "mezcalmi_Yovani","1Blancamama", "mezcalmi_mezcal1");

// Verificar la conexión
if ($mysqli->connect_errno) {
    echo "Error en la conexión: " . $mysqli->connect_error;
    exit();
}

// Función para mostrar un mensaje de éxito o error
function showMessage($message, $isError = false) {
    $class = $isError ? 'alert-danger' : 'alert-success';
    echo "<div class='alert $class'>$message</div>";
}

// Obtener el nombre del usuario administrador desde la base de datos
$sql = "SELECT name FROM usuarios WHERE rol = 'administrador' LIMIT 1";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
}

// Función para agregar un producto
function agregarProducto($conexion, $nombre, $imagen, $descripcion, $precio, $stock) {
    // Procesar la imagen (subir y guardar en una carpeta)
    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_tmp = $_FILES['imagen']['tmp_name'];
    $ruta_imagen = '../mezcal/' . $imagen_nombre;
    move_uploaded_file($imagen_tmp, $ruta_imagen);

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO productos (nombre, imagen, descripcion, precio, stock) VALUES ('$nombre', '$ruta_imagen', '$descripcion', $precio, $stock)";
    if ($conexion->query($sql) === TRUE) {
        $GLOBALS['alertMessage'] = "Producto agregado exitosamente.";
        $GLOBALS['alertClass'] = "alert-success";
    } else {
        $GLOBALS['alertMessage'] = "Error al agregar el producto: " . $conexion->error;
        $GLOBALS['alertClass'] = "alert-danger";
    }
}

// Verificar si se ha enviado el formulario de agregar producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $imagen = $_FILES["imagen"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];

    agregarProducto($mysqli, $nombre, $imagen, $descripcion, $precio, $stock);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Agregar Producto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .container-fluid,
        .row,
        .sidebar {
            height: 100%;
        }

        .sidebar {
            background-color: #333;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            width: 100%;
            height: 100vh;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .sidebar a i {
            margin-right: 10px;
            width: 20px;
        }

        .sidebar a span {
            color: #fff;
            flex-grow: 1;
        }

        .sidebar .logo {
            margin-bottom: 20px;
        }

        .content {
            background-color: #fff;
            padding: 20px;
            min-height: 300px;
        }

        .dashboard-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 50px;
        }

        .dashboard-item {
            width: 160px;
            height: 200px;
            margin: 10px;
            padding: 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
        }

        .form-container {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .show-message {
            max-width: calc(100% - 250px);
        }

        ::-webkit-scrollbar {
            width: 0.5em;
        }

        ::-webkit-scrollbar-track {
            background-color: #f8f8f8;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #888;
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
    <br>
        <br>
            <div class="col-md-10 content">
                <?php if (isset($alertMessage) && isset($alertClass)): ?>
                    <div class="alert <?php echo $alertClass; ?> show-message" role="alert">
                        <?php echo $alertMessage; ?>
                    </div>
                <?php endif; ?>


    <h2>Panel de Administración</h2>
    <p>¡Hola, <?php echo $name; ?> Aquí puedes agregar productos.</p>


                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="form-container">
                                <h2>Agregar Producto</h2>
                                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="nombre">Nombre:</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="imagen">Imagen:</label>
                                        <input type="file" class="form-control-file" id="imagen" name="imagen" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcion">Descripción:</label>
                                        <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="precio">Precio:</label>
                                        <input type="number" class="form-control" id="precio" name="precio" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="stock">Stock:</label>
                                        <input type="number" class="form-control" id="stock" name="stock" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Agregar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            let messageDiv = document.querySelector('.show-message');
            if (messageDiv) {
                setTimeout(() => {
                    messageDiv.style.display = 'none';
                }, 3000);
            }
        });
    </script>
    
        <footer>
  <div class="footer-bottom">
    &copy; 2023 Todos los derechos reservados | Casa Mezcalera Mixtle
  </div>
</footer>

</body>
</html>
