<!DOCTYPE html>
<html>
<head>
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
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

    // ...

    // Cerrar la conexión
    $mysqli->close();
    ?>

<div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
                <div class="logo">
                    <img src="../imagen/mezcal1.png" alt="Logo" width="100">
                </div>
                <ul class="nav flex-column">
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
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Cerrar sesión</span>
                        </a>
                    </li>
                </ul>
            </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
