<?php
include '../db.php';
session_start();
if ($_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
  echo "<p style='text-align:center;'>❌ ID inválido.</p>";
  exit;
}

// Obtener datos actuales del itinerario
$consulta = mysqli_query($conn, "
  SELECT * FROM itinerarios WHERE id = $id
");
$itinerario = mysqli_fetch_assoc($consulta);
if (!$itinerario) {
  echo "<p style='text-align:center;'>❌ Itinerario no encontrado.</p>";
  exit;
}

// Obtener buses y conductores
$buses = mysqli_query($conn, "SELECT id, placa FROM buses");
$conductores = mysqli_query($conn, "SELECT id, nombre FROM conductores");

// Actualizar datos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
  $origen = $_POST['ciudad_origen'];
  $destino = $_POST['ciudad_destino'];
  $bus_id = $_POST['bus_id'];
  $conductor_id = $_POST['conductor_id'];
  $fecha = $_POST['fecha'];
  $hora_salida = $_POST['hora_salida'];
  $hora_llegada = $_POST['hora_llegada'];

  $update = mysqli_query($conn, "
    UPDATE itinerarios SET
      ciudad_origen = '$origen',
      ciudad_destino = '$destino',
      bus_id = $bus_id,
      conductor_id = $conductor_id,
      fecha = '$fecha',
      hora_salida = '$hora_salida',
      hora_llegada = '$hora_llegada'
    WHERE id = $id
  ");

  if ($update) {
    header("Location: itinerarios.php");
    exit;
  } else {
    echo "<p style='text-align:center;'>❌ Error al actualizar.</p>";
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Itinerario | Logittransport</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f6f8;
      margin: 0;
      padding: 0;
      color: #333;
    }
    header {
      background-color: #1e3a8a;
      color: white;
      padding: 30px;
      text-align: center;
    }
    header h1 {
      margin: 0;
      font-size: 28px;
    }
    form {
      max-width: 500px;
      margin: 40px auto;
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
      padding: 12px;
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
    .menu {
      text-align: center;
      margin: 30px;
    }
  </style>
</head>
<body>

<header>
  <h1>✏️ Editar Itinerario</h1>
</header>

<form method="POST">
  <label>Ciudad de origen:</label>
  <input type="text" name="ciudad_origen" value="<?= $itinerario['ciudad_origen'] ?>" required>

  <label>Ciudad de destino:</label>
  <input type="text" name="ciudad_destino" value="<?= $itinerario['ciudad_destino'] ?>" required>

  <label>Seleccionar bus:</label>
  <select name="bus_id" required>
    <?php while ($b = mysqli_fetch_assoc($buses)) {
      $selected = ($b['id'] == $itinerario['bus_id']) ? 'selected' : '';
      echo "<option value='{$b['id']}' $selected>{$b['placa']}</option>";
    } ?>
  </select>

  <label>Seleccionar conductor:</label>
  <select name="conductor_id" required>
    <?php while ($c = mysqli_fetch_assoc($conductores)) {
      $selected = ($c['id'] == $itinerario['conductor_id']) ? 'selected' : '';
      echo "<option value='{$c['id']}' $selected>{$c['nombre']}</option>";
    } ?>
  </select>

  <label>Fecha del viaje:</label>
  <input type="date" name="fecha" value="<?= $itinerario['fecha'] ?>" required>

  <label>Hora de salida:</label>
  <input type="time" name="hora_salida" value="<?= $itinerario['hora_salida'] ?>" required>

  <label>Hora de llegada:</label>
  <input type="time" name="hora_llegada" value="<?= $itinerario['hora_llegada'] ?>" required>

  <button type="submit" name="actualizar">💾 Actualizar Ruta</button>
</form>

<div class="menu">
  <form action="itinerarios.php">
    <button type="submit">← Volver</button>
  </form>
</div>

</body>
</html>