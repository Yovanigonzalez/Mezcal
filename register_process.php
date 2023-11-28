<?php
// Conexión a la base de datos (debes configurarla con tus propios datos)
$mysqli = new MySQLi("localhost", "mezcalmi_Yovani","1Blancamama", "mezcalmi_mezcal1");

// Verificar la conexión
if ($mysqli->connect_errno) {
    echo "Error en la conexión: " . $mysqli->connect_error;
    exit();
}

// Obtener los datos del formulario
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Verificar si el correo ya está registrado
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    // El correo ya está registrado, redireccionar con mensaje de error
    $error = "Location: register.php?email_error=El correo ya está registrado";
    exit();
}

// Verificar que las contraseñas coincidan
if ($password !== $confirm_password) {
    // Las contraseñas no coinciden, redireccionar con mensaje de error
    $error = "Location: register.php?error=Las contraseñas no coinciden";
    exit();
}

// Insertar el nuevo registro en la base de datos
$sql = "INSERT INTO usuarios (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";
if ($mysqli->query($sql)) {
    // Registro exitoso, redireccionar a la página de inicio de sesión
    header("Location: login.php");
    exit();
} else {
    // Error en la inserción, redireccionar con mensaje de error
    $error = "Location: register.php?error=Error en el registro";
    exit();
}
?>