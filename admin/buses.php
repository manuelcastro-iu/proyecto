<?php
include '../db.php';
session_start();
if ($_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

// Insertar nuevo bus
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $placa = $_POST['placa'];
  $modelo = $_POST['modelo'];
  $capacidad = $_POST['capacidad'];
  mysqli_query($conn, "INSERT INTO buses (placa, modelo, capacidad) VALUES ('$placa', '$modelo', $capacidad)");
}

// Mostrar buses
$buses = mysqli_query($conn, "SELECT * FROM buses");
?>

<h2>Gestión de Buses</h2>
<form method="POST">
  <input type="text" name="placa" placeholder="Placa" required>
  <input type="text" name="modelo" placeholder="Modelo" required>
  <input type="number" name="capacidad" placeholder="Capacidad" required>
  <button type="submit">Agregar Bus</button>
</form>

<table>
  <tr><th>ID</th><th>Placa</th><th>Modelo</th><th>Capacidad</th></tr>
  <?php while ($bus = mysqli_fetch_assoc($buses)) {
    echo "<tr>
            <td>{$bus['id']}</td>
            <td>{$bus['placa']}</td>
            <td>{$bus['modelo']}</td>
            <td>{$bus['capacidad']}</td>
          </tr>";
  } ?>
</table>