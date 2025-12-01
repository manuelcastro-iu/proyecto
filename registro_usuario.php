<?php
include 'db.php';

$mensaje = '';
$registro_exitoso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
  $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
  $clave = mysqli_real_escape_string($conn, $_POST['clave']);

  $existe = mysqli_query($conn, "SELECT id FROM usuarios WHERE usuario = '$usuario'");
  if (mysqli_num_rows($existe) > 0) {
    $mensaje = "⚠️ El usuario ya existe.";
  } else {
    mysqli_query($conn, "INSERT INTO usuarios (nombre, usuario, clave) VALUES ('$nombre', '$usuario', '$clave')");
    $mensaje = "✅ Usuario registrado correctamente.";
    $registro_exitoso = true;
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro Usuario</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f6f8;
      padding: 40px;
    }
    .registro-box {
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
    .mensaje {
      text-align: center;
      margin-top: 15px;
      font-weight: bold;
    }
    .acceso {
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<div class="registro-box">
  <h2>📝 Registro de Usuario</h2>
  <form method="POST">
    <label>Nombre completo:</label>
    <input type="text" name="nombre" required>

    <label>Usuario:</label>
    <input type="text" name="usuario" required>

    <label>Clave:</label>
    <input type="password" name="clave" required>

    <button type="submit">Registrar</button>
  </form>

  <?php if (!empty($mensaje)) echo "<p class='mensaje'>$mensaje</p>"; ?>

  <?php if ($registro_exitoso): ?>
    <div class="acceso">
      <form action="login_usuario.php">
        <button type="submit">🔐 Ingresar con mi usuario</button>
      </form>
    </div>
  <?php endif; ?>
</div>

</body>
</html>