<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  
  <style>
    .navbar-brand img {
      max-width: 100px; /* Ajusta el tamaño máximo de la imagen según tus necesidades */
    }
    .custom-menu {
      background-color: #ffffff; /* Cambia este valor al color deseado */
    }
    .navbar-nav.ml-auto {
      margin-left: auto !important;
    }
    .navbar-nav .nav-link i {
      margin-right: 5px;
      color: #000000; /* Cambia este valor al color deseado */
    }
    @media (max-width: 575.98px) {
      .navbar-nav {
        text-align: center;
      }
      .navbar-nav .nav-link {
        padding: 0.5rem 0;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light custom-menu">
    <a class="navbar-brand" href="#">
      <img src="imagen/1.png" alt="Logo">
      <a style="text-align: center;">CASA MEZCALERA<br>MIXTLE</a>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php"><i class="fas fa-home" style="color: #000000;"></i> Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="creador.php"><i class="fas fa-user-tie" style="color: #000000;"></i> Creador</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="bebida.php"><i class="fas fa-glass-martini" style="color: #000000;"></i> Bebida</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="what.php"><i class="fas fa-envelope" style="color: #000000;"></i> Contacto</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php"><i class="fas fa-user" style="color: #000000;"></i> Login</a>
        </li>
      </ul>
    </div>
  </nav>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


