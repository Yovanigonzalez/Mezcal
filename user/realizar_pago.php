<?php
// Incluir el SDK de Mercado Pago
require_once 'path/to/mercadopago-sdk/lib.php';

// Configurar las credenciales de Mercado Pago
$mp = new MP('TU_CLIENT_ID', 'TU_CLIENT_SECRET');

// Obtener los datos del formulario
$producto_id = $_POST['producto_id'];
$nombre = $_POST['nombre'];
$precio = $_POST['precio'];
$cantidad = $_POST['cantidad'];

// Calcular el monto total del pedido
$monto_total = $precio * $cantidad;

// Crear un objeto de preferencia de pago
$preference_data = array(
    "items" => array(
        array(
            "title" => $nombre,
            "quantity" => $cantidad,
            "currency_id" => "ARS",
            "unit_price" => $precio
        )
    )
);

$preference = $mp->create_preference($preference_data);

// Redireccionar al formulario de pago de Mercado Pago
header('Location: ' . $preference['response']['sandbox_init_point']);

// Guardar los detalles del pedido en la base de datos
// Aquí puedes implementar la lógica para guardar los detalles del pedido en tu base de datos, como el ID del producto, nombre, precio, cantidad, etc.

// Mostrar el mensaje de confirmación del pedido
echo "<h2>¡Pedido realizado con éxito!</h2>";
echo "<p>Producto: $nombre</p>";
echo "<p>Precio: $precio</p>";
echo "<p>Cantidad: $cantidad</p>";
echo "<p>Monto total: $monto_total</p>";
echo "<p>¡Gracias por tu compra!</p>";
?>
