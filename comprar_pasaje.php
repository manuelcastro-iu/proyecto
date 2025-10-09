<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $itinerario_id = $_POST['itinerario_id'];
  $nombre = $_POST['nombre_pasajero'];
  $rut = $_POST['rut_pasajero'];
  $asiento = $_POST['asiento'];
  $valor = $_POST['valor'];
  $fecha = date('Y-m-d');

  // Validar si el asiento ya está ocupado
  $verificar = mysqli_query($conn, "SELECT * FROM pasajes WHERE itinerario_id = $itinerario_id AND asiento = $asiento");
  if (mysqli_num_rows($verificar) > 0) {
    $mensaje = "❌ Ese asiento ya está ocupado. Elige otro.";
  } else {
    $query = "INSERT INTO pasajes (itinerario_id, nombre_pasajero, rut_pasajero, asiento, valor, fecha_compra)
              VALUES ($itinerario_id, '$nombre', '$rut', $asiento, $valor, '$fecha')";
    $result = mysqli_query($conn, $query);
    $mensaje = $result ? "✅ Pasaje registrado correctamente." : "❌ Error al registrar el pasaje.";
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Comprar Pasaje - Logittransport</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    form {
      max-width: 400px;
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

  <h1>🎟️ Comprar Pasaje</h1>

  <?php if (isset($mensaje)) echo "<p class='mensaje'>$mensaje</p>"; ?>

  <form method="POST">
    <label>Itinerario:</label>
    <select name="itinerario_id" required>
      <option value="">Seleccionar ruta</option>
      <?php
      $itinerarios = mysqli_query($conn, "SELECT id, ciudad_origen, ciudad_destino, fecha FROM itinerarios");
      while ($i = mysqli_fetch_assoc($itinerarios)) {
        echo "<option value='{$i['id']}'>{$i['ciudad_origen']} → {$i['ciudad_destino']} ({$i['fecha']})</option>";
      }
      ?>
    </select>

    <label>Nombre completo:</label>
    <input type="text" name="nombre_pasajero" required>

    <label>RUT:</label>
    <input type="text" name="rut_pasajero" required>

    <label>Número de asiento:</label>
    <input type="number" name="asiento" required>

    <label>Valor del pasaje:</label>
    <input type="number" name="valor" required>

    <button type="submit">Confirmar compra</button>
  </form>

  <p style="text-align:center;"><a href="index.php">← Volver al menú</a></p>

</body>
</html>