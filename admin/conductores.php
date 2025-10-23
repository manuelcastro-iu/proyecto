<?php
include '../estilo_menu.php';
include '../db.php';
session_start();
if ($_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

// Eliminar conductor
if (isset($_GET['eliminar'])) {
  $id = intval($_GET['eliminar']);
  mysqli_query($conn, "DELETE FROM conductores WHERE id = $id");
  header("Location: conductores.php");
  exit;
}

// Insertar nuevo conductor
if (isset($_POST['agregar'])) {
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
  <button type="submit" name="agregar">Agregar Conductor</button>
</form>

<table width="900" border="1" align="center" cellpadding="4">
  <tr>
    <th colspan="7">LISTA DE CONDUCTORES</th>
  </tr>
  <tr>
    <th>ID</th><th>Nombre</th><th>RUT</th><th>Teléfono</th><th>Licencia</th><th>Acciones</th>
  </tr>

  <?php while ($c = mysqli_fetch_assoc($conductores)) { ?>
    <tr>
      <td><?= $c['id'] ?></td>
      <td><?= $c['nombre'] ?></td>
      <td><?= $c['rut'] ?></td>
      <td><?= $c['telefono'] ?></td>
      <td><?= $c['licencia'] ?></td>
      <td>
        <a href="editar_conductor.php?id=<?= $c['id'] ?>">Editar</a> |
        <a href="?eliminar=<?= $c['id'] ?>" onclick="return confirm('¿Eliminar este conductor?')">Eliminar</a>
      </td>
    </tr>
  <?php } ?>
</table>

<br><br>
<div class="menu">
  <form action="../index.php">
    <button type="submit" style="width:100px">INICIO</button>
  </form>
</div>