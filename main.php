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
$kar_sorgu2 = mysqli_query($baglanti, "SELECT SUM(dep_ay.kar*12) as kar FROM departmanlar,dep_ay,aylar WHERE aylar.ay_id = dep_ay.ay_id AND dep_ay.dep_id = departmanlar.dep_id GROUP BY ay_ad");
$gid_sorgu2 = mysqli_query($baglanti, "SELECT SUM(depGid_ay.gider*12) as gider FROM departmanlar,depGid_ay,aylar WHERE aylar.ay_id = depGid_ay.ay_id AND depGid_ay.dep_id = departmanlar.dep_id GROUP BY ay_ad");
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
    <title>Anasayfa</title>
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
                        <a href="main.php" class="nav-link active">
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
            <div class="row mt-3 ms-0 ps-0">
                <div class="col">
                    <i class="fas fa-chevron-right"></i> <span class="fs-4 fw-bold">Genel Bilgiler</span>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center mt-5 mb-5">
            <div class="col-md-3 mb-4">
                <div class="card border-top-warning h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col me-2">
                                <div class="fw-bold mb-1" style="color:#0d85fd;">
                                    Personel Sayısı</div>
                                <div id="box-span1" class="h5 mb-0 fw-bold" style="color:#5a5c69;"></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fs-2" style="color:#0d85fd;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4 ms-xl-4">
                <div class="card border-top-danger h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col me-2">
                                <div class="fw-bold mb-1" style="color:#cb4335;">
                                    Değerlendirme</div>
                                <div id="box-span2" class="h5 mb-0 fw-bold" style="color:#5a5c69;"></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard fs-2" style="color:#cb4335;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4 ms-xl-4">
                <div class="card border-top-success h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col me-2">
                                <div class="fw-bold mb-1" style="color:#58d68d;">
                                    Müşteri Sayısı</div>
                                <div id="box-span3" class="h5 mb-0 fw-bold" style="color:#5a5c69;"></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-grin-beam fs-2" style="color:#58d68d;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 shadow p-4 bg-body">
            <div class="row">
                <div class="col mb-3">
                    <i class="fas fa-chevron-right"></i> <span class="fs-4 fw-bold">Şirket Grafikleri</span>
                </div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active text-dark tab-size" data-bs-toggle="tab" data-bs-target="#home" type="button">Gelirler</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-dark tab-size" data-bs-toggle="tab" data-bs-target="#contact" type="button">Giderler</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-dark tab-size" data-bs-toggle="tab" data-bs-target="#profile" type="button">Müşteri Sayıları</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-dark tab-size" data-bs-toggle="tab" data-bs-target="#GelirGiderLine" type="button">Gelir-Gider</button>
                    </li>
                </ul>
                <div class="tab-content h-75" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <div class="col-md">
                            <div class="chart" style=height:350px;>
                                <canvas id="personelChart"></canvas>
                                <script>
                                    var miktar = [<?php while ($sonuc2 = mysqli_fetch_assoc($kar_sorgu)) {
                                                        echo '"' . $sonuc2['kar'] . '",';
                                                    } ?>];
                                    var aylar = [<?php while ($sonuc = mysqli_fetch_assoc($ay_sorgu)) {
                                                        echo '"' . $sonuc['ay_ad'] . '",';
                                                    } ?>];
                                    var kanvas = document.getElementById('personelChart').getContext('2d');
                                    var chart = new Chart(kanvas, {
                                        type: "bar",
                                        data: {
                                            labels: aylar,
                                            datasets: [{
                                                label: 'Toplam Şirket Geliri',
                                                backgroundColor: "rgb(39, 174, 96)",
                                                borderColor: "rgb(39, 174, 96)",
                                                data: miktar,

                                            }]
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
                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <div class="col-md">
                            <div class="chart" style=height:350px;>
                                <canvas id="musteriChart"></canvas>
                                <script>
                                    var mus_sayi = [<?php while ($sonuc3 = mysqli_fetch_assoc($mus_sorgu)) {
                                                        echo '"' . $sonuc3['musteriSayi'] . '",';
                                                    } ?>];

                                    var kanvas2 = document.getElementById('musteriChart').getContext('2d');
                                    var chart2 = new Chart(kanvas2, {
                                        type: "bar",
                                        data: {
                                            labels: aylar,
                                            datasets: [{
                                                label: 'Toplam Müşteri',
                                                backgroundColor: "rgb(41, 128, 185)",
                                                borderColor: "rgb(41, 128, 185)",
                                                data: mus_sayi,

                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            legend: {
                                                labels: {
                                                    fontColor: 'rgb(52,58,64)'
                                                }
                                            },
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
                    <div class="tab-pane fade" id="contact" role="tabpanel">
                        <div class="col-md">
                            <div class="chart" style=height:350px;>
                                <canvas id="giderChart"></canvas>
                                <script>
                                    var gider = [<?php while ($sonuc4 = mysqli_fetch_assoc($gid_sorgu)) {
                                                        echo '"' . $sonuc4['gider'] . '",';
                                                    } ?>];

                                    var kanvas = document.getElementById('giderChart').getContext('2d');
                                    var chart = new Chart(kanvas, {
                                        type: "bar",
                                        data: {
                                            labels: aylar,
                                            datasets: [{
                                                label: 'Toplam Gider',
                                                backgroundColor: "rgb(231, 76, 60)",
                                                borderColor: "rgb(231, 76, 60)",
                                                data: gider,

                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            legend: {
                                                labels: {
                                                    fontColor: 'rgb(52,58,64)'
                                                }
                                            },
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
                    <div class="tab-pane fade" id="GelirGiderLine">
                        <div class="col-md">
                            <div class="chart-container" style="height:350px;">
                                <canvas id="gelir-gider"></canvas>
                                <script>
                                    var gider12 = [<?php while ($sonuc4 = mysqli_fetch_assoc($gid_sorgu2)) {
                                                        echo '"' . $sonuc4['gider'] . '",';
                                                    } ?>];
                                    var miktar12 = [<?php while ($sonuc2 = mysqli_fetch_assoc($kar_sorgu2)) {
                                                        echo '"' . $sonuc2['kar'] . '",';
                                                    } ?>];
                                    var kanvas12 = document.getElementById('gelir-gider').getContext('2d');
                                    var chart = new Chart(kanvas12, {
                                        type: "line",
                                        data: {
                                            labels: aylar,
                                            datasets: [{
                                                    fill: false,
                                                    label: 'Şirket Geliri',
                                                    backgroundColor: "rgb(39, 174, 96)",
                                                    borderColor: "rgb(39, 174, 96)",
                                                    data: miktar12,

                                                },
                                                {
                                                    fill: false,
                                                    label: 'Şirket Gider',
                                                    backgroundColor: "rgb(192, 57, 43)",
                                                    borderColor: "rgb(192, 57, 43)",
                                                    data: gider12,
                                                }
                                            ]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            legend: {
                                                labels: {
                                                    fontColor: 'rgb(52,58,64)'
                                                }
                                            },
                                            scales: {
                                                yAxes: [{
                                                    gridLines: {
                                                        color: "rgba(0, 0, 0, 0)",
                                                    },
                                                    ticks: {
                                                        fontColor: "rgb(52,58,64)",
                                                        beginAtZero: true,
                                                    }
                                                }],
                                                xAxes: [{
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
            </div>
        </div>
    </div>
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
<script>
    $(document).ready(function() {
        $.post("control/getirPersonel.php", function(data, status) {
            $("#box-span1").html(data);
        });

        $.post("control/getirDegerlendirme.php", function(data, status) {
            $("#box-span2").html(data + "/10");
        });

        $.post("control/getirMusteri.php", function(data, status) {
            $("#box-span3").html(data);
        });
    });
</script>

</html>
