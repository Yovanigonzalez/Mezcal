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
    <title>Editar Productos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> 
    <style>
        .sidebar {
            float: left;
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
 /*
            .content {
            flex: 1;
            overflow-y: auto; Permitir el desplazamiento vertical
            max-height: 80vh; Altura máxima del contenido 
            margin-bottom: 20px; Espacio inferior para evitar superposición con el footer 
        
        }
        */

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

    // Configurar el conjunto de caracteres
    $mysqli->set_charset("utf8");

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
                        
            <h2>Lista de Productos</h2>
            <p>¡Hola!, aquí podrás editar todos los productos que tienes en existencia.</p>
            <script src="https://kit.fontawesome.com/a076d05399.js"></script>
            <?php
            // Conexión a la base de datos (debes configurarla con tus propios datos)
            $mysqli = new MySQLi("localhost", "mezcalmi_Yovani","1Blancamama", "mezcalmi_mezcal1");

            // Verificar la conexión
            if ($mysqli->connect_errno) {
                echo "Error en la conexión: " . $mysqli->connect_error;
                exit();
            }


            // Función para escapar los caracteres especiales en una cadena
            function escape($value) {
                global $mysqli;
                return $mysqli->real_escape_string($value);
            }

            // Función para mostrar un mensaje de éxito o error
            function showMessage($message, $isError = false) {
                $class = $isError ? 'alert-danger' : 'alert-success';
                echo "<div class='alert $class'>$message</div>";
            }

            // Función para subir una imagen al servidor
            function uploadImage($file) {
                $targetDirectory = 'uploads/';
                $targetFile = $targetDirectory . basename($file['name']);
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Verificar si el archivo es una imagen válida
                $check = getimagesize($file['tmp_name']);
                if ($check === false) {
                    return false;
                }

                // Verificar el tamaño máximo del archivo (opcional)
                $maxFileSize = 5 * 1024 * 1024; // 5MB
                if ($file['size'] > $maxFileSize) {
                    return false;
                }

                // Mover el archivo al directorio de destino
                if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                    return $targetFile;
                } else {
                    return false;
                }
            }

            // Obtener todos los productos de la base de datos
            $sql = "SELECT * FROM productos";
            $result = $mysqli->query($sql);

            // Verificar si se envió el formulario de edición
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit"])) {
                // Obtener los datos del formulario
                $id = $_POST["id"];
                $nombre = escape($_POST["nombre"]);
                $descripcion = escape($_POST["descripcion"]);
                $precio = escape($_POST["precio"]);
                $stock = escape($_POST["stock"]);
                $imagen = '';

                // Verificar si se subió una nueva imagen
                if ($_FILES["imagen"]["name"]) {
                    $uploadedImage = uploadImage($_FILES["imagen"]);
                    if ($uploadedImage) {
                        $imagen = $uploadedImage;
                    } else {
                        showMessage("Error al subir la imagen.", true);
                    }
                }

                // Actualizar el producto en la base de datos
                $sql = "UPDATE productos SET nombre = '$nombre', descripcion = '$descripcion', precio = '$precio', stock = '$stock'";
                if ($imagen) {
                    $sql .= ", imagen = '$imagen'";
                }
                $sql .= " WHERE id = '$id'";

                if ($mysqli->query($sql) === true) {
                    showMessage("Producto actualizado correctamente.");
                } else {
                    showMessage("Error al actualizar el producto: " . $mysqli->error, true);
                }
            }

            // Verificar si se envió el formulario de eliminación
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
                // Obtener el ID del producto a eliminar
                $id = $_POST["id"];

                // Eliminar el producto de la base de datos
                $sql = "DELETE FROM productos WHERE id = '$id'";
                if ($mysqli->query($sql) === true) {
                    showMessage("Producto eliminado correctamente.");
                } else {
                    showMessage("Error al eliminar el producto: " . $mysqli->error, true);
                }
            }
            ?>

            <div class="container">
                <h2>Editar Productos</h2>

                <?php
                // Mostrar mensajes de éxito o error
                if (isset($_POST["edit"]) || isset($_POST["delete"])) {
                    echo "<hr>";
                }
                ?>

<table class="table">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Mostrar los productos en la tabla
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["nombre"] . "</td>";
                            echo "<td>" . $row["descripcion"] . "</td>";
                            echo "<td>$" . $row['precio'] . "</td>";
                            echo "<td>" . $row["stock"] . "</td>";
                            echo "<td><img src='../mezcal/" . $row["imagen"] . "' height='50'></td>";
                            echo "<td>";
                            echo "<a href='editar.php?id=" . $row["id"] . "' class='btn btn-primary'>Editar</a> ";
                            echo "<form method='post' style='display: inline-block;'>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <?php
                // Mostrar el formulario de edición si se proporcionó un ID válido en la URL
                if (isset($_GET["id"])) {
                    $id = $_GET["id"];

                    // Obtener los datos del producto
                    $sql = "SELECT * FROM productos WHERE id = '$id'";
                    $result = $mysqli->query($sql);
                    $row = $result->fetch_assoc();

                    // Mostrar el formulario de edición
                    ?>

                    <h3>Editar Producto</h3>
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                        <div class="form-group">
                            <label>Nombre:</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $row["nombre"]; ?>">
                        </div>
                        <div class="form-group">
                            <label>Descripción:</label>
                            <textarea name="descripcion" class="form-control"><?php echo $row["descripcion"]; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Precio:</label>
                            <input type="number" name="precio" class="form-control" value="<?php echo $row["precio"]; ?>">
                        </div>
                        <div class="form-group">
                            <label>Stock:</label>
                            <input type="number" name="stock" class="form-control" value="<?php echo $row["stock"]; ?>">
                        </div>
                        <div class="form-group">
                            <label>Imagen:</label>
                            <input type="file" name="imagen" class="form-control-file">
                        </div>
                        <button type="submit" name="edit" class="btn btn-primary">Guardar cambios</button>
                        <a href="administrar.php" class="btn btn-secondary">Cancelar</a>
                    </form>
                <?php
                }
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
