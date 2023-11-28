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
$sql = "SELECT name FROM usuarios WHERE rol = 'administrador' LIMIT 1";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
}

// Obtener lista de productos
$queryProductos = "SELECT * FROM productos";
$resultProductos = $mysqli->query($queryProductos);


// Procesar formulario de ventas
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productoId = $_POST["producto"];
    $cantidad = $_POST["cantidad"];
    $fecha = $_POST["fecha"];

    // Obtener información del producto seleccionado
    $queryProducto = "SELECT * FROM productos WHERE id = '$productoId'";
    $resultProducto = $mysqli->query($queryProducto);
    $row = $resultProducto->fetch_assoc();
    $precio = $row["precio"];
    $stock = $row["stock"];
    $nombreProducto = $row["nombre"];
    $total = $precio * $cantidad;

    // Validar si hay suficiente stock
    if ($cantidad > $stock) {
        echo "Error: No hay suficiente stock disponible.";
    } else {
        // Actualizar el stock del producto
        $stockActualizado = $stock - $cantidad;
        $queryStock = "UPDATE productos SET stock = '$stockActualizado' WHERE id = '$productoId'";
        $mysqli->query($queryStock);

        // Guardar la venta en la base de datos
        $queryVenta = "INSERT INTO ventas (producto_id, producto, precio, fecha_venta, cantidad, total) VALUES ('$productoId', '$nombreProducto', '$precio', '$fecha', '$cantidad', '$total')";
        if ($mysqli->query($queryVenta) === TRUE) {
            // Mensaje de éxito
            echo "Venta registrada exitosamente<br>";
        } else {
            echo "Error al registrar la venta: " . $mysqli->error;
        }
    }
}


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
                        <i class="fas fa-sign-out-alt" style="color: red;"></i>
                        <span style="color: red;">Cerrar sesión</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="col-md-10">
            <div class="container">
                <h2>Registro de Ventas</h2>

                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="info-box">
                        <label for="cliente">Nombre del cliente:</label>
                        <input type="text" name="cliente" id="cliente" required>
                    </div>

                    <div class="info-box">
                        <label for="producto">Producto:</label>
                        <select name="producto" id="productoSelect">
                            <?php while ($row = $resultProductos->fetch_assoc()) { ?>
                                <option value="<?php echo $row["id"]; ?>" data-precio="<?php echo $row["precio"]; ?>" data-stock="<?php echo $row["stock"]; ?>"><?php echo $row["nombre"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="info-box">
                        <label for="precio">Precio:</label>
                        <input type="text" name="precio" id="precio" readonly style="background-color: #ccc;">
                    </div>

                    <div class="info-box">
                        <label for="stock">Stock:</label>
                        <input type="text" name="stock" id="stock" readonly style="background-color: #ccc;">
                    </div>

                    <div class="info-box">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" name="cantidad" id="cantidad" required>
                    </div>

                    <div class="info-box">
                        <label for="fecha">Fecha de Venta:</label>
                        <input type="datetime-local" name="fecha" required>
                    </div>

                    <div class="info-box">
                        <label for="total">Total de Compra:</label>
                        <input type="text" name="total" id="total" readonly>
                    </div>

                    <input type="submit" value="Registrar Venta">
                </form>
            </div>

            <script>
                document.getElementById('productoSelect').addEventListener('change', function () {
                    var selectedOption = this.options[this.selectedIndex];
                    document.getElementById('precio').value = selectedOption.dataset.precio;
                    document.getElementById('stock').value = selectedOption.dataset.stock;
                    calculateTotal();
                });

                document.getElementById('cantidad').addEventListener('input', function () {
                    calculateTotal();
                });

                function calculateTotal() {
                    var cantidad = document.getElementById('cantidad').value;
                    var precio = document.getElementById('precio').value;
                    var total = parseFloat(precio) * parseFloat(cantidad);
                    document.getElementById('total').value = total.toFixed(2);
                }
            </script>
        </div>
    </div>
</div>

</body>
</html>
