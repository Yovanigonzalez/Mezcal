<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "mezcalmi_Yovani";
$password = "1Blancamama";
$dbname = "mezcalmi_mezcal1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Obtener los datos del formulario de inicio de sesión
$email = $_POST['email'];
$password = $_POST['password'];

// Verificar las credenciales en la base de datos
$sql = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // Credenciales válidas, iniciar sesión del usuario/administrador
    $row = $result->fetch_assoc();
    session_start();
    $_SESSION['logged_in'] = true;
    $_SESSION['rol'] = $row['rol'];
    
    if ($row['rol'] == 'administrador') {
        // Inicio de sesión del administrador, redireccionar al panel de administración
        header("Location: admin_panel.php");
    } else {
        // Inicio de sesión del usuario regular, redireccionar a la página de inicio de usuario
        header("Location: bebida.php");
    }
    exit();
} else {
    // Credenciales inválidas, mostrar mensaje de error
    $error = "Credenciales inválidas. Por favor, verifica tu correo electrónico y contraseña.";
    header("Location: login.php?error=" . urlencode($error));
    exit();
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
