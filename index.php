<?php
session_start();
include 'koneksi.php';

// Proses Tambah Data
if (isset($_POST['tmbh_dakos'])) {
    $JP_start = $_POST['jam_pertama'];
    $JP_end = $_POST['jam_terakhir'];
    $JP = "$JP_start-$JP_end";
    $id_ruang = $_POST['id_ruang'];
    $id_mapel = $_POST['id_mapel'];
    $id_kelas = $_POST['id_kelas'];
    $id_guru = $_POST['id_guru'];
    $id_user = $_SESSION['id_user'];
    $note = $_POST['note'];
    $waktu = date('Y-m-d');

    $sql = "INSERT INTO Dakos (JP, id_ruang, id_mapel, id_kelas, id_guru, id_user, note, waktu) 
            VALUES ('$JP', '$id_ruang', '$id_mapel', '$id_kelas', '$id_guru', '$id_user','$note','$waktu')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['hapus_dakos'])) {
    $id_dakos = $_GET['hapus_dakos'];

    $sql = "DELETE FROM Dakos WHERE id_dakos = '$id_dakos'";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // Redirect setelah berhasil hapus
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Query Data
$sql_dakos = "SELECT * FROM Dakos 
              INNER JOIN Ruang ON Dakos.id_ruang = Ruang.id_ruang
              INNER JOIN Mapel ON Dakos.id_mapel = Mapel.id_mapel
              INNER JOIN Kelas ON Dakos.id_kelas = Kelas.id_kelas
              INNER JOIN Guru ON Dakos.id_guru = Guru.id_guru
              INNER JOIN Users ON Dakos.id_user = Users.id_user
              WHERE Dakos.waktu = CURDATE()";
$dakos = $conn->query($sql_dakos);

$sql_ruang = "SELECT id_ruang, nama_ruang FROM Ruang";
$result_ruang = $conn->query($sql_ruang);

$sql_mapel = "SELECT id_mapel, nama_mapel FROM Mapel";
$result_mapel = $conn->query($sql_mapel);

$sql_kelas = "SELECT id_kelas, nama_kelas FROM Kelas";
$result_kelas = $conn->query($sql_kelas);

$sql_guru = "SELECT id_guru, nama_guru FROM Guru";
$result_guru = $conn->query($sql_guru);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dapekos</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script>
        function formatDate() {
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            const now = new Date();
            const dayName = days[now.getDay()];
            const day = now.getDate();
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();
            return `${dayName}, ${day} ${monthName} ${year}`;
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-fixed-top">
        <a class="navbar-brand" href="#">Dapekos</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <?php 
                    if(isset($_SESSION['id_role'])) {?>
                        <a class="btn btn-primary" href="auth/logout.php">Logout</a>
                    <?php }else{?>
                        <a class="btn btn-primary" href="auth/index.php">Login</a>
                    <?php }?>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5 pt-2">
        <div class="text-center mb-4">
            <h1>Selamat Datang di Dapekos</h1>
            <h5><p id="current-date"></p></h5>
        </div>
        <?php if(isset($_SESSION['active'])) {?>
            <button class="floating-btn" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="fas fa-plus"></i></button>
        <?php }?>

        <!-- Modal Start -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kelas Kosong</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="index.php">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Jam Pertama</label>
                            <select class="form-select form-control" name="jam_pertama" aria-label="Default select example">
                                <option value="">Pilih Jam Pertama</option>
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Jam Terakhir</label>
                            <select class="form-select form-control" name="jam_terakhir" aria-label="Default select example">
                                <option value="">Pilih Jam Terakhir</option>
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Ruang</label>
                    <select class="form-control" name="id_ruang" >
                        <option value="">Pilih Ruang</option>
                        <?php while ($row_ruang = $result_ruang->fetch_assoc()): ?>
                            <option value="<?= $row_ruang['id_ruang'] ?>"><?= $row_ruang['nama_ruang'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <select class="form-control" name="id_kelas" >
                        <option value="">Pilih Kelas</option>
                        <?php while ($row_kelas = $result_kelas->fetch_assoc()): ?>
                            <option value="<?= $row_kelas['id_kelas'] ?>"><?= $row_kelas['nama_kelas'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="NamaGuru" class="form-label">Nama Guru</label>
                    <select class="form-control" name="id_guru" >
                        <option value="">Pilih Guru</option>
                        <?php while ($row_guru = $result_guru->fetch_assoc()): ?>
                            <option value="<?= $row_guru['id_guru'] ?>"><?= $row_guru['nama_guru'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="NamaMapel" class="form-label">Nama Mata Pelajaran</label>
                    <select class="form-control" name="id_mapel" >
                        <option value="">Pilih Mata Pelajaran</option>
                        <?php while ($row_mapel = $result_mapel->fetch_assoc()): ?>
                            <option value="<?= $row_mapel['id_mapel'] ?>"><?= $row_mapel['nama_mapel'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="message-text" class="col-form-label text-bold">Message:</label>
                    <textarea class="form-control" name="note" id="message-text"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="tmbh_dakos" class="btn btn-primary">Simpan</button>
            </div>
                </form>
            </div>
        </div>
        </div>
        <!-- Modal End -->
        <div class="container table-responsive mt-3 pt-5">
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>JP</th>
                    <th>Kelas</th>
                    <th>Ruang</th>
                    <th>Guru</th>
                    <th>Mapel</th>
                    <th>Catatan</th>
                    <th>Pencatat</th>
                    <?php 
                    if(isset($_SESSION['active'])) {?>
                        <th>Aksi</th>
                    <?php }?>
                </tr>
            </thead>
            <tbody>
            <?php 
                $no = 1;
                if ($dakos->num_rows > 0): // Cek apakah ada data
                    while ($row = $dakos->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['JP'] ?></td>
                            <td><?= $row['nama_kelas'] ?></td>
                            <td><?= $row['nama_ruang'] ?></td>
                            <td><?= $row['nama_guru'] ?></td>
                            <td><?= $row['nama_mapel'] ?></td>
                            <td><?= $row['note'] ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td>
                                <!-- Tombol hapus -->
                                <?php if(isset($_SESSION['active'])) { ?>
                                    <a href="index.php?hapus_dakos=<?= $row['id_dakos'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
            <?php else: ?>
                <!-- Tampilkan jika tidak ada data -->
                <tr>
                    <td colspan="9" style="text-align: center;">Data Kosong</td>
                </tr>
            <?php endif; ?>

            </tbody>
        </table></div>



    <!-- Div kosong untuk menguji footer -->
    <div class="test-space"></div>
        
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Set tanggal saat ini
        document.getElementById('current-date').textContent = formatDate();
    </script>
</body>
<footer class="bg-dark text-white text-center py-3 mt-4">
        <p class="mb-0">
            &copy; 2024 Dapekos by Sekop2. Supported <a href="https://ayoarek.com" class="text-primary" target="_blank">Ayoarek.com</a>
        </p>
</footer>
</html>