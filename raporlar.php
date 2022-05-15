<?php
setcookie("cookie_name", "cookie_value", ["samesite" => "None"]);
session_start();
?>
<?php
$baglanti = mysqli_connect("localhost", "root", "", "karardesteksistemleri");
$baglanti->set_charset("utf8");
$ay_sorgu = mysqli_query($baglanti, "SELECT ay_ad FROM aylar");
$mus_sorgu = mysqli_query($baglanti, "SELECT mus_ay.musteriSayi as musteriSayi FROM mus_ay,aylar WHERE aylar.ay_id = mus_ay.ay_id GROUP BY ay_ad");
$kar_sorgu = mysqli_query($baglanti, "SELECT SUM(dep_ay.kar*12) as kar FROM departmanlar,dep_ay,aylar WHERE aylar.ay_id = dep_ay.ay_id AND dep_ay.dep_id = departmanlar.dep_id GROUP BY ay_ad");
$gid_sorgu = mysqli_query($baglanti, "SELECT SUM(depGid_ay.gider*12) as gider FROM departmanlar,depGid_ay,aylar WHERE aylar.ay_id = depGid_ay.ay_id AND depGid_ay.dep_id = departmanlar.dep_id GROUP BY ay_ad");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="index.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/f6190b6e7c.js" crossorigin="anonymous"></script>
    <title>Personeller</title>
</head>

<body style="background-color:#F8F9F9; font-family: 'Kanit', sans-serif;">
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
                        <a href="raporlar.php" class="nav-link active">
                            <i class="fa-solid fa-chart-simple pt-2"></i> <span style="font-size:12px;">Raporlar</span>
                        </a>
                    </li>
                    <li class="nav-item ms-4">
                        <a href="listeler.php" class="nav-link">
                            <i class="fa-solid fa-list pt-2"></i> <span style="font-size:12px;">Listeler</span>
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
                        <a href="islemler.php" class="nav-link">
                            <i class="fa-solid fa-plus pt-2"></i> <span style="font-size:12px;">İşlemler</span>
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
                            <a href="control/logout.php" class="dropdown-item mt-1 py-2 ps-4" style="font-size:12px;"><i class="fa-solid fa-arrow-right-from-bracket me-1 mt-1"></i>Çıkış Yap</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="container-fluid">
            <div class="row shadow mt-5 p-4 bg-body rounded-3">
                <div class="report">
                    <div class="mb-3">
                        <i class="fas fa-chevron-right"></i> <span class="fs-4 fw-bold">Personel Raporu</span>
                    </div>
                    <div class="table-responsive ">
                        <table class="table fs-sm-2" style="text-align:center">
                            <tr>
                                <th>AD</th>
                                <th>SOYAD</th>
                                <th>DEPARTMAN</th>
                                <th>DEPARTMAN ID</th>
                                <th>MAAŞ</th>
                                <th>VERİMLİLİK ORANI</th>
                                <th>BAŞARI ORANI</th>
                                <th>YILLIK PERFORMANS</th>
                            </tr>
                            <?php
                            if ($baglanti) {
                                $sorgu = $baglanti->query("SELECT ROUND(personel.basarili_gorev/personel.basarisiz_gorev,1) as basariOrani, personel.per_id, personel.per_ad, personel.per_soyad, departmanlar.dep_ad, departmanlar.dep_id, personel.per_maas, puan.verimlilik_puan FROM personel, puan, departmanlar WHERE personel.per_id=puan.per_id AND personel.dep_id=departmanlar.dep_id");
                            } else {
                                echo "Başarısız sorgu.";
                            }
                            while ($sonuc = $sorgu->fetch_assoc()) {
                                $departmanAd = $sonuc['dep_ad'];
                                $departmanID = $sonuc['dep_id'];
                                $personelAd = $sonuc['per_ad'];
                                $personelMaas = $sonuc['per_maas'];
                                $personelSoyad = $sonuc['per_soyad'];
                                $verimlilikPuan = $sonuc['verimlilik_puan'];
                                $basariOrani = $sonuc['basariOrani'];
                            ?>
                                <tr>
                                    <td class="personelcol"><?php echo $personelAd; ?></td>
                                    <td class="personelcol"><?php echo $personelSoyad; ?></td>
                                    <td class="personelcol"><?php echo $departmanAd; ?></td>
                                    <td class="personelcol"><?php echo $departmanID; ?></td>
                                    <td class="personelcol"><?php echo $personelMaas; ?></td>

                                    <td class="personelcol"><?php if ($verimlilikPuan > 0 && $verimlilikPuan < 41) {
                                                                echo 'Düşük <i class="fa-solid fa-angle-down text-danger"></i>';
                                                            } elseif ($verimlilikPuan > 40 && $verimlilikPuan < 76) {
                                                                echo 'Orta <i class="fa-solid fa-grip-lines text-warning"></i>';
                                                            } elseif ($verimlilikPuan > 75) {
                                                                echo 'Yüksek <i class="fa-solid fa-angle-up text-success"></i>';
                                                            } else {
                                                                echo "Belirsiz";
                                                            };;;; ?></td>

                                    <td class="personelcol"><?php if ($basariOrani > 0 && $basariOrani < 2) {
                                                                echo 'Çok Düşük <i class="fa-solid fa-angles-down text-danger"></i>';
                                                            } elseif ($basariOrani > 1 && $basariOrani < 3) {
                                                                echo 'Düşük <i class="fa-solid fa-angle-down text-danger"></i>';
                                                            } elseif ($basariOrani > 2 && $basariOrani < 6) {
                                                                echo 'Orta <i class="fa-solid fa-grip-lines text-warning"></i>';
                                                            } elseif (5 < $basariOrani) {
                                                                echo 'Yüksek <i class="fa-solid fa-angle-up text-success"></i>';
                                                            } else {
                                                                echo "Belirsiz";
                                                            };;;;; ?></td>

                                    <td class="personelcol"><?php if ($basariOrani > 0 && $basariOrani < 2 && $verimlilikPuan > 0 && $verimlilikPuan < 41) {
                                                                echo 'Çok Düşük Performans <i class="fa-solid fa-angles-down text-danger"></i>';
                                                            } elseif ($basariOrani > 5 && $basariOrani < 11 && $verimlilikPuan > 40 && $verimlilikPuan < 76) {
                                                                echo 'Ortalama Performans <i class="fa-solid fa-grip-lines text-warning"></i>';
                                                            } elseif (5 < $basariOrani && $verimlilikPuan > 75) {
                                                                echo 'Yüksek Performans <i class="fa-solid fa-angle-up text-success"></i>';
                                                            } elseif (($basariOrani > 0 && $basariOrani < 2) || ($basariOrani > 1 && $basariOrani < 3)) {
                                                                echo 'Düşük Performans <i class="fa-solid fa-angle-down text-danger"></i>';
                                                            } elseif (($basariOrani > 2 && $basariOrani < 6) && $verimlilikPuan > 75) {
                                                                echo 'Yüksek Performans <i class="fa-solid fa-angle-up text-success"></i>';
                                                            } elseif (($basariOrani > 2 && $basariOrani < 6) && ($verimlilikPuan > 0 && $verimlilikPuan < 41)) {
                                                                echo 'Düşük Performans <i class="fa-solid fa-angle-down text-danger"></i>';
                                                            } else {
                                                                echo 'Ortalama Performans <i class="fa-solid fa-grip-lines text-warning"></i>';
                                                            };;;;;;;; ?></td>

                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row shadow mt-5 p-4 bg-body rounded-3">
                <div class="report">
                    <div class="mb-3">
                        <i class="fas fa-chevron-right"></i> <span class="fs-4 fw-bold">Departman Raporu</span>
                    </div>
                    <div class="table-responsive ">
                        <table class="table fs-sm-2" style="text-align:center">
                            <tr>
                                <th>ID</th>
                                <th>DEPARTMAN</th>
                                <th>GELİR</th>
                                <th>GİDER</th>
                                <th>KÂR</th>
                                <th>KÂR YÜZDESİ</th>
                                <th>KÂR RAPORU</th>
                            </tr>
                            <?php
                            if ($baglanti) {
                                $sorgu2 = $baglanti->query("SELECT departmanlar.dep_id, departmanlar.dep_ad, SUM(dep_ay.kar) as gelir, (SELECT SUM(depgid_ay.gider)) as gider, (SELECT SUM(dep_ay.kar) - SUM(depgid_ay.gider)) as kar, ROUND((SELECT (SELECT SUM(dep_ay.kar) - SUM(depgid_ay.gider))*100)/SUM(depgid_ay.gider),1) as karOrani FROM departmanlar,aylar,dep_ay,depgid_ay WHERE departmanlar.dep_id = dep_ay.dep_id AND departmanlar.dep_id = depgid_ay.dep_id AND aylar.ay_id = dep_ay.ay_id AND aylar.ay_id = depgid_ay.ay_id GROUP BY departmanlar.dep_id");
                            } else {
                                echo "Başarısız sorgu.";
                            }
                            while ($sonuc2 = $sorgu2->fetch_assoc()) {
                                $departmanAd2 = $sonuc2['dep_ad'];
                                $departmanID2 = $sonuc2['dep_id'];
                                $departmanGelir = $sonuc2['gelir'];
                                $departmanGider = $sonuc2['gider'];
                                $departmanKar = $sonuc2['kar'];
                                $departmanKarOrani = $sonuc2['karOrani'];
                            ?>
                                <tr>
                                    <td><?php echo $departmanID2; ?></td>
                                    <td><?php echo $departmanAd2; ?></td>
                                    <td><?php echo "$departmanGelir<i class='fa-solid fa-turkish-lira-sign ms-1 mb-3 fs-8'></i>"; ?></td>
                                    <td><?php echo "$departmanGider<i class='fa-solid fa-turkish-lira-sign ms-1 mb-3 fs-8'></i>"; ?></td>
                                    <td><?php echo "$departmanKar<i class='fa-solid fa-turkish-lira-sign ms-1 mb-3 fs-8'></i>"; ?></td>
                                    <td><?php echo "%$departmanKarOrani"; ?></td>
                                    <td><?php if ($departmanKarOrani > 0 && $departmanKarOrani < 10) {
                                                                echo 'Düşük Kâr <i class="fa-solid fa-angle-down text-danger"></i>';
                                                            } elseif ($departmanKarOrani > 10 && $departmanKarOrani < 25) {
                                                                echo 'Ortalama Kâr <i class="fa-solid fa-grip-lines text-warning"></i>';
                                                            } elseif ($departmanKarOrani > 25) {
                                                                echo 'Yüksek Kâr <i class="fa-solid fa-angle-up text-success"></i>';
                                                            } else {
                                                                echo "Belirsiz";
                                                            };;;; ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
    </ul>
</footer>

</html>