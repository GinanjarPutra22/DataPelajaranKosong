<?php
session_start();

$login_error = '';
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if ($password = $user['password']) { //ganti kalau encrypsi if(password_verify($password,$user['password']))
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['id_role'] = $user['id_role'];
            // var_dump($user['id_role']);die;
            if ($user['id_role'] != 1) {
                header("Location: ../admin/index.php"); 
            }else{
                header("Location: ../index.php"); 
            }
            exit();
        } else {
            $login_error = 'Password salah!';
        }
    } else {
        $login_error = 'Username tidak ditemukan!';
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
    <section class="vh-200" style="background-color: #9A616D;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-150">
            <div class="col col-xl-10">
                <div class="card" style="border-radius: 1rem;">
                <div class="row g-0">
                    <div class="col-md-6 col-lg-5 d-none d-md-block">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp"
                            alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                    </div>
                    <div class="col-md-6 col-lg-7 d-flex align-items-center">
                        <div class="card-body p-4 p-lg-5 text-black">
                            <form method="post" action="index.php">
                                <div class="d-flex align-items-center mb-3 pb-1">
                                    <i class="fas fa-cubes fa-2x" style="color: #ff6219;"></i>
                                    <span class="h1 fw-bold mb-0">PLP SMK 10 Surabaya</span>
                                </div>

                                <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Login Untuk Lakukan Rekap</h5>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="username">Username</label>
                                    <input type="text" id="username" name="username" class="form-control form-control-lg" />
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control form-control-lg" />
                                </div>
                                <?php if ($login_error): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= $login_error ?>
                                    </div>
                                <?php endif; ?>

                                <div class="pt-1 mb-4">
                                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </section>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</html>