<?php
include "menu.php";

// Conexión a la base de datos
$servername = "localhost";
$username = "mezcalmi_Yovani";
$password = "1Blancamama";
$dbname = "mezcalmi_mezcal1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}


// Consulta SQL para obtener los productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Productos</title>
  
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        body {
            background-color: #AEE8E2;
        }

        .producto-container {
            background-color: #fff;
            padding: 20px;
        }

        .producto {
            width: 300px;
            margin: 10px auto;
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .producto img {
            max-width: 100%;
            max-height: 200px;
            margin-bottom: 10px;
        }

        .producto .nombre {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .producto .descripcion {
            margin-bottom: 10px;
        }

        .producto .precio {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .producto .stock {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .producto .comprar {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        ::-webkit-scrollbar {
            width: 0.5em;
        }

        ::-webkit-scrollbar-track {
            background-color: #f8f8f8;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #888;
        }
        
/* Estilos adicionales para el footer */
footer {
    width: 100%;
    position: relative;
    margin-top: auto;
    background-color: white;
    padding: 20px 0;
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
    background-color: #f9f9f9;
    color: #777;
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
    <div class="container">
        <br>
        <div class="producto-container">
            <h1 align="CENTER">Productos</h1>
            <div class="row justify-content-center">
            <?php
            // Mostrar los productos
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $nombre = $row['nombre'];
                    $imagen = $row['imagen'];
                    $descripcion = $row['descripcion'];
                    $precio = $row['precio'];
                    $stock = $row['stock'];

                    echo '<div class="col-md-4">';
                    echo '<div class="producto">';
                    echo '<img src="mezcal/' . $imagen . '" alt="' . $nombre . '">';
                    echo '<div class="nombre">' . $nombre . '</div>';
                    echo '<div class="descripcion">Descripcion:<br>' . $descripcion . '</div>';
                    echo '<div class="precio">Precio:$' . $precio . '</div>';
                    echo '<div class="stock">Botellas disponibles: ' . $stock . '</div>';
                    echo '<a href="login.php" class="comprar"><i class="fas fa-shopping-cart"></i> Comprar</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No se encontraron productos.";
            }

            // Cerrar la conexión a la base de datos
            $conn->close();
            ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <br>
    
    
      <footer>
    <div class="footer-content">
      <div class="footer-section">
        <h2>Acerca de</h2>
        <p align="justify">El mezcal Mixtle es una destilado artesanal hecho a partir del agave mezcalero en la región de Oaxaca, México. Su elaboración se realiza siguiendo métodos tradicionales transmitidos de generación en generación. Con un sabor suave y aromático, el mezcal Mixtle ofrece una experiencia única para los amantes del mezcal.</p>
      </div>
      <div class="footer-section">
        <img src="imagen/Portada.png" alt="Descripción de la imagen" width="200" height="auto">
      </div>
      <div class="footer-section">
        <h2>Contacto</h2>
        <ul>
          <li><i class="fas fa-phone"></i> <a href="tel:+522212803811">522212803811</a></li>
          <li><i class="fas fa-envelope"></i> <a href="mailto:mezcalmixtle2022@gmail.com">mezcalmixtle2022@gmail.com</a></li>
          <li><i class="fas fa-map-marker-alt"></i> <a href="https://goo.gl/maps/ADhCBYows7FKM9ecA" target="_blank">29 norte sin número, barrio San Sebastián, tecamachalco, Puebla</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; 2023 Mezcal Mixtle. Todos los derechos reservados. | Diseñado por Yovani González Rodríguez 
    </div>
  </footer>
</body>
</html>

