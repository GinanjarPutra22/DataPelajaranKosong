<!-- nav.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-fixed-top">
    <a class="navbar-brand" href="#">Dapekos</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <?php 
                if(isset($_SESSION['id_role'])) { ?>
                    <a class="btn btn-primary" href="auth/logout.php">Logout</a>
                <?php } else { ?>
                    <a class="btn btn-primary" href="auth/index.php">Login</a>
                <?php } ?>
            </li>
        </ul>
    </div>
</nav>
