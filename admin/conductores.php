<?php
include '../db.php';
session_start();
if ($_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

// Insertar nuevo conductor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = $_POST['nombre'];
  $rut = $_POST['rut'];
  $telefono = $_POST['telefono'];
  $licencia = $_POST['licencia'];
  mysqli_query($conn, "INSERT INTO conductores (nombre, rut, telefono, licencia) VALUES ('$nombre', '$rut', '$telefono', '$licencia')");
}

// Mostrar conductores
$conductores = mysqli_query($conn, "SELECT * FROM conductores");
?>

<h2>Gestión de Conductores</h2>
<form method="POST">
  <input type="text" name="nombre" placeholder="Nombre completo" required>
  <input type="text" name="rut" placeholder="RUT" required>
  <input type="text" name="telefono" placeholder="Teléfono" required>
  <input type="text" name="licencia" placeholder="Licencia" required>
  <button type="submit">Agregar Conductor</button>
</form>

<table>
  <tr><th>ID</th><th>Nombre</th><th>RUT</th><th>Teléfono</th><th>Licencia</th></tr>
  <?php while ($c = mysqli_fetch_assoc($conductores)) {
    echo "<tr>
            <td>{$c['id']}</td>
            <td>{$c['nombre']}</td>
            <td>{$c['rut']}</td>
            <td>{$c['telefono']}</td>
            <td>{$c['licencia']}</td>
          </tr>";
  } ?>
</table>