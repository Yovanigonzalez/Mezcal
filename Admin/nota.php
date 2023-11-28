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
    <title>Generar Nota de Remisión</title>
    <link rel="stylesheet" href="../css/nota.css">

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

.logout-link {
    color: #dc3545;
}

.error-message {
    color: red;
}

.info-message {
    color: blue;
}


.ver-ventas-button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    border-color: #007bff;
    border: 1px solid transparent;
    border-radius: 5px;
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

        input[type="submit"] {
    padding: 5px 10px;
    background-color: #007bff; /* Cambiar el color de fondo a azul */
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
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
        echo "<p class='error-message'>Error en la conexión: " . $mysqli->connect_error . "</p>";
        exit();
    }

    // Obtener el nombre del usuario administrador desde la base de datos
    $sql = "SELECT name FROM usuarios WHERE rol = 'administrador' LIMIT 1";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
    }

    // Procesar formulario de búsqueda
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombreCliente = $_POST["nombreCliente"];

        // Obtener productos comprados por el cliente
        $queryProductosCliente = "SELECT ventas.*, productos.nombre AS nombre_producto
                                  FROM ventas
                                  INNER JOIN productos ON ventas.producto_id = productos.id
                                  WHERE ventas.cliente = '$nombreCliente'";
        $resultProductosCliente = $mysqli->query($queryProductosCliente);
    }
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
       <br>
                <h2>Generar Nota de Remisión</h2>
                <br>
                <form method="POST" action="">
                    <label for="nombreCliente">Nombre del Cliente:</label>
                    <input type="text" name="nombreCliente" required><br><br>

                    <input type="submit" value="Buscar"  style="background-color: #007bff; border-radius: 5px">
                    <br>
                </form>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if ($resultProductosCliente && $resultProductosCliente->num_rows > 0) {
                        // Obtener la fecha y hora actual
                        $fechaHoraActual = date('Y-m-d H:i:s');
                        $fechaActual = date('Y-m-d');
                        $horaActual = date('H:i:s');

                        echo "<br>";
                        echo "<h3>Productos comprados por el cliente '$nombreCliente':</h3>";
                        echo "<div class='table-container'>";
                        echo "<table>";
                        echo "<br>";
                        echo "<tr>
                                <th colspan='2' class='logo-container'><img src='../imagen/Portada.png' alt='Logotipo' class='logo'></th>
                                <th colspan='2'>Nombre del Cliente: $nombreCliente</th>
                              </tr>";
                        echo "<tr>
                                <th colspan='2'>Fecha: $fechaActual</th>
                                <th colspan='2'>Hora: $horaActual</th>
                              </tr>";
                        echo "<tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                              </tr>";

                        $totalVenta = 0;
                        $rowCount = 0;

                        while ($row = $resultProductosCliente->fetch_assoc()) {
                            $nombreProducto = $row['nombre_producto'];
                            $precioProducto = "$" . $row['precio'];
                            $cantidadProducto = $row['cantidad'];
                            $subtotalProducto = $row['total'];

                            $rowClass = ($rowCount % 2 == 0) ? 'even' : 'odd';
                            $rowCount++;

                            echo "<tr class='$rowClass'>
                            <td>$nombreProducto</td>
                            <td>$precioProducto</td>
                            <td>$cantidadProducto</td>
                            <td>$$subtotalProducto</td>
                        </tr>";
                        
                        $totalVenta += $subtotalProducto;
                        
                        }

                        echo "<tr>
                            <th colspan='3'>Total de la venta:</th>
                            <td>$" . number_format($totalVenta, 2) . "</td>
                        </tr>";

                    
                        echo "</table>";

                        echo "<div class='watermark'>
                                <img src='../imagen/Portada.png' alt='Marca de Agua' class='watermark-image'>
                                <p align='center' class='watermark-text'>PAGADO</p>
                              </div>";

                        echo "</div>";
                        
                        echo "<input type='submit' value='Imprimir Nota' class='print-button' onclick='printTable()'>";
                    } else {
                        echo "<p class='error-message'>No se encontraron productos comprados por el cliente '$nombreCliente'.</p>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script>
    
        function printTable() {
            var printContents = document.querySelector('.table-container').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
    
                <footer>
  <div class="footer-bottom">
    &copy; 2023 Todos los derechos reservados | Casa Mezcalera Mixtle
  </div>
</footer>
    
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
$mysqli->close();
?>
