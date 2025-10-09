const map = L.map('map').setView([-38.2329, -72.3311], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

async function cargarUbicaciones() {
  const res = await fetch('ubicaciones.php');
  const buses = await res.json();
  buses.forEach(bus => {
    L.marker([bus.latitud, bus.longitud])
      .addTo(map)
      .bindPopup(`Bus ${bus.placa}`);
  });
}

cargarUbicaciones();
setInterval(cargarUbicaciones, 10000);