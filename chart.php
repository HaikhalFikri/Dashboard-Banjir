<?php
$conn = new mysqli("localhost", "root", "", "banjir");
if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "Koneksi gagal"]);
  exit();
}

header('Content-Type: application/json');

$sql = "SELECT tanggal, suhu, kelembapan FROM sensor ORDER BY id DESC LIMIT 10";
$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
  $data[] = [
    "tanggal" => $row["tanggal"],
    "suhu" => floatval($row["suhu"]),
    "kelembapan" => floatval($row["kelembapan"])
  ];
}

echo json_encode(array_reverse($data)); // urutan waktu lama ke baru
$conn->close();
?>
