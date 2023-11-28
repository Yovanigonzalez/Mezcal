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
    <title>Panel de Administración</title>
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

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        select,
        input[type="number"],
        input[type="datetime-local"],
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        #total {
            font-weight: bold;
        }

        .info-box {
            margin-bottom: 10px;
        }

        .info-box label,
        .info-box input {
            display: block;
            width: 100%;
        }
    </style>
</head>
<body>
<?php
// Conexión a la base de datos (debes configurarla con tus propios datos)
$mysqli = new mysqli('localhost', 'root', '', 'mezcal');

// Verificar la conexión
if ($mysqli->connect_errno) {
    echo "Error en la conexión: " . $mysqli->connect_error;
    exit();
}

// Obtener el nombre del usuario administrador desde la base de datos
$sql = "SELECT name FROM usuarios WHERE id = 1";
$resultado = $mysqli->query($sql);
$row = $resultado->fetch_assoc();
$adminName = $row['name'];

// Obtener la lista de productos desde la base de datos
$sql = "SELECT id, nombre, precio FROM productos";
$resultProductos = $mysqli->query($sql);

// Procesar el formulario de venta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar los datos recibidos
    $cliente = $_POST["cliente"];
    $fecha = $_POST["fecha"];
    $productos = $_POST["producto"];
    $cantidades = $_POST["cantidad"];

    // Calcular el total de la venta
    $total = 0;

    // Crear la tabla de ventas si no existe
    $sql = "CREATE TABLE IF NOT EXISTS ventas (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                cliente VARCHAR(255) NOT NULL,
                fecha DATETIME NOT NULL,
                total DECIMAL(10,2) NOT NULL
            )";
    $mysqli->query($sql);

    // Insertar la venta en la tabla de ventas
    $sql = "INSERT INTO ventas (cliente, fecha, total) VALUES ('$cliente', '$fecha', 0)";
    $mysqli->query($sql);

    // Obtener el ID de la venta insertada
    $ventaId = $mysqli->insert_id;

    // Crear la tabla de productos_vendidos si no existe
    $sql = "CREATE TABLE IF NOT EXISTS productos_vendidos (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                venta_id INT(6) UNSIGNED NOT NULL,
                producto_id INT(6) UNSIGNED NOT NULL,
                cantidad INT(6) UNSIGNED NOT NULL,
                precio DECIMAL(10,2) NOT NULL,
                FOREIGN KEY (venta_id) REFERENCES ventas(id),
                FOREIGN KEY (producto_id) REFERENCES productos(id)
            )";
    $mysqli->query($sql);

    // Insertar los productos vendidos en la tabla de productos_vendidos
    for ($i = 0; $i < count($productos); $i++) {
        $productoId = $productos[$i];
        $cantidad = $cantidades[$i];

        // Obtener el precio del producto
        $sql = "SELECT precio FROM productos WHERE id = $productoId";
        $resultado = $mysqli->query($sql);
        $row = $resultado->fetch_assoc();
        $precio = $row['precio'];

        // Calcular el subtotal del producto
        $subtotal = $precio * $cantidad;

        // Actualizar el total de la venta
        $total += $subtotal;

        // Insertar el producto vendido en la tabla de productos_vendidos
        $sql = "INSERT INTO productos_vendidos (venta_id, producto_id, cantidad, precio) VALUES ($ventaId, $productoId, $cantidad, $subtotal)";
        $mysqli->query($sql);
    }

    // Actualizar el total de la venta en la tabla de ventas
    $sql = "UPDATE ventas SET total = $total WHERE id = $ventaId";
    $mysqli->query($sql);

    // Redireccionar a la página de ventas
    header("Location: ventas.php");
    exit();
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="sidebar col-md-2">
            <div class="logo">
                <h2>Admin Panel</h2>
            </div>
            <ul>
                <li><a href="#"><i class="fas fa-chart-line"></i><span>Estadísticas</span></a></li>
                <li><a href="#"><i class="fas fa-shopping-cart"></i><span>Ventas</span></a></li>
                <li><a href="#"><i class="fas fa-cog"></i><span>Configuración</span></a></li>
                <li><a href="#"><i class="fas fa-sign-out-alt"></i><span class="logout-link">Cerrar sesión</span></a></li>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="container">
                <h2>Nueva Venta</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="cliente">Cliente:</label>
                        <input type="text" id="cliente" name="cliente" required>
                    </div>

                    <div class="productos-wrapper">
                        <div class="producto">
                            <div class="form-group">
                                <label for="producto">Producto:</label>
                                <select class="producto-select" name="producto[]" required>
                                    <?php
                                    if ($resultProductos && $resultProductos->num_rows > 0) {
                                        while ($row = $resultProductos->fetch_assoc()) {
                                            echo '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cantidad">Cantidad:</label>
                                <input type="number" class="cantidad-input" name="cantidad[]" min="1" required>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="agregar-producto">Agregar producto</button>

                    <div class="form-group">
                        <label for="fecha">Fecha de venta:</label>
                        <input type="datetime-local" id="fecha" name="fecha" required>
                    </div>
                    <input type="submit" value="Realizar venta">
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        // Agregar producto
        $('#agregar-producto').click(function() {
            var productoHtml = `
                <div class="producto">
                    <div class="form-group">
                        <label for="producto">Producto:</label>
                        <select class="producto-select" name="producto[]" required>
                            <?php
                            if ($resultProductos && $resultProductos->num_rows > 0) {
                                $resultProductos->data_seek(0);
                                while ($row = $resultProductos->fetch_assoc()) {
                                    echo '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" class="cantidad-input" name="cantidad[]" min="1" required>
                    </div>
                    <button type="button" class="eliminar-producto">Eliminar</button>
                </div>
            `;

            $('.productos-wrapper').append(productoHtml);
        });

        // Eliminar producto
        $(document).on('click', '.eliminar-producto', function() {
            $(this).closest('.producto').remove();
        });
    });
</script>
</body>
</html>
