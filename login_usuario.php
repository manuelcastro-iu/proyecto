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
      $_SESSION['rol'] = 'usuario';
      header('Location: menu_usuario.php');
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
  <title>Login Usuario</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f6f8;
      padding: 40px;
    }
    .login-box {
      max-width: 400px;
      margin: auto;
      background-color: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #1e3a8a;
    }
    label {
      font-weight: bold;
      display: block;
      margin-top: 15px;
    }
    input {
      width: 100%;
      padding: 12px;
      margin-top: 5px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }
    button {
      width: 100%;
      margin-top: 20px;
      padding: 12px;
      background-color: #1e3a8a;
      color: white;
      border: none;
      border-radius: 4px;
      font-weight: bold;
      cursor: pointer;
    }
    button:hover {
      background-color: #3b5fc4;
    }
    .error {
      color: red;
      text-align: center;
      margin-top: 15px;
    }
    .registro {
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<div class="login-box">
  <h2>🎟️ Acceso Usuario</h2>
  <form method="POST">
    <label>Usuario:</label>
    <input type="text" name="usuario" required>

    <label>Clave:</label>
    <input type="password" name="clave" required>

    <button type="submit">Ingresar</button>
  </form>

  <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

  <div class="registro">
    <p>¿No eres usuario?</p>
    <form action="registro_usuario.php">
      <button type="submit">Agregar Usuario</button>
    </form>
  </div>
</div>

</body>
</html>