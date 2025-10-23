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

// Obtener datos actuales del bus
$consulta = mysqli_query($conn, "SELECT * FROM buses WHERE id = $id");
$bus = mysqli_fetch_assoc($consulta);
if (!$bus) {
  echo "<p style='text-align:center;'>❌ Bus no encontrado.</p>";
  exit;
}

// Actualizar datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $placa = $_POST['placa'];
  $modelo = $_POST['modelo'];
  $capacidad = intval($_POST['capacidad']);

  $update = mysqli_query($conn, "
    UPDATE buses SET
      placa = '$placa',
      modelo = '$modelo',
      capacidad = $capacidad
    WHERE id = $id
  ");

  if ($update) {
    header("Location: buses.php");
    exit;
  } else {
    echo "<p style='text-align:center;'>❌ Error al actualizar: " . mysqli_error($conn) . "</p>";
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Bus | Logittransport</title>
  <link rel="stylesheet" href="../css/style.css">
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
      padding: 20px;
      text-align: center;
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
    input, button {
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
    .menu {
      text-align: center;
      margin: 30px;
    }
  </style>
</head>
<body>

<header>
  <h2>✏️ Editar Bus</h2>
</header>

<form method="POST">
  <label>Placa:</label>
  <input type="text" name="placa" value="<?= htmlspecialchars($bus['placa']) ?>" required>

  <label>Modelo:</label>
  <input type="text" name="modelo" value="<?= htmlspecialchars($bus['modelo']) ?>" required>

  <label>Capacidad:</label>
  <input type="number" name="capacidad" value="<?= $bus['capacidad'] ?>" required>

  <button type="submit">💾 Actualizar Bus</button>
</form>

<div class="menu">
  <form action="buses.php">
    <button type="submit">← Volver</button>
  </form>
</div>

</body>
</html>