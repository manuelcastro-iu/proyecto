<?php
include 'db.php';

$pasajes = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $rut = $_POST['rut_pasajero'];
  $query = "SELECT p.*, i.ciudad_origen, i.ciudad_destino, i.fecha, i.hora_salida
            FROM pasajes p
            JOIN itinerarios i ON p.itinerario_id = i.id
            WHERE p.rut_pasajero = '$rut'";
  $result = mysqli_query($conn, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $pasajes[] = $row;
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ver Mis Pasajes - Logittransport</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    form {
      max-width: 400px;
      margin: auto;
      text-align: left;
    }
    input, button {
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
    table {
      margin-top: 30px;
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: center;
    }
    h2 {
      color: #1e3a8a;
    }
  </style>
</head>
<body>

  <h1>📋 Ver Mis Pasajes</h1>

  <form method="POST">
    <label>Ingresa tu RUT:</label>
    <input type="text" name="rut_pasajero" required>
    <button type="submit">Consultar</button>
  </form>

  <?php if (!empty($pasajes)): ?>
    <h2>Resultados:</h2>
    <table>
      <tr>
        <th>Pasajero</th>
        <th>Asiento</th>
        <th>Valor</th>
        <th>Fecha Compra</th>
        <th>Ruta</th>
        <th>Salida</th>
      </tr>
      <?php foreach ($pasajes as $p): ?>
        <tr>
          <td><?= $p['nombre_pasajero'] ?></td>
          <td><?= $p['asiento'] ?></td>
          <td>$<?= $p['valor'] ?></td>
          <td><?= $p['fecha_compra'] ?></td>
          <td><?= $p['ciudad_origen'] ?> → <?= $p['ciudad_destino'] ?></td>
          <td><?= $p['hora_salida'] ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <p>No se encontraron pasajes para ese RUT.</p>
  <?php endif; ?>

  <p style="text-align:center;"><a href="index.php">← Volver al menú</a></p>

</body>
</html>