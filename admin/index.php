<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../koneksi.php';

// Ambil data pengguna
$sql_select = "SELECT * FROM dakos 
              INNER JOIN ruang ON dakos.id_ruang = ruang.id_ruang
              INNER JOIN mapel ON dakos.id_mapel = mapel.id_mapel
              INNER JOIN kelas ON dakos.id_kelas = kelas.id_kelas
              INNER JOIN guru ON dakos.id_guru = guru.id_guru
              INNER JOIN users ON dakos.id_user = users.id_user";
$result = $conn->query($sql_select);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- data table -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Dashboard</title>
    <style>
        body {
            background-color: #f0f2f5;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 1200px;
            width: 100%;
        }
        .card {
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .table-container {
            margin-top: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        .table thead th {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
    <?php 
    include 'nav.php';
    ?>
    <div class="container pt-5 pb-5">
        <div class="d-flex align-items-center mb-4">
            <h2 class="text-center m-0 flex-grow-1">Dashboard</h2>
        </div>
        <div class="table-container">
            <table class="table table-striped" id='datatablesSimple'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jam Pelajaran</th>
                        <th>Ruang</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Guru</th>
                        <th>Pencatat</th>
                        <th>Catatan</th>
                        <th>Waktu</th>
                        <!-- <th>Aksi</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no =1;
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['JP']) ?></td>
                            <td><?= htmlspecialchars($row['nama_ruang']) ?></td>
                            <td><?= htmlspecialchars($row['nama_mapel']) ?></td>
                            <td><?= htmlspecialchars($row['nama_kelas']) ?></td>
                            <td><?= htmlspecialchars($row['nama_guru']) ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['note']) ?></td>
                            <td><?= htmlspecialchars($row['waktu']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
<!-- data table -->
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="../datatables-simple-demo.js"></script>
</html>
