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
    <title>Usuarios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .content {
            background-color: #fff;
            padding: 20px;
            min-height: 300px;
        }

        .fixed-top {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1030;
        }

        .user-container {
            margin: 20px auto;
            max-width: 800px;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-table th, .user-table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .user-table th {
            background-color: #f2f2f2;
        }

        .user-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .user-table tr:hover {
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

        .delete-button i {
            color: #fff;
        }

        .logout-link {
            color: #dc3545;
        }
        
        @media (max-width: 576px) {
            .user-table {
                font-size: 12px;
                display: block;
                overflow-x: auto;
                white-space: nowrap;
                table-layout: fixed;
            }
            
            .user-table th, .user-table td {
                width: 150px; /* Ajusta el ancho de las celdas según tus necesidades */
            }
        }
        
                    
        /* Estilos adicionales para el footer */
        footer {
            width: 100%;
            position: fixed;
            bottom: 0;
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

// Verificar si se recibió el ID del usuario a eliminar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar el usuario de la base de datos
    $sql = "DELETE FROM usuarios WHERE id = $id";
    $result = $mysqli->query($sql);

    if ($result) {
        showMessage("Usuario eliminado correctamente.", false);
    } else {
        showMessage("Error al eliminar el usuario.", true);
    }
}

// Obtener el nombre del usuario administrador desde la base de datos
$sql = "SELECT name FROM usuarios WHERE rol = 'administrador' LIMIT 1";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
}

// Función para mostrar los usuarios
function mostrarUsuarios($conexion) {
    $sql = "SELECT * FROM usuarios";
    $result = $conexion->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<table class='user-table'>";
        echo "<tr>";
        echo "<th><i class='fas fa-user'></i> Nombre</th>";
        echo "<th><i class='fas fa-envelope'></i> Correo</th>";
        echo "<th><i class='fas fa-phone'></i> Teléfono</th>";
        echo "<th><i class='fas fa-trash'></i> Borrar</th>";
        echo "</tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";
            echo "<td>";
            echo "<a class='delete-button' href='usuarios.php?id=" . $row['id'] . "' onclick='return confirm(\"¿Estás seguro de eliminar este usuario?\")'><i class='fas fa-trash'></i></a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        showMessage("No se encontraron usuarios.", true);
    }
}

// Función para mostrar un mensaje de éxito o error
function showMessage($message, $isError = false) {
    $class = $isError ? 'alert-danger' : 'alert-success';
    echo "<div class='alert-container'>";
    echo "<div class='alert $class'>$message</div>";
    echo "</div>";
}
?>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">Panel de Administración</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon">
            <span class="navbar-toggler-icon-line"></span>
            <span class="navbar-toggler-icon-line"></span>
            <span class="navbar-toggler-icon-line"></span>
        </span>
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

  <div class="container-fluid" style="min-height: calc(100vh - 70px);">
    <div class="row justify-content-center">
      <div class="col-md-10 content">
            <br>
            <br>
            <h2>Usuarios Registrados</h2>
            <div class="user-container">
                <?php mostrarUsuarios($mysqli); ?>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


<footer>
  <div class="footer-bottom">
    &copy; 2023 Todos los derechos reservados | Casa Mezcalera Mixtle
  </div>
</footer>


</body>
</html>
