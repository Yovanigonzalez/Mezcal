<?php

session_start();

if (empty($_SERVER['HTTP_REFERER'])) {
    // El acceso se está realizando directamente desde la URL
    header('Location: error.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Búsqueda de Productos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .sidebar {
            background-color: #333;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
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
        .logout-link {
            color: #dc3545;
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
    <?php
    // Conexión a la base de datos (debes configurarla con tus propios datos)
    $mysqli = new mysqli("localhost", "mezcalmi_Yovani","1Blancamama", "mezcalmi_mezcal1");

    // Verificar la conexión
    if ($mysqli->connect_errno) {
        echo "Error en la conexión: " . $mysqli->connect_error;
        exit();
    }

    // Obtener el nombre del usuario administrador desde la base de datos
    $sql = "SELECT name FROM usuarios WHERE rol = 'administrador' LIMIT 1";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
    } else {
        $name = "Administrador"; // Nombre predeterminado si no se encuentra en la base de datos
    }

    // ...

    // Cerrar la conexión
    $mysqli->close();
    ?>

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
        <br>
            <div class="col-md-10 content">
                <h1>Búsqueda de Productos</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre del Producto:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>

                <?php
                // Conexión a la base de datos
                $servername = "localhost";
                $username = "mezcalmi_Yovani";
                $password = "1Blancamama";
                $dbname = "mezcalmi_mezcal1";

                // Conexión a la base de datos
                $mysqli = new mysqli($servername, $username, $password, $dbname);

                // Verificar la conexión
                if ($mysqli->connect_errno) {
                    echo "Error en la conexión: " . $mysqli->connect_error;
                    exit();
                }

                // Función para mostrar un mensaje de éxito o error
                function showMessage($message, $isError = false)
                {
                    $class = $isError ? 'alert-danger' : 'alert-success';
                    echo "<div class='alert $class'>$message</div>";
                }

                // Función para buscar productos por nombre
                function buscarProductos($conexion, $nombre)
                {
                    $sql = "SELECT nombre, imagen, descripcion, precio, stock FROM productos WHERE nombre LIKE '%$nombre%'";
                    $result = $conexion->query($sql);

                    if ($result && $result->num_rows > 0) {
                        echo "<br><h2>Resultados de la búsqueda:</h2>";
                        echo "<div class='table-responsive'>";
                        echo "<table class='table'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Nombre</th>";
                        echo "<th>Imagen</th>";
                        echo "<th>Descripción</th>";
                        echo "<th>Precio</th>";
                        echo "<th>Stock</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        while ($row = $result->fetch_assoc()) {
                            $nombre = $row['nombre'];
                            $imagen = $row['imagen'];
                            $descripcion = $row['descripcion'];
                            $precio = $row['precio'];
                            $stock = $row['stock'];

                            echo "<tr>";
                            echo "<td>$nombre</td>";
                            echo "<td><img src='$imagen' alt='Producto' width='100'></td>";
                            echo "<td>$descripcion</td>";
                            echo "<td>$" . number_format($precio, 2) . "</td>";
                            echo "<td>$stock</td>";
                            echo "</tr>";
                        }

                        echo "</tbody>";
                        echo "</table>";
                        echo "</div>";

} else {
    echo "<br>";
    echo "<div class='alert alert-danger'>No se encontraron productos.</div>";
}
                }

                // Verificar si se ha enviado el formulario de búsqueda
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $nombre = $_POST["nombre"];

                    buscarProductos($mysqli, $nombre);
                }

                // Cerrar la conexión
                $mysqli->close();
                ?>
            </div>
        </div>
    </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
            <footer>
  <div class="footer-bottom">
    &copy; 2023 Todos los derechos reservados | Casa Mezcalera Mixtle
  </div>
</footer>

</body>
</html>

