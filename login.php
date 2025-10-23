<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usuario = trim($_POST['usuario']);
  $clave = trim($_POST['clave']);

  $query = "SELECT * FROM usuarios WHERE usuario = '$usuario' LIMIT 1";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    if ($clave === $user['clave']) {
      $_SESSION['usuario'] = $user['usuario'];
      $_SESSION['rol'] = $user['rol'];
      header('Location: index.php');
      exit;
    } else {
      $error = "Usuario o clave incorrectos.";
    }
  } else {
    $error = "Usuario no encontrado.";
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
</head>
<body>

<h2>Acceso Administrador</h2>
<form method="POST">
  <label>Usuario:</label><br>
  <input type="text" name="usuario" required><br><br>

  <label>Clave:</label><br>
  <input type="password" name="clave" required><br><br>

  <button type="submit">Ingresar</button>
</form>

<?php if (!empty($error)) echo "<p>$error</p>"; ?>

</body>
</html>