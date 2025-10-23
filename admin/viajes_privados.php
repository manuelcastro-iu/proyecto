<?php
include '../db.php';
session_start();
if ($_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

// Aceptar solicitud
if (isset($_GET['aceptar'])) {
  $id = intval($_GET['aceptar']);
  mysqli_query($conn, "UPDATE viajes_privados SET estado='aceptado' WHERE id=$id");
  header("Location: viajes_privados.php");
  exit;
}

// Rechazar solicitud
if (isset($_GET['rechazar'])) {
  $id = intval($_GET['rechazar']);
  mysqli_query($conn, "UPDATE viajes_privados SET estado='rechazado' WHERE id=$id");
  header("Location: viajes_privados.php");
  exit;
}

// Obtener solicitudes
$viajes = mysqli_query($conn, "SELECT * FROM viajes_privados ORDER BY fecha_solicitud DESC");
if (!$viajes) {
  die("<p style='color:red; text-align:center;'>❌ Error al consultar la base de datos: " . mysqli_error($conn) . "</p>");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Solicitudes de Viajes Privados | Logittransport</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f6f8;
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #1e3a8a;
      color: white;
      padding: 20px;
      text-align: center;
    }
    table {
      width: 95%;
      margin: 30px auto;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: center;
    }
    th {
      background-color: #1e3a8a;
      color: white;
    }
    .acciones a {
      margin: 0 5px;
      text-decoration: none;
      font-weight: bold;
      color: #1e3a8a;
    }
    .acciones a:hover {
      text-decoration: underline;
    }
    .menu {
      text-align: center;
      margin: 30px;
    }
    .mensaje {
      text-align: center;
      margin: 40px;
      font-size: 18px;
      color: #555;
    }
  </style>
</head>
<body>

<header>
  <h2>📋 Solicitudes de Viajes Privados</h2>
</header>

<?php if (mysqli_num_rows($viajes) === 0): ?>
  <p class="mensaje">No hay solicitudes registradas.</p>
<?php else: ?>
  <table>
    <tr>
      <th>ID</th>
      <th>Tipo</th>
      <th>Institución</th>
      <th>Contacto</th>
      <th>Teléfono</th>
      <th>Origen</th>
      <th>Destino</th>
      <th>Fecha</th>
      <th>Personas</th>
      <th>Estado</th>
      <th>Acciones</th>
    </tr>
    <?php while ($v = mysqli_fetch_assoc($viajes)) { ?>
      <tr>
        <td><?= $v['id'] ?></td>
        <td><?= htmlspecialchars($v['tipo_viaje']) ?></td>
        <td><?= htmlspecialchars($v['institucion']) ?></td>
        <td><?= htmlspecialchars($v['contacto']) ?></td>
        <td><?= htmlspecialchars($v['telefono']) ?></td>
        <td><?= htmlspecialchars($v['origen']) ?></td>
        <td><?= htmlspecialchars($v['destino']) ?></td>
        <td><?= $v['fecha'] ?></td>
        <td><?= $v['personas'] ?></td>
        <td><?= ucfirst($v['estado']) ?></td>
        <td class="acciones">
          <?php if ($v['estado'] === 'pendiente') { ?>
            <a href="?aceptar=<?= $v['id'] ?>" onclick="return confirm('¿Aceptar esta solicitud?')">✅ Aceptar</a>
            <a href="?rechazar=<?= $v['id'] ?>" onclick="return confirm('¿Rechazar esta solicitud?')">❌ Rechazar</a>
          <?php } else { echo "—"; } ?>
        </td>
      </tr>
    <?php } ?>
  </table>
<?php endif; ?>

<div class="menu">
  <form action="../index.php">
    <button type="submit">← Volver al panel</button>
  </form>
</div>

</body>
</html>