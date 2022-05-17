<?php
setcookie("cookie_name", "cookie_value", ["samesite" => "None"]);
session_start();
?>
<?php
$baglanti = mysqli_connect("localhost", "root", "", "karardesteksistemleri");
$baglanti->set_charset("utf8");
$ay_sorgu = mysqli_query($baglanti, "SELECT ay_ad FROM aylar");


$departman_ad3 = mysqli_query($baglanti, "SELECT dep_ad FROM departmanlar");
$departman_ad = mysqli_query($baglanti, "SELECT dep_ad FROM departmanlar");

$departman1SorguGider = mysqli_query($baglanti, "SELECT depGid_ay.gider as gider FROM departmanlar,depGid_ay,aylar WHERE aylar.ay_id = depGid_ay.ay_id AND depGid_ay.dep_id = departmanlar.dep_id AND departmanlar.dep_id='100' GROUP BY ay_ad");
$departman2SorguGider = mysqli_query($baglanti, "SELECT depGid_ay.gider as gider FROM departmanlar,depGid_ay,aylar WHERE aylar.ay_id = depGid_ay.ay_id AND depGid_ay.dep_id = departmanlar.dep_id AND departmanlar.dep_id='101' GROUP BY ay_ad");
$departman3SorguGider = mysqli_query($baglanti, "SELECT depGid_ay.gider as gider FROM departmanlar,depGid_ay,aylar WHERE aylar.ay_id = depGid_ay.ay_id AND depGid_ay.dep_id = departmanlar.dep_id AND departmanlar.dep_id='102' GROUP BY ay_ad");

$departman1Gelir = mysqli_query($baglanti, "SELECT dep_ay.kar as gelir FROM departmanlar,dep_ay,aylar WHERE aylar.ay_id = dep_ay.ay_id AND dep_ay.dep_id=departmanlar.dep_id AND departmanlar.dep_id='100' GROUP BY ay_ad");
$departman2Gelir = mysqli_query($baglanti, "SELECT dep_ay.kar as gelir FROM departmanlar,dep_ay,aylar WHERE aylar.ay_id = dep_ay.ay_id AND dep_ay.dep_id=departmanlar.dep_id AND departmanlar.dep_id='101' GROUP BY ay_ad");
$departman3Gelir = mysqli_query($baglanti, "SELECT dep_ay.kar as gelir FROM departmanlar,dep_ay,aylar WHERE aylar.ay_id = dep_ay.ay_id AND dep_ay.dep_id=departmanlar.dep_id AND departmanlar.dep_id='102' GROUP BY ay_ad");

$musteri_sayisi = mysqli_query($baglanti, "SELECT dep_ad, COUNT(musteriler.mus_id) as musteriSayisi FROM musteriler,personel,departmanlar WHERE musteriler.per_id=personel.per_id AND departmanlar.dep_id=personel.dep_id GROUP BY departmanlar.dep_ad");
$personelSayisi = mysqli_query($baglanti, "SELECT dep_ad, COUNT(personel.per_id) as personelSayisi FROM personel,departmanlar WHERE departmanlar.dep_id=personel.dep_id GROUP BY departmanlar.dep_ad");
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/f6190b6e7c.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Departmanlar</title>
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
                        <a href="departmanlar.php" class="nav-link active">
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
                            <a href="control/logout.php" class="dropdown-item mt-1 py-2 ps-4" style="font-size:12px;"><i class="fa-solid fa-arrow-right-from-bracket me-1 mt-1"></i>Çıkış Yap</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="container-fluid">
            <div class="row mt-3 shadow p-4 mt-5">
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <i class="fas fa-chevron-right"></i> <span class="fs-4 fw-bold">Departmanların Mevcut Müşteri Sayıları</span>
                        </div>
                        <div class="col-md ms-5">
                            <div class="chart-container mt-sm-6">
                                <canvas class="ms-md-5" id="musteri-sayisi" style="height:300px; width:250px;"></canvas>
                                <script>
                                    var ctx2 = document.getElementById('musteri-sayisi').getContext('2d');
                                    var chart2 = new Chart(ctx2, {
                                        type: 'pie',
                                        data: {
                                            labels: [<?php while ($sonuc6 = mysqli_fetch_assoc($departman_ad3)) {
                                                            echo '"' . $sonuc6['dep_ad'] . '",';
                                                        } ?>],
                                            datasets: [{
                                                label: '',
                                                backgroundColor: [
                                                    "#1da1f2",
                                                    "#DC3545",
                                                    "#FFC107",

                                                ],
                                                data: [<?php while ($sonuc8 = mysqli_fetch_assoc($musteri_sayisi)) {
                                                            echo '"' . $sonuc8['musteriSayisi'] . '",';
                                                        } ?>]
                                            }]
                                        },
                                        options: {
                                            responsive: false,
                                            legend: {
                                                display: false,
                                                labels: {
                                                    fontColor: "#22242a",
                                                }
                                            }
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                        <div id="box-span1" class="fw-bold text-primary mb-1"></div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <i class="fas fa-chevron-right"></i> <span class="fs-4 fw-bold">Departmanların Mevcut Personel Sayıları</span>
                        </div>
                        <div class="col-md ms-5">
                            <div class="chart-container mt-sm-6">
                                <canvas class="ms-md-5" id="personelSayisi" style="height:300px; width:250px;"></canvas>
                                <script>
                                    var ctx2 = document.getElementById('personelSayisi').getContext('2d');
                                    var chart2 = new Chart(ctx2, {
                                        type: 'pie',
                                        data: {
                                            labels: [<?php while ($sonuc1 = mysqli_fetch_assoc($departman_ad)) {
                                                            echo '"' . $sonuc1['dep_ad'] . '",';
                                                        } ?>],
                                            datasets: [{
                                                label: '',
                                                backgroundColor: [
                                                    "#1da1f2",
                                                    "#DC3545",
                                                    "#FFC107",

                                                ],
                                                data: [<?php while ($sonuc2 = mysqli_fetch_assoc($personelSayisi)) {
                                                            echo '"' . $sonuc2['personelSayisi'] . '",';
                                                        } ?>]
                                            }]
                                        },
                                        options: {
                                            responsive: false,
                                            legend: {
                                                display: false,
                                                labels: {
                                                    fontColor: "#22242a",
                                                }
                                            }
                                        }
                                    });
                                </script>
                                <div id="box-span2" class="fw-bold text-primary mb-1"></div>
                            </div>
                        </div>
                        <div id="box-span1" class="fw-bold text-primary mb-1"></div>
                    </div>
                </div>
            </div>
            <div class="row shadow p-4 mt-5">
                <div class="row">
                    <div class="mb-3">
                        <i class="fas fa-chevron-right"></i> <span class="fs-4 fw-bold">Departman Grafikleri</span>
                    </div>
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="nav-item">
                            <button class="nav-link active text-dark tab-size" data-bs-toggle="tab" data-bs-target="#depGider" type="button">Departman Giderleri</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link text-dark tab-size" data-bs-toggle="tab" data-bs-target="#depGelir" type="button">Departman Gelirleri</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="depGider">
                            <div class="col-md">
                                <div class="chart-container" style="height:350px;">
                                    <canvas id="departman-gider"></canvas>
                                    <script>
                                        var aylar = [<?php while ($sonuc31 = mysqli_fetch_assoc($ay_sorgu)) {
                                                            echo '"' . $sonuc31['ay_ad'] . '",';
                                                        } ?>];
                                        var departman100Gider = [<?php while ($sonuc5 = mysqli_fetch_assoc($departman1SorguGider)) {
                                                                        echo '"' . $sonuc5['gider'] . '",';
                                                                    } ?>];
                                        var departman101Gider = [<?php while ($sonuc10 = mysqli_fetch_assoc($departman2SorguGider)) {
                                                                        echo '"' . $sonuc10['gider'] . '",';
                                                                    } ?>];
                                        var departman102Gider = [<?php while ($sonuc11 = mysqli_fetch_assoc($departman3SorguGider)) {
                                                                        echo '"' . $sonuc11['gider'] . '",';
                                                                    } ?>];
                                        var ctx = document.getElementById('departman-gider').getContext('2d');
                                        var chart = new Chart(ctx, {
                                            type: 'bar',
                                            data: {
                                                labels: aylar,
                                                datasets: [{
                                                        label: 'Back-End',
                                                        backgroundColor: "rgb(255,193,7)",
                                                        borderColor: "rgb(255,193,7)",
                                                        data: departman100Gider,

                                                    },
                                                    {
                                                        label: 'Finans',
                                                        backgroundColor: "rgb(220,53,69)",
                                                        borderColor: "rgb(220,53,69)",
                                                        data: departman101Gider,
                                                    },
                                                    {
                                                        label: 'Front-End',
                                                        backgroundColor: "rgb(29,161,242)",
                                                        borderColor: "rgb(29,161,242)",
                                                        data: departman102Gider,
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
                                                        ticks: {
                                                            fontColor: "rgb(52,58,64)",
                                                            beginAtZero: true,
                                                        }
                                                    }],
                                                    xAxes: [{
                                                        barPercentage: 0.5,
                                                        categoryPercentage: 0.5,
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
                        <div class="tab-pane fade" id="depGelir">
                            <div class="col-md">
                                <div class="chart-container" style="height:350px;">
                                    <canvas id="departmanGelir"></canvas>
                                    <script>
                                        var departman100Gelir = [<?php while ($sonuc133 = mysqli_fetch_assoc($departman1Gelir)) {
                                                                        echo '"' . $sonuc133['gelir'] . '",';
                                                                    } ?>];
                                        var departman101Gelir = [<?php while ($sonuc155 = mysqli_fetch_assoc($departman2Gelir)) {
                                                                        echo '"' . $sonuc155['gelir'] . '",';
                                                                    } ?>];
                                        var departman102Gelir = [<?php while ($sonuc177 = mysqli_fetch_assoc($departman3Gelir)) {
                                                                        echo '"' . $sonuc177['gelir'] . '",';
                                                                    } ?>];
                                        var ctx31 = document.getElementById('departmanGelir').getContext('2d');
                                        var chart31 = new Chart(ctx31, {
                                            type: 'bar',
                                            data: {
                                                labels: aylar,
                                                datasets: [{
                                                        fill: false,
                                                        label: 'Back-End',
                                                        backgroundColor: "rgb(255,193,7)",
                                                        borderColor: "rgb(255,193,7)",
                                                        data: departman100Gelir,

                                                    },
                                                    {
                                                        fill: false,
                                                        label: 'Finans',
                                                        backgroundColor: "rgb(220,53,69)",
                                                        borderColor: "rgb(220,53,69)",
                                                        data: departman101Gelir,
                                                    },
                                                    {
                                                        fill: false,
                                                        label: 'Front-End',
                                                        backgroundColor: "rgb(29,161,242)",
                                                        borderColor: "rgb(29,161,242)",
                                                        data: departman102Gelir,
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
                                                        ticks: {
                                                            fontColor: "rgb(52,58,64)",
                                                            beginAtZero: true,
                                                        }
                                                    }],
                                                    xAxes: [{
                                                        barPercentage: 0.5,
                                                        categoryPercentage: 0.5,
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
    </div>

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
        $.post("control/getirMusteri.php", function(data, status) {
            $("#box-span1").html("Müşteri Sayısı:" + " " + data);
        });
        $.post("control/getirPersonel.php", function(data, status) {
            $("#box-span2").html("Personel Sayısı:" + " " + data);
        });
    });
</script>

</html>