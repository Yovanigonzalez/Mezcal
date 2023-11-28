<?php

session_start();

if (empty($_SERVER['HTTP_REFERER'])) {
    // El acceso se está realizando directamente desde la URL
    header('Location: error.php');
    exit();
}


// Conexión a la base de datos (debes configurarla con tus propios datos)
$mysqli = new MySQLi("localhost", "mezcalmi_Yovani","1Blancamama", "mezcalmi_mezcal1");

// Verificar la conexión
if ($mysqli->connect_errno) {
    echo "Error en la conexión: " . $mysqli->connect_error;
    exit();
}

// Función para mostrar un mensaje de éxito o error
function showMessage($message, $isError = false) {
    $class = $isError ? 'alert-danger' : 'alert-success';
    echo "<div class='alert $class' style='color: #155724; background-color: #d4edda; border-color: #c3e6cb;'>$message</div>";
}

// Verificar si se recibió el ID del usuario a eliminar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar el usuario de la base de datos
    $sql = "DELETE FROM usuarios WHERE id = $id";
    $result = $mysqli->query($sql);

    if ($result) {
        showMessage("Usuario eliminado correctamente.");
    } else {
        showMessage("Error al eliminar el usuario.", true);
    }
} else {
    showMessage("No se proporcionó un ID de usuario válido.", true);
}
?>
