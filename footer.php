<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    /* Estilos adicionales para el footer */
    footer {
      width: 100%;
      position: fixed;
      bottom: 0;
      left: 0;
      background-color: white;
      padding: 20px 0;
      text-align: center;
    }

    /* Estilos para el contenido del footer */
    .footer-content {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
    }

    /* Estilos para cada sección del footer */
    .footer-section {
      flex: 0 0 33.33%;
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
  </style>
</head>
<body>
  <div class="content">
    <!-- Aquí va el contenido principal de tu página -->
  </div>

  <footer>
    <div class="footer-content">
      <div class="footer-section">
        <h2>Acerca de</h2>
        <p>El mezcal Mixtle es una destilado artesanal hecho a partir del agave mezcalero en la región de Oaxaca, México. Su elaboración se realiza siguiendo métodos tradicionales transmitidos de generación en generación. Con un sabor suave y aromático, el mezcal Mixtle ofrece una experiencia única para los amantes del mezcal.</p>
      </div>
      <div class="footer-section">
        <img src="imagen/logo1.png" alt="Descripción de la imagen" width="200" height="auto">
      </div>
      <div class="footer-section">
        <h2>Contacto</h2>
        <ul>
          <li><i class="fas fa-phone"></i> <a href="tel:+522212803811">522212803811</a></li>
          <li><i class="fas fa-envelope"></i> <a href="mailto:lic.ulloa92@outlook.es">mezcalmixtle2022@gmail.com</a></li>
          <li><i class="fas fa-map-marker-alt"></i> <a href="https://goo.gl/maps/ADhCBYows7FKM9ecA" target="_blank">29 norte sin número, barrio San Sebastián, tecamachalco, Puebla</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; 2023 Todos los derechos reservados | Casa Mezcalera Mixtle
    </div>
  </footer>
</body>
</html>
