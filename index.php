<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dapekos</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
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
            <button class="btn btn-primary">tambah data</button>
        <?php }?>
        <div class="container table-responsive mt-3 pt-5">
            <table class="table table-bordered">
            <thead>
                <tr>
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
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <?php 
                    if(isset($_SESSION['active'])) {?>
                        <td>
                            <button href="" class="btn btn-primary">Edit</button>
                            <button href="" class="btn btn-danger">hapus</button>
                        </td>
                    <?php }?>
                </tr>
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