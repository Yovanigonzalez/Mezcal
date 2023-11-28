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
    <title>Ventas por Mes</title>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    // Obtener los años de ventas disponibles en la base de datos
    $query = "SELECT DISTINCT YEAR(fecha_venta) AS year FROM ventas";
    $result = $mysqli->query($query);

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        $years = array(); // Array para almacenar los años de ventas

        // Recorrer los resultados y guardar los años en el array
        while ($row = $result->fetch_assoc()) {
            $years[] = $row['year'];
        }
    } else {
        echo "<p class='error-message'>No hay datos de ventas.</p>";
    }

    // Obtener el año seleccionado (si se ha enviado por formulario)
    $selectedYear = isset($_GET['year']) ? $_GET['year'] : null;

    // Obtener los datos de ventas por mes para el año seleccionado
    if ($selectedYear) {
        // Consulta SQL para obtener las ventas por mes para el año seleccionado
        $query = "SELECT MONTH(fecha_venta) AS mes, SUM(total) AS total_ventas FROM ventas WHERE YEAR(fecha_venta) = $selectedYear GROUP BY MONTH(fecha_venta)";
        $result = $mysqli->query($query);

        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            // Crear arrays para almacenar los datos de los meses y las ventas
            $meses = array();
            $ventas = array();
            $totales = array();

            // Recorrer los resultados y guardar los datos en los arrays
            while ($row = $result->fetch_assoc()) {
                $mes = obtenerNombreMes($row['mes']); // Obtener el nombre del mes
                $totalVentas = $row['total_ventas']; // Obtener el total de ventas del mes
                $meses[] = $mes;
                $ventas[] = $totalVentas;
                $totales[] = number_format($totalVentas, 2, '.', ','); // Agregar la separación de cifras al total
            }
        } else {
            echo "<p class='info-message'>No hubo ventas en el año seleccionado.</p>";
        }
    }

    // Función para obtener el nombre del mes a partir del número
    function obtenerNombreMes($numeroMes) {
        $meses = array(
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        );

        // Verificar si el número de mes está dentro del rango válido
        if (isset($meses[$numeroMes])) {
            return $meses[$numeroMes];
        } else {
            return 'Mes inválido';
        }
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

            <div class="col-md-10">
                <br>
                <br>
                <br>
                <h1>Gráfica de Ventas por Mes</h1>

                <form action="" method="get">
                    <label for="year">Selecciona un año:</label>
                    <select name="year" id="year">
    <?php foreach ($years as $year): ?>
        <?php if ($year != 0): ?> <!-- Agregar esta línea -->
            <option value="<?php echo $year; ?>" <?php if ($selectedYear == $year) echo 'selected'; ?>><?php echo $year; ?></option>
        <?php endif; ?> <!-- Agregar esta línea -->
    <?php endforeach; ?>
</select>

                    <button type="submit" class="ver-ventas-button">Ver ventas</button>
                </form>

                <?php if ($selectedYear && isset($meses) && isset($ventas)): ?>
                    <canvas id="ventasChart" width="400" height="200"></canvas>

                    <script>
                        // Obtener los datos de PHP
                        var meses = <?php echo json_encode($meses); ?>;
                        var ventas = <?php echo json_encode($ventas); ?>;
                        var totales = <?php echo json_encode($totales); ?>; // Array de totales de ventas con separación de cifras

                        // Crear la gráfica
                        var ctx = document.getElementById('ventasChart').getContext('2d');
                        var ventasChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: meses,
                                datasets: [{
                                    label: 'Ventas por Mes',
                                    data: ventas,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            // Agregar el total de ventas en la etiqueta del mes con separación de cifras
                                            label: function (context) {
                                                var label = context.dataset.label || '';
                                                if (label) {
                                                    label += ': ';
                                                }
                                                label += context.parsed.y;
                                                return label + ' (Total: $' + totales[context.dataIndex] + ')';
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    </script>
                <?php endif; ?>
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
