<?php
include 'db.php'; // conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Logittransport</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6f8;
      text-align: center;
      padding: 50px;
    }
    h1 {
      color: #1e3a8a;
    }
    .menu {
      display: flex;
      flex-direction: column;
      gap: 20px;
      max-width: 400px;
      margin: auto;
    }
    .menu button {
      padding: 15px;
      font-size: 16px;
      background-color: #1e3a8a;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .menu button:hover {
      background-color: #3b5fc4;
    }
    .form-mapa {
      margin-top: 30px;
      display: none;
    }
    .form-mapa input {
      margin: 5px;
      padding: 10px;
      width: 80%;
    }
  </style>
</head>
<body>

  <h1>Bienvenido a Logittransport</h1>
  <p>Selecciona una opción para continuar:</p>

  <div class="menu">
    <form action="comprar_pasaje.php">
      <button type="submit">🎟️ Comprar Pasaje</button>
    </form>

    <form action="ver_pasajes.php">
      <button type="submit">📋 Ver Mis Pasajes</button>
    </form>

    <form action="viajes_privados.php">
      <button type="submit">🛣️ Itinerario de Viajes Privados</button>
    </form>

    <button onclick="mostrarFormulario()">🗺️ ¿Quieres saber dónde va el bus?</button>
  </div>

  <div class="form-mapa" id="formMapa">
    <form action="mapa.php" method="GET">
      <h3>Consulta de ubicación</h3>
      <input type="text" name="origen" placeholder="¿De dónde viene el bus?" required>
      <input type="text" name="destino" placeholder="¿A dónde debe llegar?" required>
      <button type="submit">Ver en el mapa</button>
    </form>
  </div>

  <script>
    function mostrarFormulario() {
      document.getElementById('formMapa').style.display = 'block';
    }
  </script>

</body>
</html>