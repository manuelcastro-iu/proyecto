<?php
include 'db.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $tipo = $_POST['tipo_viaje'];
  $institucion = $_POST['institucion'];
  $contacto = $_POST['contacto'];
  $telefono = $_POST['telefono'];
  $origen = $_POST['origen'];
  $destino = $_POST['destino'];
  $fecha = $_POST['fecha'];
  $personas = $_POST['personas'];

  $sql = "INSERT INTO viajes_privados (tipo_viaje, institucion, contacto, telefono, origen, destino, fecha, personas, estado)
          VALUES ('$tipo', '$institucion', '$contacto', '$telefono', '$origen', '$destino', '$fecha', $personas, 'pendiente')";
  $result = mysqli_query($conn, $sql);

  $mensaje = $result
    ? "✅ Solicitud enviada correctamente. El administrador la revisará."
    : "❌ Error al enviar la solicitud: " . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Viajes Privados - Logittransport</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f6f8;
      margin: 0;
      padding: 0;
    }
    h1 {
      text-align: center;
      background-color: #1e3a8a;
      color: white;
      padding: 20px;
      margin: 0;
    }
    form {
      max-width: 500px;
      margin: 30px auto;
      background-color: white;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    label {
      font-weight: bold;
      margin-top: 10px;
      display: block;
    }
    input, select, button {
      width: 100%;
      margin: 8px 0;
      padding: 10px;
      border-radius: 4px;
      border: 1px solid #ccc;
      font-size: 15px;
    }
    button {
      background-color: #1e3a8a;
      color: white;
      border: none;
      cursor: pointer;
      font-weight: bold;
    }
    button:hover {
      background-color: #3b5fc4;
    }
    .mensaje {
      text-align: center;
      margin: 20px;
      font-weight: bold;
      color: #1e3a8a;
    }
    .menu {
      text-align: center;
      margin: 30px;
    }
  </style>
</head>
<body>

  <h1>🛣️ Solicitud de Viaje Privado</h1>

  <?php if ($mensaje): ?>
    <p class="mensaje"><?= $mensaje ?></p>
  <?php endif; ?>

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

  <div class="menu">
    <a href="index.php">← Volver al menú</a>
  </div>

</body>
</html>