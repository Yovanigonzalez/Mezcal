<?php
session_start();
?>

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
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light custom-menu">
    <a class="navbar-brand" href="#">
      <img src="../imagen/1.png" alt="Logo">
      <a ALIGN="CENTER">CASA MEZCALERA<br>MIXTLE</a>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto text-center"> <!-- Agrega la clase "text-center" aquí -->
        <li class="nav-item">
          <a class="nav-link" href="bebida.php"><i class="fas fa-glass-martini"style="color: #000000;"></i> Bebida</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comprobante.php"><i class="fas fa-file-invoice-dollar" style="color: #000000;"></i> Comprobante de Pago</a>
        </li>
        <ul class="nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user" style="color: #000000;"></i> <?php echo $_SESSION['name']; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt" style="color: red;"></i><span style="color: red;"> Cerrar sesión</span></a>
            </div>
          </li>
        </ul>
      </ul>
    </div>
  </nav>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
