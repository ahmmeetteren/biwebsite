<?php
setcookie("cookie_name", "cookie_value", ["samesite" => "None"]);
session_start();
?>
<?php
$baglanti = mysqli_connect("localhost", "root", "", "karardesteksistemleri");
$baglanti->set_charset("utf8");
$ay_sorgu = mysqli_query($baglanti, "SELECT ay_ad FROM aylar");
$gorev_sorgu = mysqli_query($baglanti, "SELECT gorev_ay.basariliGorevSayi as basariliGorevSayi FROM gorev_ay,aylar WHERE aylar.ay_id = gorev_ay.ay_id GROUP BY ay_ad");
$gorev_sorgu2 = mysqli_query($baglanti, "SELECT gorev_ay.basarisizGorevSayi as basarisizGorevSayi FROM gorev_ay,aylar WHERE aylar.ay_id = gorev_ay.ay_id GROUP BY ay_ad");
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
    <title>Performans</title>
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
                        <a href="gorevler.php" class="nav-link active">
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
            <div class="row mt-3 shadow bg-body p-4 mt-5">
                <div class="row">
                    <div class="col-md">
                        <div class="mb-3">
                            <i class="fas fa-chevron-right"></i> <span class="fs-4 fw-bold">Çalışma Performansı</span>
                        </div>
                        <div class="chart">
                            <canvas id="gorevChart" style="height:350px;"></canvas>
                            <script>
                                var aylar = [<?php while ($sorgu2 = mysqli_fetch_assoc($ay_sorgu)) {
                                                    echo '"' . $sorgu2['ay_ad'] . '",';
                                                } ?>];
                                var gorev_sayi = [<?php while ($sorgu = mysqli_fetch_assoc($gorev_sorgu)) {
                                                        echo '"' . $sorgu['basariliGorevSayi'] . '",';
                                                    } ?>];
                                var gorev_sayi2 = [<?php while ($sorgu3 = mysqli_fetch_assoc($gorev_sorgu2)) {
                                                        echo '"' . $sorgu3['basarisizGorevSayi'] . '",';
                                                    } ?>];
                                var kanvas = document.getElementById('gorevChart').getContext('2d');
                                var chart = new Chart(kanvas, {
                                    type: "bar",
                                    data: {
                                        labels: aylar,
                                        datasets: [{
                                                label: "Başarılı",
                                                backgroundColor: "rgb(116,120,246)",
                                                borderColor: "rgb(116,120,246)",
                                                data: gorev_sayi,
                                            },
                                            {
                                                label: "Başarısız",
                                                backgroundColor: "rgb(214,220,228)",
                                                borderColor: "rgb(214,220,228)",
                                                data: gorev_sayi2,
                                            }
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    fontColor: "rgb(52,58,64)",
                                                    beginAtZero: true,
                                                }
                                            }],
                                            xAxes: [{
                                                barPercentage: 0.4,
                                                categoryPercentage: 0.4,
                                                gridLines: {
                                                    color: "rgba(0, 0, 0, 0)",
                                                },
                                                ticks: {
                                                    fontColor: "rgb(52,58,64)"
                                                }
                                            }]
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="card shadow bg-body p-2">
                        <div class="card-header" style="background-color:#ffffff; border-bottom:none;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>Başarılı Görevler</h5>
                                </div>
                            </div>
                            <div class="d-block text-white text-sm mt-1">
                                <span>başarılı</span>
                                <span>arasında</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="d-flex align-items-center">
                                        <div><span id="box-span1" class="h3 d-block mb-0"></span></div>
                                        <div class="d-flex align-items-center ms-3 mt-n1"><span class="badge badge-xs text-danger"><i class="fa-solid fa-arrow-down"></i> 8%</span></div>
                                    </div>
                                    <span class="d-block text-sm text-muted">bir önceki aya göre</span>
                                </div>
                                <div class="col-auto">
                                    <canvas id="Chart" width="100" height="50"></canvas>
                                    <script>
                                        const ctx12 = document.getElementById('Chart').getContext('2d');
                                        const chart12 = new Chart(ctx12, {
                                            type: 'line',
                                            data: {
                                                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                                                datasets: [{
                                                    fill: false,
                                                    data: [435, 321, 532, 801, 1231, 1098, 732, 321, 451, 482, 513, 397]
                                                }]
                                            },
                                            options: {
                                                responsive: false,
                                                legend: {
                                                    display: false
                                                },
                                                elements: {
                                                    line: {
                                                        borderColor: '#8588f7',
                                                        borderWidth: 2
                                                    },
                                                    point: {
                                                        radius: 0
                                                    }
                                                },
                                                tooltips: {
                                                    enabled: false
                                                },
                                                scales: {
                                                    yAxes: [{
                                                        display: false
                                                    }],
                                                    xAxes: [{
                                                        display: false
                                                    }]
                                                }
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow bg-body p-2">
                        <div class="card-header" style="background-color:#ffffff; border-bottom:none;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>Başarısız Görevler</h5>
                                </div>
                            </div>
                            <div class="d-block text-sm mt-1" style="color:#ffffff;">
                                <span>başarılı</span>
                                <span>arasında</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="d-flex align-items-center">
                                        <div><span id="box-span2" class="h3 d-block mb-0"></span></div>
                                        <div class="d-flex align-items-center ms-3 mt-n1"><span class="badge badge-xs text-success"><i class="fa-solid fa-arrow-down"></i> 25%</span></div>
                                    </div>
                                    <span class="d-block text-sm text-muted">bir önceki aya göre</span>
                                </div>
                                <div class="col-auto">
                                    <canvas id="Chart2" width="100" height="50"></canvas>
                                    <script>
                                        const ctx122 = document.getElementById('Chart2').getContext('2d');
                                        const chart122 = new Chart(ctx122, {
                                            type: 'line',
                                            data: {
                                                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                                                datasets: [{
                                                    fill: false,
                                                    data: [335, 221, 632, 901, 2231, 998, 632, 221, 451, 582, 613, 297]
                                                }]
                                            },
                                            options: {
                                                responsive: false,
                                                legend: {
                                                    display: false
                                                },
                                                elements: {
                                                    line: {
                                                        borderColor: '#8588f7',
                                                        borderWidth: 2
                                                    },
                                                    point: {
                                                        radius: 0
                                                    }
                                                },
                                                tooltips: {
                                                    enabled: false
                                                },
                                                scales: {
                                                    yAxes: [{
                                                        display: false
                                                    }],
                                                    xAxes: [{
                                                        display: false
                                                    }]
                                                }
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow bg-body p-2">
                        <div class="card-header" style="background-color:#ffffff; border-bottom:none;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>Ortalama Personel Maaşı</h5>
                                </div>
                            </div>
                            <div class="d-block text-sm mt-1" style="color:#ffffff;">
                                <span>personel ortalamasıdır</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="d-flex align-items-center">
                                        <div><span class="h3 d-block mb-0" id="box-span3"></span></div>
                                        <div class="d-flex align-items-center ms-3 mt-n1"><span class="badge badge-xs text-success"><i class="fa-solid fa-arrow-up"></i> 12%</span></div>
                                    </div>
                                    <span class="d-block text-sm text-muted">2020 yılına göre</span>
                                </div>
                                <div class="col-auto">
                                    <canvas id="Chart3" width="100" height="50"></canvas>
                                    <script>
                                        const ctx123 = document.getElementById('Chart3').getContext('2d');
                                        const chart123 = new Chart(ctx123, {
                                            type: 'bar',
                                            data: {
                                                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                                                datasets: [{
                                                    backgroundColor: "#8588f7",
                                                    fill: false,
                                                    data: [435, 321, 532, 801, 1231, 1098, 732, 321, 451, 482, 513, 397]
                                                }]
                                            },
                                            options: {
                                                responsive: false,
                                                legend: {
                                                    display: false
                                                },
                                                elements: {
                                                    line: {
                                                        borderColor: '#8588f7',
                                                        borderWidth: 2
                                                    },
                                                    point: {
                                                        radius: 0
                                                    }
                                                },
                                                tooltips: {
                                                    enabled: false
                                                },
                                                scales: {
                                                    yAxes: [{
                                                        display: false
                                                    }],
                                                    xAxes: [{
                                                        barPercentage: 0.4,
                                                        display: false
                                                    }]
                                                }
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="mb-3">
                        <a class="text-decoration-none btn text-light btn btn-success w-100" data-bs-toggle="collapse" href="#collapseExample"><i class="fas fa-chevron-down float-start mt-2"></i> <span class="fs-4 fw-bold">Başarılı Bitirilen Görevler</span></a>
                    </div>
                    <div class="table-responsive collapse shadow p-3 bg-body" id="collapseExample">
                        <table class="table table-borderless">
                            <tr>
                                <th>AD</th>
                                <th>SOYAD</th>
                                <th>BAŞARILI GÖREV</th>
                            </tr>
                            <?php
                            if ($baglanti) {
                                $sorgu4 = $baglanti->query("SELECT * FROM personel ORDER BY personel.basarili_gorev DESC");
                            } else {
                                echo "Başarısız sorgu.";
                            }
                            while ($sonuc2 = $sorgu4->fetch_assoc()) {
                                $personelAd2 = $sonuc2['per_ad'];
                                $personelSoyad2 = $sonuc2['per_soyad'];
                                $basariliGorev = $sonuc2['basarili_gorev'];
                            ?>
                                <tr>
                                    <td><?php echo $personelAd2; ?></td>
                                    <td><?php echo $personelSoyad2; ?></td>
                                    <td><?php echo $basariliGorev; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                        <div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <a class="text-decoration-none btn text-light btn btn-success w-100" data-bs-toggle="collapse" href="#collapseExample2"><i class="fas fa-chevron-down float-start mt-2"></i> <span class="fs-4 fw-bold">En Çok Çalışanlar</span></a>
                    </div>
                    <div class="table-responsive collapse shadow p-3 bg-body" id="collapseExample2">
                        <table class="table table-borderless">
                            <tr>
                                <th>AD</th>
                                <th>SOYAD</th>
                                <th>ÇALIŞILAN GÜN</th>
                            </tr>
                            <?php
                            if ($baglanti) {
                                $sorgu4 = $baglanti->query("SELECT * FROM personel ORDER BY personel.calisilanGun DESC");
                            } else {
                                echo "Başarısız sorgu.";
                            }
                            while ($sonuc3 = $sorgu4->fetch_assoc()) {
                                $personelAd3 = $sonuc3['per_ad'];
                                $personelSoyad3 = $sonuc3['per_soyad'];
                                $calisilanGun = $sonuc3['calisilanGun'];
                            ?>
                                <tr>
                                    <td><?php echo $personelAd3; ?></td>
                                    <td><?php echo $personelSoyad3; ?></td>
                                    <td><?php echo $calisilanGun; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                        <div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <a class="text-decoration-none btn text-light btn btn-success w-100" data-bs-toggle="collapse" href="#collapseExample1"><i class="fas fa-chevron-down float-start mt-2"></i> <span class="fs-4 fw-bold">En Çok Maaş Alanlar</span></a>
                    </div>
                    <div class="table-responsive collapse shadow p-3 bg-body" id="collapseExample1">
                        <table class="table table-borderless">
                            <tr>
                                <th>AD</th>
                                <th>SOYAD</th>
                                <th>ALINAN MAAŞ</th>
                            </tr>
                            <?php
                            if ($baglanti) {
                                $sorgu3 = $baglanti->query("SELECT * FROM personel ORDER BY personel.per_maas DESC");
                            } else {
                                echo "Başarısız sorgu.";
                            }
                            while ($sonuc2 = $sorgu3->fetch_assoc()) {
                                $personelAd2 = $sonuc2['per_ad'];
                                $personelSoyad2 = $sonuc2['per_soyad'];
                                $personelMaas = $sonuc2['per_maas'];
                            ?>
                                <tr>
                                    <td><?php echo $personelAd2; ?></td>
                                    <td><?php echo $personelSoyad2; ?></td>
                                    <td><?php echo $personelMaas; ?></td>
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
            <div class="row mt-2">
                <div class="col-md">
                    <div class="mb-3">
                        <a class="text-decoration-none btn text-light btn btn-success w-100" data-bs-toggle="collapse" href="#collapseExample3"><i class="fas fa-chevron-down float-start mt-2"></i> <span class="fs-4 fw-bold">En Başarılı Personeller</span></a>
                    </div>
                    <div class="table-responsive collapse shadow p-3 bg-body" id="collapseExample3">
                        <table class="table table-borderless">
                            <tr>
                                <th>AD</th>
                                <th>SOYAD</th>
                                <th>VERİMLİLİK</th>
                            </tr>
                            <?php
                            if ($baglanti) {
                                $sorgu51 = $baglanti->query("SELECT per_ad, per_soyad, verimlilik_puan FROM personel,puan WHERE personel.per_id = puan.per_id ORDER BY puan.verimlilik_puan DESC");
                            } else {
                                echo "Başarısız sorgu.";
                            }
                            while ($sonuc41 = $sorgu51->fetch_assoc()) {
                                $personelAd14 = $sonuc41['per_ad'];
                                $personelSoyad14 = $sonuc41['per_soyad'];
                                $verimlilikPuan = $sonuc41['verimlilik_puan'];
                            ?>
                                <tr>
                                    <td><?php echo $personelAd14; ?></td>
                                    <td><?php echo $personelSoyad14; ?></td>
                                    <td><?php echo $verimlilikPuan; ?></td>
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
    </div>
    <script>
        $(document).ready(function() {
            $.post("control/getirBasariliGorev.php", function(data, status) {
                $("#box-span1").html(data);
            });

            $.post("control/getirBasarisizGorev.php", function(data, status) {
                $("#box-span2").html(data);
            });

            $.post("control/getirPersonelMaas.php", function(data, status) {
                $("#box-span3").html(data);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
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
</html>
