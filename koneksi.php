<?php
// Koneksi ke database
$host = 'clove.iixcp.rumahweb.net';
$user = 'ayof9739_sekop2';
$password = '@Sekop222';
$database = 'ayof9739_dapekos';
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>