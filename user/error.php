<!DOCTYPE html>
<html>
<head>
    <title>No tienes acceso por URL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* Estilos para el diseño personalizado */
        body {
            background-image: url('https://media4.giphy.com/media/l1J9EdzfOSgfyueLm/200w.webp?cid=ecf05e47vj39r5bg5wlyf92t6x60ck0jojy8bb0hfebvim7s&ep=v1_gifs_search&rid=200w.webp&ct=g');
            background-repeat: no-repeat;
            background-size: cover;
            font-family: Arial, sans-serif;
        }
        
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid #ccc;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        
        p {
            margin-bottom: 20px;
        }
        
        .button {
            display: inline-block;
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 10px;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .button:hover {
            background-color: #007bff;
        }
        
        .gif-container {
            margin-top: 20px;
        }
        
        .gif {
            max-width: 100%;
        }
        
        .warning {
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .warning-icon {
            color: red;
            font-size: 24px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>No tienes acceso por URL</h1>
        <div class="gif-container">
            <img src="https://media2.giphy.com/media/TqiwHbFBaZ4ti/giphy.gif?cid=ecf05e47up4haghfq81zcr6z6h5xdliaj3b0cly8fktpmihr&ep=v1_gifs_search&rid=giphy.gif&ct=g" alt="GIF animado" class="gif">
        </div>
        <p>Lo siento, no tienes permiso para acceder a esta página directamente por URL.</p>
        <p>Por favor, inicia sesión correctamente para acceder:</p>
        <a href="../login.php" class="button">Iniciar sesión</a>
        <br>
        <div class="warning">
            <i class="fas fa-exclamation-circle warning-icon"></i>
            <p>Si vuelves a intentarlo, serás enviado directamente a las autoridades.</p>
        </div>
    </div>
</body>
</html>




