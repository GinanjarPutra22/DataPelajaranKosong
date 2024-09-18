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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Tambah Data</button>
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
                <form>
<!-- JAm -->
                <div class="d-flex flex-row justify-content-between">
                <div class="form-group d-flex flex-column">
                    <label for="recipient-name" class="col-form-label">Jam Pertama</label>
                    <select class="form-select form-control" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="form-group d-flex flex-column">
                    <label for="recipient-name" class="col-form-label">Jam Terakhir</label>
                    <select class="form-select form-control" aria-label="Default select example">
                        <option selected>Pilih Jam Terakir</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                </div>
<!-- Ruang -->
                <div class="form-group d-flex flex-column">
                    <label for="recipient-name" class="col-form-label">Ruang Kelas</label>
                    <select class="form-select form-control" aria-label="Default select example">
                        <option selected>Pilih Kelas</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                
                <!-- Nama Guru -->
                <div class="mb-3">
                    <label for="NamaGuru" class="form-label">Nama Guru</label>
                    <input type="text" class="form-control" id="NamaGuru" placeholder="Masukan Nama Guru">
                </div>

                  <!-- Mapel -->
                  <div class="mb-3">
                    <label for="Mapel" class="form-label">Mata Pelajaran</label>
                    <input type="text" class="form-control" id="Mapel" placeholder="Masukan Mata Pelajaran">
                </div>

                <div class="form-group">
                    <label for="message-text" class="col-form-label text-bold">Message:</label>
                    <textarea class="form-control" id="message-text"></textarea>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Catatan</button>
            </div>
            </div>
        </div>
        </div>
        <!-- Modal End -->
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