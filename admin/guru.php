<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../koneksi.php';

$tambah_data_error = '';
$tambah_data_success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_guru = $_POST['nama_guru'];

    // Validasi input
    if (empty($nama_guru)) {
        $tambah_data_error = 'field harus diisi!';
    }else {
        $sql_check = "SELECT * FROM guru WHERE nama_guru = ?";
        if ($stmt_check = $conn->prepare($sql_check)) {
            $stmt_check->bind_param("s", $nama_guru);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                $tambah_data_error = 'Nama Guru sudah Ada!';
            } else {
                // Insert user baru
                $sql_insert = "INSERT INTO guru (nama_guru) VALUES (?)";
                if ($stmt_insert = $conn->prepare($sql_insert)) {
                    $stmt_insert->bind_param("s", $nama_guru);

                    if ($stmt_insert->execute()) {
                        $tambah_data_success = 'Tambah Data berhasil!';
                    } else {
                        $tambah_data_error = 'Terjadi kesalahan saat Menambahkan Data. Silakan coba lagi.';
                    }
                    $stmt_insert->close();
                } else {
                    $tambah_data_error = 'Gagal mempersiapkan query untuk Menambahkan Data: ' . $conn->error;
                }
            }
            $stmt_check->close();
        } else {
            $tambah_data_error = 'Gagal mempersiapkan query untuk cek Guru: ' . $conn->error;
        }
    }
}

// Proses Hapus Data
if (isset($_GET['hapus_guru'])) {
    $id_guru = $_GET['hapus_guru'];

    $sql = "DELETE FROM guru WHERE id_guru = '$id_guru'";
    if ($conn->query($sql) === TRUE) {
        header("Location: guru.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil data pengguna
$sql_select = "SELECT * FROM guru ORDER BY nama_guru";
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
    <title>Data Guru</title>
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
            <!-- <a href="javascript:history.back()" class="btn btn-secondary back-button">
                <i class="bi bi-arrow-left"></i> Kembali
            </a> -->
            <h2 class="text-center m-0 flex-grow-1">Data Guru</h2>
        </div>
        <div class="card">
            <div class="card-body">
                <form method="post" action="guru.php">
                    <div class="mb-3">
                        <label class="form-label" for="nama_guru">Nama Guru</label>
                        <input type="text" id="nama_guru" name="nama_guru" class="form-control" required>
                    </div>

                    <?php if ($tambah_data_error): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $tambah_data_error ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($tambah_data_success): ?>
                        <div class="alert alert-success" role="alert">
                            <?= $tambah_data_success ?>
                        </div>
                    <?php endif; ?>

                    <div class="d-grid mt-4">
                        <button class="btn btn-primary" type="submit">Tambah Data</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-container">
            <table class=" table-striped" id='datatablesSimple'>
                <thead class="table-group-divider">
                    <tr>
                        <th>ID</th>
                        <th>Nama Guru</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider"> 
                    <?php 
                    $no= 1;
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama_guru']) ?></td>
                            <td>
                                <a href="guru.php?hapus_guru=<?= $row['id_guru'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
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
