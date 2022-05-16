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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Listeler</title>
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
                        <a href="raporlar.php" class="nav-link">
                            <i class="fa-solid fa-chart-simple pt-2"></i> <span style="font-size:12px;">Raporlar</span>
                        </a>
                    </li>
                    <li class="nav-item ms-4">
                        <a href="listeler.php" class="nav-link active">
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
            <div class="row shadow rounded-3 p-3 bg-body mt-5">
                <div class="col-md">
                    <div class="mb-3">
                        <i class="fas fa-chevron-right"></i> <span class="fs-4 fw-bold">Müşteri Listesi</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless fs-sm-2 table-striped" style="text-align:center;">
                            <tr style="background-color:#6c79e0;">
                                <th class="text-white">Müşteri Adı</th>
                                <th class="text-white">Müşteri Soyadı</th>
                                <th class="text-white">İlgili Personel</th>
                                <th class="text-white">Değerlendirme Notu</th>
                                <th></th>
                            </tr>
                            <?php
                            if ($baglanti) {
                                $sorgu = $baglanti->query("SELECT * FROM musteriler,personel WHERE personel.per_id = musteriler.per_id GROUP BY musteriler.mus_id");
                            } else {
                                echo "Başarısız sorgu.";
                            }
                            while ($sonuc = $sorgu->fetch_assoc()) {
                                $musteriID = $sonuc['mus_id'];
                                $musteriAd = $sonuc['mus_ad'];
                                $musteriSoyad = $sonuc['mus_soyad'];
                                $atananPersonelAd = $sonuc['per_ad'];
                                $atananPersonelSoyad = $sonuc['per_soyad'];
                                $degerlendirme = $sonuc['degerlendirme'];
                            ?>
                                <tr>
                                    <td><?php echo $musteriAd; ?></td>
                                    <td><?php echo $musteriSoyad; ?></td>
                                    <td><?php echo $atananPersonelAd . " " . $atananPersonelSoyad; ?></td>
                                    <td><?php echo $degerlendirme; ?></td>
                                    <td class="d-flex justify-content-end">
                                        <a class="btn btn-warning me-0 " type="button" href="duzenleMusteri.php?id=<?php echo $musteriID; ?>"><span style="font-size:10px;"><i class="fa-solid fa-gears"></i></span></a>
                                        <a class="btn btn-danger ms-1" href="control/silMusteri.php?id=<?php echo $musteriID; ?>"><span style="font-size:10px;"><i class="fa-solid fa-trash-can"></i></span></a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row shadow rounded-3 p-3 bg-body mt-5">
                <div class="row mt-3">
                    <div class="col-md">
                        <div class="mb-3">
                            <i class="fas fa-chevron-right"></i> <span class="fs-4 fw-bold">Personel Listesi</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table fs-sm-2 table-striped table-borderless" style="text-align:center">
                                <tr style="background-color:#cb4335;">
                                    <th class="text-white">Personel Numarası</th>
                                    <th class="text-white">Adı</th>
                                    <th class="text-white">Soyadı</th>
                                    <th class="text-white">Departman</th>
                                    <th class="text-white">Departman Numarası</th>
                                    <th class="text-white">Maaş Tutarı</th>
                                    <th class="text-white">Verimlilik Puanı</th>
                                    <th></th>
                                </tr>
                                <?php
                                if ($baglanti) {
                                    $sorgu = $baglanti->query("SELECT personel.per_id, personel.per_ad, personel.per_soyad, departmanlar.dep_ad, personel.per_maas, departmanlar.dep_id, puan.verimlilik_puan FROM personel, puan, departmanlar WHERE personel.per_id=puan.per_id AND personel.dep_id=departmanlar.dep_id GROUP BY personel.per_id");
                                } else {
                                    echo "Başarısız sorgu.";
                                }
                                while ($sonuc = $sorgu->fetch_assoc()) {
                                    $departmanAd = $sonuc['dep_ad'];
                                    $personelAd = $sonuc['per_ad'];
                                    $personelMaas = $sonuc['per_maas'];
                                    $personelSoyad = $sonuc['per_soyad'];
                                    $verimlilikPuan = $sonuc['verimlilik_puan'];
                                    $personelID = $sonuc['per_id'];
                                    $departmanID = $sonuc['dep_id'];
                                ?>
                                    <tr>
                                        <td><?php echo $personelID; ?></td>
                                        <td><?php echo $personelAd; ?></td>
                                        <td><?php echo $personelSoyad; ?></td>
                                        <td><?php echo $departmanAd; ?></td>
                                        <td><?php echo $departmanID; ?></td>
                                        <td><?php echo "$personelMaas<i class='fa-solid fa-turkish-lira-sign ms-1 mb-3 fs-8'></i>" ?></td>
                                        <td><?php echo $verimlilikPuan; ?></td>
                                        <td class="d-flex justify-content-end">
                                            <a class="btn btn-warning me-2" type="button" href="duzenlePersonel.php?id=<?php echo $personelID; ?>"><span style="font-size:10px;"><i class="fa-solid fa-gears"></i></span></a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row shadow rounded-3 p-3 bg-body mt-5">
                <div class="row mt-3">
                    <div class="col-md">
                        <div class="mb-3">
                            <i class="fas fa-chevron-right"></i> <span class="fs-4 fw-bold">Yönetici Listesi</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table fs-sm-2 table-striped table-borderless" style="text-align:center">
                                <tr style="background-color:#58d68d;">
                                    <th class="text-white">Yönetici Adı</th>
                                    <th class="text-white">Yönetici Soyadı</th>
                                    <th class="text-white">Sorumlu Olduğu Departman</th>
                                    <th class="text-white">E-Mail Adresi</th>
                                    <th class="text-white">Telefon Numarası</th>
                                    <th class="text-white">Sabit Telefon</th>
                                    <th class="text-white">Kayıtlı Adresi</th>
                                </tr>
                                <?php
                                if ($baglanti) {
                                    $sorgu3 = $baglanti->query("SELECT yoneticiler.yon_ad, yoneticiler.yon_soyad, departmanlar.dep_ad, yoneticiler.email, yoneticiler.cepTelefonu, yoneticiler.sabitTelefon, yoneticiler.adres FROM yoneticiler, departmanlar WHERE yoneticiler.dep_id=departmanlar.dep_id GROUP BY yoneticiler.yon_id");
                                } else {
                                    echo "Başarısız sorgu.";
                                }
                                while ($sonuc3 = $sorgu3->fetch_assoc()) {
                                    $departmanAd3 = $sonuc3['dep_ad'];
                                    $yoneticiAd = $sonuc3['yon_ad'];
                                    $yoneticiSoyad = $sonuc3['yon_soyad'];
                                    $email = $sonuc3['email'];
                                    $cepTelefonu = $sonuc3['cepTelefonu'];
                                    $sabitTelefon = $sonuc3['sabitTelefon'];
                                    $adres = $sonuc3['adres'];
                                ?>
                                    <tr>
                                        <td class="personelcol"><?php echo $yoneticiAd; ?></td>
                                        <td class="personelcol"><?php echo $yoneticiSoyad; ?></td>
                                        <td class="personelcol"><?php echo $departmanAd3; ?></td>
                                        <td class="personelcol"><?php echo $email; ?></td>
                                        <td class="personelcol"><?php echo $cepTelefonu; ?></td>
                                        <td class="personelcol"><?php echo $sabitTelefon; ?></td>
                                        <td class="personelcol"><?php echo $adres; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
<footer class="d-flex justify-content-between align-items-center pt-3 my-4 border-top">
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
</html>
