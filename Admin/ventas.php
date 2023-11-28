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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    
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

// Obtener lista de productos
$queryProductos = "SELECT * FROM productos";
$resultProductos = $mysqli->query($queryProductos);

// ...

// Procesar formulario de ventas
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente = $_POST["cliente"];
    $productosSeleccionados = $_POST["productosSeleccionados"];
    $cantidades = $_POST["cantidad"];
    $precios = $_POST["precio"];
    $subtotal = $_POST["subtotal"];
    $fecha = $_POST["fecha"];

    // Validar si hay al menos un producto seleccionado
    if (count($productosSeleccionados) == 0) {
        echo "Error: Debes seleccionar al menos un producto.";
    } else {
        // Iniciar transacción
        $mysqli->begin_transaction();

        // Inicializar una variable para el total de la venta
        $totalVenta = 0;
        $error = false;
        
        // Recorrer los productos seleccionados
        foreach ($productosSeleccionados as $index => $productoId) {
            $cantidadProducto = $cantidades[$index];
            $precioProducto = $precios[$index];
            $subtotalProducto = $subtotal[$index];

            // Obtener información del producto seleccionado
            $queryProducto = "SELECT nombre, stock FROM productos WHERE id = '$productoId' FOR UPDATE";
            $resultProducto = $mysqli->query($queryProducto);
            $row = $resultProducto->fetch_assoc();
            $nombreProducto = $row["nombre"];
            $stock = $row["stock"];

            // Validar si hay suficiente stock
            if ($cantidadProducto > $stock) {
                echo "Error: No hay suficiente stock disponible para el producto: $nombreProducto.";
                $error = true;
                break;
            } else {
                // Actualizar el stock del producto
                $stockActualizado = $stock - $cantidadProducto;
                $queryStock = "UPDATE productos SET stock = '$stockActualizado' WHERE id = '$productoId'";
                $mysqli->query($queryStock);

                // Calcular el subtotal del producto
                $subtotalProducto = $precioProducto * $cantidadProducto;

                // Calcular el total de la venta
                $totalVenta += $subtotalProducto;

                // Guardar la venta en la base de datos
                $queryVenta = "INSERT INTO ventas (cliente, producto_id, producto, precio, fecha_venta, cantidad, total) VALUES ('$cliente', '$productoId', '$nombreProducto', '$precioProducto', '$fecha', $cantidadProducto, '$subtotalProducto')";
                if ($mysqli->query($queryVenta) !== TRUE) {
                    echo "Error al registrar la venta para el producto: $nombreProducto - " . $mysqli->error;
                    $error = true;
                    break;
                }
            }
        }

        if (!$error) {
            // Commit de la transacción si no hubo errores
            $mysqli->commit();

            // Mostrar mensaje de éxito y el total de la venta con separación de cifras
            $totalVentaFormatted = number_format($totalVenta, 2);
            echo "Venta registrada exitosamente. Total de la venta: $" . $totalVentaFormatted;
        } else {
            // Rollback de la transacción si hubo errores
            $mysqli->rollback();
        }
    }
}

// ...

// Cerrar la conexión
$mysqli->close();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top"> <!-- recuerda dark color, pon fixed-top para todo el ancho en el menu-->
                <a class="navbar-brand" href="#">Panel de Administración</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
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
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
        <div class="container" style="margin-top: 90px;">  <!--el margin sirve para la separacion-->
        
    <?php
    // Mostrar mensaje de éxito o error
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!$error) {
            // Venta exitosa
            echo '<div class="alert alert-success" role="alert">Venta registrada exitosamente.</div>';
        } else {
            // Venta denegada
            echo '<div class="alert alert-danger" role="alert">Error al procesar la venta. Por favor, inténtalo de nuevo.</div>';
        }
    }
    ?>
                <h2>Registro de Ventas</h2>

                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="info-box">
                        <label for="cliente">Nombre del cliente:</label>
                        <input type="text" name="cliente" id="cliente" required>
                    </div>
                    <div class="info-box">
                        <label for="productos">Productos:</label>
                        <select name="productos[]" id="productoSelect" multiple>
                            <?php while ($row = $resultProductos->fetch_assoc()) { ?>
                                <option value="<?php echo $row["id"]; ?>" data-precio="<?php echo $row["precio"]; ?>"
                                    data-stock="<?php echo $row["stock"]; ?>">
                                    <?php echo $row["nombre"]; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="info-box">
                        <label>Productos seleccionados:</label>
                        <div id="productosSeleccionados">
                            <!-- Aquí se mostrarán los productos seleccionados -->
                        </div>
                    </div>

                    <script>
                        var productoSelect = document.getElementById('productoSelect');
                        var productosSeleccionadosDiv = document.getElementById('productosSeleccionados');
                        var productosSeleccionados = [];

                        productoSelect.addEventListener('change', function () {
                            var selectedOptions = Array.from(this.selectedOptions);

                            selectedOptions.forEach(function (option) {
                                var productoId = option.value;

                                if (!productosSeleccionados.includes(productoId)) {
                                    productosSeleccionados.push(productoId);

                                    var precio = option.getAttribute('data-precio');
                                    var stock = option.getAttribute('data-stock');

                                    var checkbox = document.createElement('input');
                                    checkbox.type = 'checkbox';
                                    checkbox.name = 'productosSeleccionados[]';
                                    checkbox.value = productoId;

                                    var label = document.createElement('label');
                                    label.appendChild(checkbox);
                                    label.appendChild(document.createTextNode(option.textContent));

                                    var precioInput = document.createElement('input');
                                    precioInput.type = 'text';
                                    precioInput.name = 'precio[]';
                                    precioInput.value = precio;
                                    precioInput.readOnly = true;
                                    precioInput.classList.add('precio-input'); // Agrega la clase precio-input

                                    var stockInput = document.createElement('input');
                                    stockInput.type = 'text';
                                    stockInput.name = 'stock[]';
                                    stockInput.value = stock;
                                    stockInput.readOnly = true;
                                    stockInput.classList.add('stock-input'); // Agrega la clase stock-input

                                    var cantidadInput = document.createElement('input');
                                    cantidadInput.type = 'number';
                                    cantidadInput.name = 'cantidad[]';
                                    cantidadInput.min = 1;
                                    cantidadInput.max = stock;
                                    cantidadInput.required = true;

                                    var subtotalInput = document.createElement('input');
                                    subtotalInput.type = 'text';
                                    subtotalInput.name = 'subtotal[]';
                                    subtotalInput.value = '0.00';
                                    subtotalInput.readOnly = true;

                                    cantidadInput.addEventListener('input', function () {
                                        var cantidad = parseInt(this.value);
                                        var precio = parseFloat(precioInput.value);
                                        var stock = parseInt(stockInput.value);
                                        var subtotal = cantidad * precio;

                                        if (cantidad > stock) {
                                            stockInput.classList.add('insufficient-stock');
                                        } else {
                                            stockInput.classList.remove('insufficient-stock');
                                        }

                                        subtotalInput.value = subtotal.toLocaleString('es-MX', {
                                            minimumFractionDigits: 2
                                        });
                                        calcularTotal();
                                    });

                                    var container = document.createElement('div');
                                    container.classList.add('producto-seleccionado');
                                    container.appendChild(label);
                                    container.appendChild(document.createTextNode('Precio: '));
                                    container.appendChild(precioInput);
                                    container.appendChild(document.createElement('br'));
                                    container.appendChild(document.createTextNode('Stock disponible: '));
                                    container.appendChild(stockInput);
                                    container.appendChild(document.createElement('br'));
                                    container.appendChild(document.createTextNode('Cantidad: '));
                                    container.appendChild(cantidadInput);
                                    container.appendChild(document.createTextNode('Subtotal: '));
                                    container.appendChild(subtotalInput);

                                    productosSeleccionadosDiv.appendChild(container);
                                }
                            });
                        });

                        function calcularTotal() {
                            var total = 0;
                            var totalInputs = document.querySelectorAll('.producto-seleccionado input[name="subtotal[]"]');

                            totalInputs.forEach(function (input) {
                                var subtotal = parseFloat(input.value.replace(',', '')); // Eliminar las comas del valor
                                if (!isNaN(subtotal)) {
                                    total += subtotal;
                                } else {
                                    input.value = '0.00';
                                }
                            });

                            var totalFormatted = total.toLocaleString('es-MX', {
                                minimumFractionDigits: 2
                            });
                            document.getElementById('total').textContent = 'Total: $' + totalFormatted;
                        }
                    </script>

                    <div class="info-box">
                        <label for="fecha">Fecha de venta:</label>
                        <input type="date" name="fecha" id="fecha" required>
                    </div>

                    <div class="info-box">
                        <input type="hidden" name="subtotalTotal" id="subtotalTotal">
                        <p id="total" style="font-weight: bold;">Total: $0.00</p>
                    </div>

                    <div class="info-box">
                        <input type="submit" value="Registrar venta" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


</body>
</html>

