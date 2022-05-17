<?php

$baglanti = mysqli_connect("localhost", "root", "", "karardesteksistemleri");
$baglanti->set_charset("utf8");

session_start();
$user_id = $_SESSION['id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../index.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/f6190b6e7c.js" crossorigin="anonymous"></script>
    <title>Yönetici Profili</title>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark pt-0" style="background-color:#22242a;">
        <div class="container">
            <a href="main.php" class="navbar-brand fw-bold ms-3 me-5" style="text-decoration:none;"><i class="text-light">AY</i><i style="color:#1da1f2;">TECH</i></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbarCollapse">
                <ul class="navbar-nav">
                    <li class="nav-item ms-4">
                        <a href="main.php" class="nav-link">
                            <i class="fas fa-home pt-2"></i> <span style="font-size:12px;">Anasayfa</span>
                        </a>
                    </li>
                    <li class="nav-item ms-4">
                        <a href="raporlar.php" class="nav-link">
                            <i class="fa-solid fa-chart-simple pt-2"></i> <span style="font-size:12px;">Raporlar</span>
                        </a>
                    </li>
                    <li class="nav-item ms-4">
                        <a href="departmanlar.php" class="nav-link">
                            <i class="fas fa-industry pt-2"></i> <span style="font-size:12px;">Departmanlar</span>
                        </a>
                    </li>
                    <li class="nav-item ms-4">
                        <a href="gorevler.php" class="nav-link">
                            <i class="fa-solid fa-bars-progress pt-2"></i> <span style="font-size:12px;">Performans</span>
                        </a>
                    </li>
                    <li class="nav-item ms-4">
                        <a href="hizmetler.php" class="nav-link">
                            <i class="fa-solid fa-bars-staggered pt-2"></i> <span style="font-size:12px;">Hizmetler</span>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" data-bs-toggle="dropdown">
                            <span class="ms-2 fw-bold" style="font-family: 'Kanit', sans-serif; font-size:12px;">Merhaba <?php echo $_SESSION["ad"] ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-dark animate slideIn">
                            <a href="profil.php" class="dropdown-item py-2 ps-4" style="font-size:12px;"><i class="fa-solid fa-user me-1 mt-1"></i> Profil</a>
                            <a href="../control/logout.php" class="dropdown-item mt-1 py-2 ps-4" style="font-size:12px;"><i class="fa-solid fa-arrow-right-from-bracket me-1 mt-1"></i>Çıkış Yap</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="d-flex align-items-center justify-content-center" style="padding:2rem; min-height: 100vh;">
        <?php
        $sorgu = mysqli_query($baglanti, "SELECT * FROM yoneticiler WHERE yon_id='" . $user_id . "'");
        $row = mysqli_fetch_assoc($sorgu);
        $sorgu2 = mysqli_query($baglanti, "SELECT * FROM departmanlar");
        $row2 = mysqli_fetch_assoc($sorgu2);
        ?>
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <img src="../img/ahmet.jpg" class="rounded-circle" width="150">
                    <div class="mt-3">
                        <h4><?= $row['yon_ad']; ?></h4>
                        <p class="text-secondary mb-1"><?= $row2['dep_ad']; ?></p>
                        <p class="text-muted font-size-sm"><?= $row['email']; ?></p>
                        <a href="profil_guncelle.php" class="btn btn-primary py-2" style="font-size:12px;">Profili Güncelle</a>
                        <a class="btn btn-danger" href="control/silYonetici.php?id=<?php echo $user_id; ?>"><span style="font-size:12px;">Hesabımı Sil</span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ms-4">
            <div class="card mb-3 py-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Ad ve Soyad</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $row['yon_ad']; ?> <?= $row['yon_soyad']; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $row['email']; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Cep Telefonu</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $row['cepTelefonu']; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Sabit Telefon</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $row['sabitTelefon']; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Adres</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $row['adres']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
<footer class="d-flex justify-content-between align-items-center pt-3 my-4 border-top footer-margin">
    <div class="col-md-4">
        <a href="main.php" class="navbar-brand fw-bold text-decoration-none"><i class="text-dark">AY</i><i style="color:#1da1f2;">TECH</i></a>
        <span class="text-muted">© 2022 Tüm Hakları Saklıdır</span>
    </div>
    <ul class="nav col-md-4 d-flex justify-content-end">
        <li>
            <a class="text-muted" target="_blank" href="https://www.instagram.com/ahmmeetteren/?hl=tr"><i class="fa-brands fa-instagram fs-4"></i></a>
        </li>
        <li>
            <a class="text-muted" target="_blank" href="https://github.com/ahmmeetteren"><i class="fa-brands fa-github fs-4 ms-3"></i></a>
        </li>
        <li>
            <a class="text-muted" target="_blank" href="https://github.com/ahmmeetteren"><i class="fa-brands fa-linkedin-in fs-4 ms-3"></i></a>
        </li>
    </ul>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</html>