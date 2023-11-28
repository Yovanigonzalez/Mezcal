<?php
include "menu.php";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Creador del Mezcal</title>
   
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="icon" href="img/moral.jpg" type="image/jpeg">


  <style>
    body {
      background-color: #AEE8E2;
    }

    .container {
      background-color: #fff;
      padding: 20px;
      margin-top: 50px;
      border-radius: 5px;
      //box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
        .image-section {
      text-align: center;
    }
    
        .carousel {
      width: 100%;
      overflow: hidden;
    }

    .slide {
      width: 100%;
      height: 100%;
      display: none;
    }

    .slide img {
      max-width: 100%;
      max-height: 100%;
      border-radius: 10px;
    }

    .active {
      display: block;
    }

.image-section img {
  max-width: 100%;
  height: auto;
  margin-bottom: 20px;
  border-radius: 10px; /* Ajusta el valor según tus preferencias */
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
    <h1 align="center">Creador de Mezcal</h1>
  
    <h5>Información personal</h5>
    <p>Don Moisés Hernández García</p>
    
    <h5>Experiencia en la producción de mezcal</h5>
    <p align="justify">Comenzó a producir mezcal desde 1974 a la edad de 17 años. Su padre inició la tradición en el año 1970 con su propio palenque, y Don Moisés comenzó a ayudar a su padre, desarrollando un amor por el arte del mezcal. A lo largo de su trayectoria en el mundo del mezcal, ha acumulado 44 años de experiencia en el arte mezcalero.</p>
    
    <h5>Transmisión del arte del mezcal a sus hijos</h5>
    <p align="justify">Don Moisés Hernández García ha transmitido su conocimiento y pasión por el mezcal a sus hijos:</p>
    
    <h5>Adolfo Hernández</h5>
    <p align="justify">Comenzó en la producción de mezcal a la edad de 12 años, iniciando con el cultivo de agave y posteriormente involucrándose en su producción.</p>
  
    <h5>Gustavo Hernández</h5>
    <p align="justify">Al igual que su hermano Adolfo, Gustavo Hernández también comenzó en la producción de mezcal a la edad de 12 años, primero cultivando agave y luego participando en la producción del mezcal.</p>
  
  <!-- Carrucel -->
    <div class="container" style="text-align: center;">
        <div class="carousel">
            <div class="slide">
      <img src="creador/4.jpg" alt="Descripción de la imagen" width="900" alt="500" height="auto">
            </div>
            <div class="slide" style="text-align: center;">
      <img src="creador/7.jpg" alt="Descripción de la imagen" width="900" alt="500" height="auto">
            </div>
        </div>
    </div>
    
        <script>
        // Obtener referencias a los elementos del carrusel
        const carousel = document.querySelector('.carousel');
        const slides = carousel.querySelectorAll('.slide');

        let currentSlide = 0;

        function showSlide(slideIndex) {
            // Ocultar todas las diapositivas
            slides.forEach(slide => slide.classList.remove('active'));

            // Mostrar la diapositiva actual
            slides[slideIndex].classList.add('active');
        }

        function nextSlide() {
            currentSlide++;
            if (currentSlide >= slides.length) {
                currentSlide = 0;
            }
            showSlide(currentSlide);
        }

        // Mostrar la primera diapositiva al cargar la página
        showSlide(currentSlide);

        // Avanzar al siguiente slide cada 3 segundos
        setInterval(nextSlide, 3000);
    </script>
    
                  <!-- Agregar imágenes -->
    <div class="image-section">
      <img src="creador/1.jpg" alt="Descripción de la imagen" width="200" height="auto">
      <img src="creador/2.jpg" alt="Descripción de la imagen" width="200" height="auto">
      <img src="creador/5.jpg" alt="Descripción de la imagen" width="200" height="auto">
      <img src="creador/6.jpg" alt="Descripción de la imagen" width="200" height="auto">
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
          <li><i class="fas fa-map-marker-alt"></i> <a href="https://goo.gl/maps/ADhCBYows7FKM9ecA" target="_blank">29 norte sin número, barrio San Sebastián, tecamachalco, Puebla</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; 2023 Mezcal Mixtle. Todos los derechos reservados. | Diseñado por Yovani González Rodríguez 
    </div>
  </footer>
</body>
</html>




