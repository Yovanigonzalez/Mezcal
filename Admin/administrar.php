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
    <title>Menú</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .container {
            max-width: 960px;
            margin: 0 auto;
        }

        @media (max-width: 767px) {
            .sidebar {
                padding: 10px;
                height: auto;
            }

            .sidebar ul {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                padding: 0;
                margin: 0;
            }

            .sidebar li {
                width: 100%;
                margin-bottom: 10px;
            }

            .content {
                padding: 10px;
            }
        }

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

        .dashboard-item a {
            text-decoration: none;
            color: #fff;
        }

        .dashboard-item i {
            font-size: 48px;
            margin-bottom: 10px;
        }

        .dashboard-item.users {
            background-color: #007bff;
        }

        .dashboard-item.products {
            background-color: #28a745;
        }

        .dashboard-item.edit-products {
            background-color: #ffc107;
        }

        .dashboard-item.add-products {
            background-color: #dc3545;
        }

        .dashboard-item.delete-products {
            background-color: #6f42c1;
        }

        .dashboard-item.inventory {
            background-color: #17a2b8;
        }

        .dashboard-item.sales {
            background-color: #e83e8c;
        }

        .dashboard-item.expenses {
            background-color: #fd7e14;
        }

        .dashboard-item.search-products {
            background-color: #6610f2;
        }

        .dashboard-item.payment-verification {
            background-color: #17a2b8;
        }

        html, body {
            height: 100%;
        }

        .logout-link {
            color: #dc3545;
        }
        
        .dashboard-container {
            margin-top: 50px;
        }
        
                        /* Estilos adicionales para el footer */
footer {
    width: 100%;
    position: relative;
    margin-top: auto;
    background-color: white;
    //padding: 20px 0;
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
        
        <div class="row justify-content-center">
            <div class="col-md-10 content">
                <div class="dashboard-container">
                    <div class="dashboard-item users">
                        <a href="usuarios.php">
                            <i class="fas fa-users"></i>
                            <span>Usuarios</span>
                        </a>
                    </div>
                    <div class="dashboard-item products">
                        <a href="productos.php">
                            <i class="fas fa-box"></i>
                            <span>Productos</span>
                        </a>
                    </div>
                    <div class="dashboard-item edit-products">
                        <a href="editar_productos.php">
                            <i class="fas fa-edit"></i><br>
                            <span>Editar Productos</span>
                        </a>
                    </div>
                    <div class="dashboard-item add-products">
                        <a href="agregar_productos.php">
                            <i class="fas fa-plus"></i><br>
                            <span>Agregar Productos</span>
                        </a>
                    </div>
                    <div class="dashboard-item search-products">
                        <a href="buscar_productos.php">
                            <i class="fas fa-search"></i><br>
                            <span>Buscar Productos</span>
                        </a>
                    </div>
                    <div class="dashboard-item delete-products">
                        <a href="borrar_productos.php">
                            <i class="fas fa-trash"></i><br>
                            <span>Eliminar Productos</span>
                        </a>
                    </div>
                    <div class="dashboard-item inventory">
                        <a href="ventas.php">
                            <i class="fas fa-list"></i><br>
                            <span>Venta</span>
                        </a>
                    </div>
                    <div class="dashboard-item sales">
                        <a href="nota.php">
                            <i class="fas fa-chart-bar"></i><br>
                            <span>Nota</span>
                        </a>
                    </div>
                    <div class="dashboard-item expenses">
                        <a href="venta_mes.php">
                            <i class="fas fa-money-bill"></i><br>
                            <span>Venta Mes</span>
                        </a>
                    </div>
<div class="dashboard-item payment-verification">
    <a href="verificacion_pago.php">
        <i class="fas fa-receipt"></i> <!-- Icono de comprobante de pago -->
        <span>Comprobante de pago</span>
    </a>
</div>

                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
      <footer>
    <div class="footer-bottom">
      &copy; 2023 Todos los derechos reservados | Casa Mezcalera Mixtle
    </div>
  </footer>
  
</body>
</html>
