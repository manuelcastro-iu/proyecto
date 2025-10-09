<?php
include '../db.php';
$result = mysqli_query($conn, "SELECT u.*, b.placa FROM ubicaciones u JOIN buses b ON u.bus_id = b.id");
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}
echo json_encode($data);