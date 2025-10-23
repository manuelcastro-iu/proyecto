<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ubicación del Bus - Logittransport</title>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f6f8;
      margin: 0;
      padding: 0;
      color: #333;
    }
    header {
      background-color: #1e3a8a;
      color: white;
      padding: 30px;
      text-align: center;
    }
    header h1 {
      margin: 0;
      font-size: 28px;
    }
    .container {
      max-width: 900px;
      margin: 30px auto;
      padding: 20px;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    iframe {
      width: 100%;
      height: 450px;
      border: none;
      border-radius: 6px;
    }
    .reloj {
      text-align: right;
      font-size: 16px;
      color: #555;
      margin-bottom: 15px;
    }
  </style>
  <script>
    function actualizarReloj() {
      const reloj = document.getElementById('reloj');
      const ahora = new Date();
      const hora = ahora.toLocaleTimeString('es-CL', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
      reloj.textContent = "🕒 Hora actual: " + hora;
    }
    setInterval(actualizarReloj, 1000);
    window.onload = actualizarReloj;
  </script>
</head>
<body>

<header>
  <h1>🗺️ Ubicación del Bus</h1>
</header>

<div class="container">
  <div class="reloj" id="reloj"></div>

  <iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d14806.388123259783!2d-72.5987857642985!3d-38.725621858255714!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e0!4m5!1s0x9614d3b4c4707a95%3A0x5bb3a1c96cef4268!2sSantiago%2C%20Temuco%2C%20Araucan%C3%ADa!3m2!1d-38.7186768!2d-72.5689452!4m5!1s0x9614d3cec21a2223%3A0xc2fa8887ff008408!2sTemuco%2C%20Araucan%C3%ADa!3m2!1d-38.736628599999996!2d-72.5949577!5e0!3m2!1ses-419!2scl!4v1758642090347!5m2!1ses-419!2scl"
    allowfullscreen=""
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade">
  </iframe>
</div>

</body>
</html>