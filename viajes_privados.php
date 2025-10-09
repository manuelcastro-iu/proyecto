<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $tipo = $_POST['tipo_viaje'];
  $institucion = $_POST['institucion'];
  $contacto = $_POST['contacto'];
  $telefono = $_POST['telefono'];
  $origen = $_POST['origen'];
  $destino = $_POST['destino'];
  $fecha = $_POST['fecha'];
  $personas = $_POST['personas'];

  // Aquí podrías guardar en una tabla "viajes_privados" si la creas
  $mensaje = "✅ Solicitud enviada correctamente. Nos contactaremos contigo.";
}
?>....

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Viajes Privados - Logittransport</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    form {
      max-width: 500px;
      margin: auto;
      text-align: left;
    }
    input, select, button {
      width: 100%;
      margin: 8px 0;
      padding: 10px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }
    button {
      background-color: #1e3a8a;
      color: white;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background-color: #3b5fc4;
    }
    .mensaje {
      text-align: center;
      margin: 20px;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <h1>🛣️ Solicitud de Viaje Privado</h1>

  <?php if (isset($mensaje)) echo "<p class='mensaje'>$mensaje</p>"; ?>

  <form method="POST">
    <label>Tipo de viaje:</label>
    <select name="tipo_viaje" required>
      <option value="">Seleccionar tipo</option>
      <option value="Estudiantil">Estudiantil</option>
      <option value="Gira de estudio">Gira de estudio</option>
      <option value="Empresarial">Empresarial</option>
      <option value="Turismo">Turismo</option>
      <option value="Otro">Otro</option>
    </select>

    <label>Institución o empresa:</label>
    <input type="text" name="institucion" required>

    <label>Nombre de contacto:</label>
    <input type="text" name="contacto" required>

    <label>Teléfono:</label>
    <input type="text" name="telefono" required>

    <label>Ciudad de origen:</label>
    <input type="text" name="origen" required>

    <label>Ciudad de destino:</label>
    <input type="text" name="destino" required>

    <label>Fecha del viaje:</label>
    <input type="date" name="fecha" required>

    <label>Número de personas:</label>
    <input type="number" name="personas" required>

    <button type="submit">Enviar solicitud</button>
  </form>

  <p style="text-align:center;"><a href="index.php">← Volver al menú</a></p>

</body>
</html>