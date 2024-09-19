<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../koneksi.php';

$register_error = '';
$register_success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $NoWA = $_POST['NoWA']; // Kolom NoWa
    $id_role = $_POST['id_role']; // Kolom id_role

    // Validasi input
    if (empty($nama) || empty($username) || empty($password) || empty($confirm_password) || empty($NoWA) || empty($id_role)) {
        $register_error = 'Semua field harus diisi!';
    } elseif ($password !== $confirm_password) {
        $register_error = 'Password dan konfirmasi password tidak cocok!';
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah username sudah ada
        $sql_check = "SELECT * FROM users WHERE username = ?";
        if ($stmt_check = $conn->prepare($sql_check)) {
            $stmt_check->bind_param("s", $username);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                $register_error = 'Username sudah digunakan!';
            } else {
                // Insert user baru
                $sql_insert = "INSERT INTO users (nama, username, password, NoWA, id_role) VALUES (?, ?, ?, ?, ?)";
                if ($stmt_insert = $conn->prepare($sql_insert)) {
                    $stmt_insert->bind_param("ssssi", $nama, $username, $hashed_password, $NoWA, $id_role);

                    if ($stmt_insert->execute()) {
                        $register_success = 'Registrasi berhasil! Silakan <a href="users.php">lihat data</a>.';
                    } else {
                        $register_error = 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.';
                    }
                    $stmt_insert->close();
                } else {
                    $register_error = 'Gagal mempersiapkan query untuk registrasi: ' . $conn->error;
                }
            }
            $stmt_check->close();
        } else {
            $register_error = 'Gagal mempersiapkan query untuk cek username: ' . $conn->error;
        }
    }
}

// Ambil data pengguna
$sql_select = "SELECT * FROM users";
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
    <title>Registrasi dan Data Pengguna</title>
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
    <?php include 'nav.php';?>
    <div class="container pt-5 pb-5">
        <div class="d-flex align-items-center mb-4">
            <!-- <a href="javascript:history.back()" class="btn btn-secondary back-button">
                <i class="bi bi-arrow-left"></i> Kembali
            </a> -->
            <h2 class="text-center m-0 flex-grow-1">Data Pengguna</h2>
        </div>
        <div class="card">
            <div class="card-body">
                <form method="post" action="users.php">
                    <div class="mb-3">
                        <label class="form-label" for="nama">Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="confirm_password">Konfirmasi Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="NoWA">No WhatsApp</label>
                        <input type="text" id="NoWA" name="NoWA" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="id_role">Role</label>
                        <select id="id_role" name="id_role" class="form-select" required>
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="1">User</option>
                            <option value="2">Admin</option>
                        </select>
                    </div>

                    <?php if ($register_error): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $register_error ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($register_success): ?>
                        <div class="alert alert-success" role="alert">
                            <?= $register_success ?>
                        </div>
                    <?php endif; ?>

                    <div class="d-grid mt-4">
                        <button class="btn btn-primary" type="submit">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-container">
            <table id='datatablesSimple'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>No WhatsApp</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id_user']) ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['NoWA']) ?></td>
                            <td><?= htmlspecialchars($row['id_role']) ?></td>
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
