<?php
setcookie("cookie_name", "cookie_value", ["samesite" => "None"]);
session_start();
?>
<?php
$baglanti = mysqli_connect("localhost", "root", "", "karardesteksistemleri");
$baglanti->set_charset("utf8");
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
    <title>İşlemler</title>
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
                    <li class="nav-item ms-4">
                        <a href="listeler.php" class="nav-link">
                            <i class="fa-solid fa-list pt-2"></i> <span style="font-size:12px;">Listeler</span>
                        </a>
                    </li>
                    <li class="nav-item ms-4">
                        <a href="islemler.php" class="nav-link active">
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
            <div class="row mt-5">
                <div class="col-md-5 h-75 p-4 shadow rounded-3" style="background-color:#ffffff;">
                    <div class="mb-3">
                        <a class="text-decoration-none"><i class="fas fa-chevron-right me-1"></i><span class="fs-4 fw-bold">Müşteri Ekle</span></a>
                    </div>
                    <div class="mt-0">
                        <form action="" method="post" id="Musteriform">
                            <div class="form-group mb-2">
                                <select class="form-control" name="per_id">
                                    <option selected>Müşteriden sorumlu olan personel ID seçin.</option>
                                    <?php
                                    $stmt = "SELECT `per_id` FROM `personel` WHERE 1";
                                    $result = mysqli_query($baglanti, $stmt) or die(mysqli_error($baglanti));
                                    while (list($category) = mysqli_fetch_row($result)) {
                                        echo '<option value="' . $category . '">' . $category . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <input class="form-control" placeholder="Müşteri AD" type="text" name="mus_ad">
                            </div>
                            <div class="form-group mb-2">
                                <input class="form-control" placeholder="Müşteri Soyad" type="text" name="mus_soyad">
                            </div>
                            <div class="form-group mb-2">
                                <input class="form-control" placeholder="Değerlendirme" type="text" name="degerlendirme">
                            </div>
                            <button type="submit" class="btn btn-primary w-100" id="btnSubmit">Ekle</button>
                        </form>
                    </div>
                    <?php
                    if ($_POST) {
                        $personelID = $_POST['per_id'];
                        $musteriAd = $_POST['mus_ad'];
                        $musteriSoyad = $_POST['mus_soyad'];
                        $degerlendirme = $_POST['degerlendirme'];
                        if ($musteriAd != "" && $musteriSoyad != "") {
                            if ($baglanti) {
                                $sorgu = mysqli_query($baglanti, "INSERT INTO musteriler(per_id, mus_ad, mus_soyad, degerlendirme) VALUES('$personelID','$musteriAd','$musteriSoyad','$degerlendirme')");
                            } else {
                                die("Bağlantı sorunu oluştu.");
                            };
                        };
                    };

                    ?>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-5 shadow rounded-3 p-4" style="background-color:#ffffff;">
                    <div class="mb-3">
                        <a class="text-decoration-none text-danger"><i class="fas fa-chevron-right me-1"></i><span class="fs-4 fw-bold">Personel Ekle</span></a>
                    </div>
                    <div>
                        <form class="fs-sm-2" action="control/save.php" method="get" id="form">
                            <input class="form-control" type="hidden" name="id">
                            <div class="form-group mb-2 row">
                                <div class="col-md-6"><input placeholder="ID" class="form-control" type="text" name="per_id"></div>
                                <div class="col-md-6"><input placeholder="Departman ID" class="form-control" type="text" name="dep_id"></div>
                            </div>
                            <div class="form-group mb-2 row">
                                <div class="col-md-6"><input placeholder="Personel AD" class="form-control" type="text" name="per_ad"></div>
                                <div class="col-md-6"><input placeholder="Personel Soyad" class="form-control" type="text" name="per_soyad"></div>
                            </div>
                            <div class="form-group mb-2 row">
                                <div class="col-md-6"><input placeholder="Başarılı Görev" class="form-control" type="text" name="basarili_gorev"></div>
                                <div class="col-md-6"><input placeholder="Başarısız Görev" class="form-control" type="text" name="basarisiz_gorev"></div>
                            </div>
                            <div class="form-group mb-2 row">
                                <div class="col-md-6"><input placeholder="Personel Maaş" class="form-control" type="text" name="per_maas"></div>
                                <div class="col-md-6"><input placeholder="Çalışılan Gün" class="form-control" type="text" name="calisilanGun"></div>
                            </div>
                            <button type="submit" class="btn btn-danger p-1 mt-2 px-3 w-100" id="btnSubmit"><span class="fs-sm-2">Ekle</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row mt-5 justify-content-center">
                <div class="col-md-6 shadow bg-body p-4 rounded-3">
                    <div class="mb-3">
                        <a class="text-decoration-none text-success"><i class="fas fa-chevron-right me-1"></i><span class="fs-4 fw-bold">Hizmet Ekle</span></a>
                    </div>
                    <form class="" action="control/hizmetEkle.php" method="get">
                        <div class="form-group mb-3">
                            <input placeholder="Hizmet Adı" class="form-control" type="text" name="hizmet_ad">
                        </div>
                        <div class="mb-3">
                            <select class="form-control" name="dep_id">
                                <option selected>Hizmetin ilişkili olduğu departman</option>
                                <?php
                                $baglanti = mysqli_connect("localhost", "root", "", "karardesteksistemleri");
                                $sorgu = $baglanti->query("SELECT * FROM `departmanlar` WHERE 1");
                                while ($sonuc = $sorgu->fetch_assoc()) {
                                    $departmanID = $sonuc['dep_id'];
                                    $departmanAD = $sonuc['dep_ad'];
                                    echo '<option value="' . $departmanID . '">' . $departmanAD . ' (' . $departmanID . ')</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <input placeholder="Hizmet Maliyeti" class="form-control" type="text" name="hizmet_maliyet">
                        </div>
                        <div class="mb-3">
                            <input placeholder="Hizmet Geliri" class="form-control" type="text" name="hizmet_gelir">
                        </div>
                        <button class="btn btn-success w-100 mb-2" type="submit">Ekle</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
<footer class="d-flex justify-content-between align-items-center pt-3 my-4 border-top footer-margin mt-auto">
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