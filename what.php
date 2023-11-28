<?php
include 'menu.php';

$mensajeEnviado = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono']; // Nuevo campo agregado
    $mensaje = $_POST['mensaje'];

    // Configuración del correo electrónico
    $destinatario = "mezcalmixtle2022@gmail.com"; // Cambia esto por tu dirección de correo electrónico
    $asunto = "Quiero saber más sobre el producto";

    // Contenido del correo electrónico con diseño personalizado
    $cuerpo = '
    <html>
    <head>
        <title>Correo de contacto</title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #f7f7f7;
                border-radius: 10px;
            }
            .header {
                text-align: center;
                margin-bottom: 20px;
            }
            .contact-info {
                margin-bottom: 20px;
            }
            .contact-info label {
                font-weight: bold;
            }
            .message {
                margin-bottom: 20px;
            }
            .footer {
                text-align: center;
                font-size: 12px;
                color: #888888;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Contacto</h1>
            </div>
            <div class="contact-info">
                <p><label>Nombre:</label> ' . $nombre . '</p>
                <p><label>Email:</label> ' . $email . '</p>
                <p><label>Teléfono:</label> ' . $telefono . '</p>
            </div>
            <div class="message">
                <p><label>Mensaje:</label></p>
                <p>' . $mensaje . '</p>
            </div>
            <div class="footer">
                <p>Este correo ha sido enviado desde el formulario de contacto  de Casa Mezcalera.</p>
            </div>
        </div>
    </body>
    </html>
    ';

    // Cabeceras del correo electrónico
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    $headers .= "X-Priority: 1\r\n"; // Establece alta prioridad

    // Envío del correo electrónico
    if (mail($destinatario, $asunto, $cuerpo, $headers)) {
        // El correo electrónico se envió exitosamente
        $mensajeEnviado = true;
    } else {
        // Hubo un error en el envío del correo
        echo "Error al enviar el correo.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contacto</title>

    <style>
        body {
            background-color: #AEE8E2;
        }

        .contact-box {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .contact-box h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .contact-box .form-group label {
            font-weight: bold;
        }

        .contact-box .btn-primary {
            display: block;
            margin-top: 20px;
            width: 100%;
        }

        .whatsapp-button {
            display: block;
            margin-top: 20px;
            width: 100%;
            background-color: #25D366;
            color: #FFFFFF;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
            border: none;
            cursor: pointer;
            text-align: center;
        }
        .whatsapp-button i {
            margin-right: 5px;
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

        .success-message {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            padding: 10px;
            margin-top: 20px;
            border-radius: 4px;
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
        <div class="contact-box">
            <h1>Contacto</h1>
            <?php if ($mensajeEnviado): ?>
                <div class="success-message">
                    Gracias por tu mensaje. Nos pondremos en contacto contigo pronto.
                </div>
            <?php endif; ?>
            
<form action="" method="POST">
    <div class="form-group">
        <label for="nombre"><i class="fas fa-user" style="color: blue;"></i> Nombre:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ejemplo: Juan Pérez">
    </div>
    <div class="form-group">
        <label for="email"><i class="fas fa-envelope" style="color: green;"></i> Email:</label>
        <input type="email" class="form-control" id="email" name="email" required placeholder="Ejemplo: ejemplo@gmail.com">
    </div>
    <div class="form-group">
        <label for="telefono"><i class="fas fa-phone" style="color: red;"></i> Número de Teléfono:</label>
        <input type="text" class="form-control" id="telefono" name="telefono" required pattern="[0-9]{10}" maxlength="10" title="Ingresa un número de teléfono válido de 10 dígitos" placeholder="Ejemplo: 1234567890">
    </div>
    <div class="form-group">
        <label for="mensaje"><i class="fas fa-comment" style="color: orange;"></i> Mensaje:</label>
        <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required placeholder="Escribe tu mensaje aquí"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
</form>

            <a href="javascript:void(0);" onclick="enviarMensaje()" class="whatsapp-button">
                <i class="fab fa-whatsapp"></i>Enviar mensaje por WhatsApp
            </a>
        </div>
    </div>

   <!--  <script src="https://kit.fontawesome.com/xxxxxxxxxx.js" crossorigin="anonymous"></script> Reemplaza "xxxxxxxxxx" con tu clave de API de Font Awesome -->

    <script>
        function enviarMensaje() {
            var mensaje = "¡Hola! Estoy interesado/a en tu producto. ¿Podrías brindarme más información?";
            var numeroTelefono = "+522212803811";

            var mensajeCodificado = encodeURIComponent(mensaje);
            var enlaceWhatsapp = "https://api.whatsapp.com/send?phone=" + numeroTelefono + "&text=" + mensajeCodificado;

            window.open(enlaceWhatsapp, '_blank');
        }
    </script>
    
    
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
