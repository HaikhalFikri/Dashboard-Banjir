<?php
$koneksi = new mysqli("localhost", "root", "", "banjir");
header('Content-Type: application/json');

if ($koneksi->connect_error) {
  echo json_encode(["error" => "Koneksi gagal"]);
  exit();
}

$sql = "SELECT 
          DATE(tanggal) AS tanggal,
          ROUND(AVG(ketinggian_air), 2) AS rata_ketinggian,
          ROUND(AVG(suhu), 2) AS rata_suhu,
          ROUND(AVG(kelembapan), 2) AS rata_kelembapan
        FROM sensor
        GROUP BY DATE(tanggal)
        ORDER BY tanggal DESC
        LIMIT 7";

$result = $koneksi->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
  $data[] = [
    "tanggal" => $row["tanggal"],
    "ketinggian" => $row["rata_ketinggian"],
    "suhu" => $row["rata_suhu"],
    "kelembapan" => $row["rata_kelembapan"]
  ];
}

echo json_encode($data);
$koneksi->close();
?>
