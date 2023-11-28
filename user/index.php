<?php
include "menu.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leyenda del Mezcal</title>
    <link rel="stylesheet" href="../css/index.css">
    <style>

    .carousel {
      width: 100%;
      height: 200px;
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
    }

    .active {
      display: block;
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
    <br>

    <div class="container" style="text-align: center;">
        <div class="carousel">
            <div class="slide">
                <img src="../carrusel/1.jpg" alt="Imagen 1">
            </div>
            <div class="slide" style="text-align: center;">
                <img src="../carrusel/2.jpg" alt="Imagen 2">
            </div>
            <div class="slide" style="text-align: center;">
                <img src="../carrusel/3.jpg" alt="Imagen 3">
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

    <div class="container" style="text-align: center;">
        <video class="mezcal-video" controls style="width: 60%; height: 60%;">
            <source src="../video/video3.mp4" type="video/mp4">
        </video>
        <div class="mezcal-text">
        </div>
    </div>

    <div class="container">
        <div class="mezcal-text">
            <h1 align="center">La vida del maestro mezcalero  </h1>
            <p align="justify">Don Moisés Hernández García, comenzó a producir mezcal desde 1974 a la edad de 17 años comenzó a producir mezcal, debido a que su padre inicio con la tradición en el año 1970 con su propio palenque, entonces el comenzó ayudando a su padre y agarro amor por el arte del mezcal, y así en su recorrido por el arte mezcalero hizo trayectoria ya con 44 años de experiencia, en el cual ya se lo transmitió a sus hijos Adolfo Hernández y Gustavo Hernández, quienes comenzaron a la edad de 12 años iniciando con el cultivo de agave y después con su producción.</p>
        </div>
        <video class="mezcal-video" controls style="float: right; margin-left: 20px;">
            <source src="../video/video2.mp4" type="video/mp4">
        </video>
    </div>

    <div class="container">
        <div class="mezcal-text">
            <h1 align="center">Historia de Mezcal Mixtle</h1>
            <p align="justify">En lo profundo de las áridas tierras de Oaxaca, se encuentra un pequeño pueblo llamado Baltazar Guelavilla. En este rincón remoto de México, la tradición y el arte del mezcal han sido transmitidos de generación en generación. La historia de Mezcal Mixtle comienza con Don Moisés Hernández García, un anciano sabio y respetado en la comunidad. Desde su juventud, Don Moisés Hernández García se dedicó a cultivar y destilar agave, el corazón del auténtico mezcal. Su amor y pasión por esta ancestral bebida se reflejaban en cada paso del proceso, desde la selección cuidadosa de las piñas maduras hasta la fermentación y destilación con técnicas transmitidas por sus antepasados. La fama de Mezcal Mixtle comenzó a crecer lentamente, llegando a oídos de los conocedores y expertos mezcaleros de la región. Atraídos por su sabor excepcional y la dedicación de Don Moisés Hernández García, acudieron a Baltazar Guelavilla Mixtle para probar este elixir único. Con el paso del tiempo, Mezcal Mixtle se convirtió en una joya reconocida a nivel nacional e internacional. Los secretos de su producción artesanal se mantuvieron celosamente guardados, transmitidos solo a aquellos que demostraban un auténtico respeto por la tradición. Cada botella de Mezcal Mixtle cuenta una historia de pasión, valentía y dedicación. En cada sorbo, se pueden percibir los matices de las tierras oaxaqueñas y el trabajo arduo de los agricultores y mezcaleros que hacen posible esta maravilla líquida. Hoy en día, Mezcal Mixtle sigue siendo un tesoro en el mundo del mezcal, apreciado por su autenticidad y calidad excepcional. A medida que se descorcha una botella de Mezcal Mixtle, los aromas y sabores transportan a los amantes del mezcal a las tierras mágicas de Baltazar Guelavilla, donde la tradición y el espíritu del mezcal perduran a través del tiempo.</p>
        </div>
        <img src="../imagen/Portada.png" alt="Mezcal" class="mezcal-image">
    </div>

    <div class="container">
        <div class="mezcal-text">
            <h1 align="center">Leyenda del Mezcal</h1>
            <p align="justify">"Elixir ancestral de la tierra y el sol: el Mezcal, destilado con esmero de la sabiduría ancestral y el corazón de la naturaleza. Cada gota es un tributo a la tradición, un viaje sensorial que despierta los sentidos y celebra la riqueza de nuestra tierra. En cada sorbo, el alma de México se revela, una leyenda líquida que trasciende el tiempo y nos conecta con nuestras raíces. El Mezcal, fiel guardián de la historia y el legado de generaciones, brinda la experiencia de una cultura viva y el sabor inigualable de la pasión destilada."</p>

        </div>
        <img src="../imagen/licor.jpg" alt="Mezcal" class="mezcal-image">
    </div>

    <div class="container">
        <div class="mezcal-text">
            <h1 align="center">¿Cómo se hace el Mezcal Mixtle? </h1>
            <p align="justify">Mezcal Mixtle es una joya de la destilación artesanal que proviene del pueblo de Baltazar Guelavilla, en Oaxaca. Su historia se remonta a generaciones pasadas, y su proceso de elaboración ha sido transmitido cuidadosamente de padres a hijos. Cada botella de Mezcal Mixtle cuenta la historia de pasión, valentía y dedicación de los agricultores y mezcaleros que trabajan arduamente en las tierras oaxaqueñas. Desde la selección de las piñas maduras de agave, pasando por la fermentación y destilación, hasta el embotellado, cada paso se realiza con un profundo respeto por la tradición y un compromiso con la calidad. Al degustar Mezcal Mixtle, se pueden apreciar los matices de sabores y aromas únicos que reflejan la riqueza de la tierra y el legado cultural de Baltazar Guelavilla. Este elixir excepcional es reconocido tanto a nivel nacional como internacional, y sigue siendo apreciado por su autenticidad y sabor inigualable. Beber Mezcal Mixtle es transportarse a las tierras mágicas de Oaxaca y experimentar la magia y el encanto de una tradición ancestral que perdura a través del tiempo.</p>
        </div>
        <video class="mezcal-video" controls style="float: right; margin-left: 20px;">
            <source src="../video/video1_mezcal.mp4" type="video/mp4">
        </video>
    </div>

  <footer>
    <div class="footer-content">
      <div class="footer-section">
        <h2>Acerca de</h2>
        <p align="justify">El mezcal Mixtle es una destilado artesanal hecho a partir del agave mezcalero en la región de Oaxaca, México. Su elaboración se realiza siguiendo métodos tradicionales transmitidos de generación en generación. Con un sabor suave y aromático, el mezcal Mixtle ofrece una experiencia única para los amantes del mezcal.</p>
      </div>
      <div class="footer-section">
        <img src="../imagen/Portada.png" alt="Descripción de la imagen" width="200" height="auto">
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
      &copy; 2023 Todos los derechos reservados | Casa Mezcalera Mixtle
    </div>
  </footer>

</body>
</html>
