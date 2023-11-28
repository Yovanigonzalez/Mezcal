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
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>    
   
        .container-fluid, .row, .sidebar {
            height: 100%;
        }

        .sidebar {
            background-color: #333;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            height: 100vh
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

        html, body {
            height: 100%;
        }

        .product-container {
            margin: 20px auto;
            max-width: 1000px;
            overflow-x: auto;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
        }

        .product-table th, .product-table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .product-table th {
            background-color: #f2f2f2;
        }

        .product-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .product-table tr:hover {
            background-color: #ddd;
        }

        .edit-button {
            display: inline-block;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
        }

        .delete-button {
            display: inline-block;
            padding: 5px 10px;
            background-color: #f44336;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            margin-left: 5px;
        }

        .logout-link {
            color: #dc3545;
        }

        .pagination-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            list-style: none;
        }

        .pagination li {
            margin-right: 5px;
        }

        .pagination li a {
            padding: 5px 10px;
            text-decoration: none;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
        }

        .pagination li.active a {
            background-color: #4CAF50;
            color: #fff;
        }

        img {
            width: 100px;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .content {
                margin-top: 20px;
            }
            .product-container {
                margin-bottom: 20px;
            }
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
    $mysqli = new MySQLi("localhost", "mezcalmi_Yovani","1Blancamama", "mezcalmi_mezcal1");

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
    }

    // Función para mostrar los productos
    function mostrarProductos($conexion, $inicio, $productosPorPagina) {
        $sql = "SELECT * FROM productos LIMIT $inicio, $productosPorPagina";
        $result = $conexion->query($sql);

        if ($result && $result->num_rows > 0) {
            echo "<table class='product-table'>";
            echo "<tr>";
            echo "<th>Nombre</th>";
            echo "<th>Precio</th>";
            echo "<th>Imagen</th>";
            echo "<th>Stock</th>";
            echo "</tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['nombre'] . "</td>";
                echo "<td>$" . $row['precio'] . "</td>";
                echo "<td><img src='../mezcal/" . $row['imagen'] . "' alt='Imagen del producto' width='300'></td>";
                echo "<td>" . $row['stock'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron productos.";
        }
    }

    // Obtener el número total de productos
    $sqlTotalProductos = "SELECT COUNT(*) as total FROM productos";
    $resultadoTotalProductos = $mysqli->query($sqlTotalProductos);
    $filaTotalProductos = $resultadoTotalProductos->fetch_assoc();
    $totalProductos = $filaTotalProductos['total'];

    // Configurar la paginación
    $productosPorPagina = 3;
    $paginasTotales = ceil($totalProductos / $productosPorPagina);
    $paginaActual = isset($_GET['page']) ? $_GET['page'] : 1;
    $inicio = ($paginaActual - 1) * $productosPorPagina;

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

            <div class="col-md-10 content">
                <br>
                <br>
                <h2>Lista de Productos</h2>
                <p>¡Hola!, aquí podrás observar todos los productos que tienes en existencia.</p>
                <!-- Mostrar productos existentes -->
                <div class="product-container">
                    <h3></h3>
                    <?php mostrarProductos($mysqli, $inicio, $productosPorPagina); ?>
                </div>

                <!-- Paginación -->
                <div class="pagination-container">
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $paginasTotales; $i++) { ?>
                            <li class="<?php if ($i == $paginaActual) echo 'active'; ?>"><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<footer>
  <div class="footer-bottom">
    &copy; 2023 Todos los derechos reservados | Casa Mezcalera Mixtle
  </div>
</footer>

</body>
</html>
