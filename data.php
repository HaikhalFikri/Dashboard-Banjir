<?php
$conn = new mysqli("localhost", "root", "", "banjir");
if ($conn->connect_error) {
  http_response_code(500);
  header('Content-Type: application/json');
  echo json_encode(["error" => "Koneksi gagal"]);
  exit();
}

header('Content-Type: application/json');

$query = "SELECT tanggal, suhu, kelembapan, ketinggian_air FROM sensor ORDER BY id DESC LIMIT 1";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  echo json_encode([
    "tanggal" => $row["tanggal"],
    "suhu" => $row["suhu"],
    "kelembapan" => $row["kelembapan"],
    "ketinggian" => $row["ketinggian_air"]
  ]);
} else {
  echo json_encode([
    "tanggal" => "-",
    "suhu" => "-",
    "kelembapan" => "-",
    "ketinggian" => "-"
  ]);
}

$conn->close();
?>
