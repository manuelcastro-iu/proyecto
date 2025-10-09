<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}
?>

<h1>Panel de Administración</h1>
<p>Bienvenido, <?php echo $_SESSION['usuario']; ?> 👋</p>
<ul>
  <li><a href="buses.php">🚌 Buses</a></li>
  <li><a href="conductores.php">👨‍✈️ Conductores</a></li>
  <li><a href="itinerarios.php">📅 Itinerarios</a></li>
  <li><a href="pasajes.php">🎟️ Pasajes</a></li>
  <li><a href="ubicaciones.php">🗺️ Ubicación en tiempo real</a></li>
  <li><a href="../logout.php">🔓 Cerrar sesión</a></li>
</ul>