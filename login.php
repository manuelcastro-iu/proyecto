<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usuario = $_POST['usuario'];
  $clave = $_POST['clave'];

  $query = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
  $result = mysqli_query($conn, $query);
  $user = mysqli_fetch_assoc($result);

  // Comparación directa sin password_verify
  if ($user && $clave === $user['clave']) {
    $_SESSION['usuario'] = $user['usuario'];
    $_SESSION['rol'] = $user['rol'];
    header('Location: admin/dashboard.php');
    exit;
  } else {
    $error = "Usuario o clave incorrectos.";
  }
}
?>

<form method="POST">
  <h2>Acceso Administrador</h2>
  <input type="text" name="usuario" placeholder="Usuario" required>
  <input type="password" name="clave" placeholder="Clave" required>
  <button type="submit">Ingresar</button>
  <?php if (isset($error)) echo "<p>$error</p>"; ?>
</form> 