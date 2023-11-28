<?php


session_start();

if (empty($_SERVER['HTTP_REFERER'])) {
    // El acceso se está realizando directamente desde la URL
    header('Location: error.php');
    exit();
}


// Conexión a la base de datos (debes configurarla con tus propios datos)
$mysqli = new mysqli("localhost", "mezcalmi_Yovani", "1Blancamama", "mezcalmi_mezcal1");

// Verificar si la conexión fue exitosa
if ($mysqli->connect_errno) {
    die("Error de conexión a la base de datos: " . $mysqli->connect_error);
}

// Obtener el ID del comprobante de pago a eliminar desde la URL
$id = $_GET['id'];

// Eliminar el comprobante de pago de la base de datos
$sql = "DELETE FROM comprobantes_pago WHERE id = $id";
if ($mysqli->query($sql) === TRUE) {
    echo "Comprobante de pago eliminado exitosamente.";
} else {
    echo "Error al eliminar el comprobante de pago: " . $mysqli->error;
}

// Cerrar la conexión a la base de datos
$mysqli->close();
?>
