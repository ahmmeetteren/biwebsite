<?php
setcookie("cookie_name", "cookie_value", ["samesite" => "None"]);
session_start();
?>
<?php
$baglanti = mysqli_connect("localhost", "root", "", "karardesteksistemleri");
$baglanti->set_charset("utf8");
$hizmet_sorgu = mysqli_query($baglanti, "SELECT hizmet_ad FROM hizmetler");
$hizmet_sorgu2 = mysqli_query($baglanti, "SELECT hizmet_ad FROM hizmetler");
$hizmetGelir = mysqli_query($baglanti, "SELECT hizmetler.hizmet_ad, hizmetler.hizmet_gelir as hizmetGelir FROM hizmetler");
$hizmetGelir2 = mysqli_query($baglanti, "SELECT hizmetler.hizmet_ad, hizmetler.hizmet_gelir as hizmetGelir FROM hizmetler");
$hizmetMaliyet = mysqli_query($baglanti, "SELECT hizmetler.hizmet_ad, hizmetler.hizmet_maliyet as hizmetMaliyet FROM hizmetler");
$hizmetMaliyet2 = mysqli_query($baglanti, "SELECT hizmetler.hizmet_ad, hizmetler.hizmet_maliyet as hizmetMaliyet FROM hizmetler");

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
    <title>Hizmetler</title>
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
                        <a href="hizmetler.php" class="nav-link active">
                            <i class="fa-solid fa-bars-staggered pt-2"></i> <span style="font-size:12px;">Hizmetler</span>
                        </a>
                    </li>
                    <li class="nav-item ms-4">
						<a href="listeler.php" class="nav-link">
							<i class="fa-solid fa-list pt-2"></i> <span style="font-size:12px;">Listeler</span>
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
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="card shadow bg-body p-2 rounded-3">
                    <div class="card-header" style="background-color:#ffffff; border-bottom:none;">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="text-primary">Verilen Hizmet Sayısı</h5>
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
                                </div>
                                <span class="d-block text-sm text-muted">tüm hizmetler</span>
                            </div>
                            <div class="col-auto">
                                <i style="font-size:70px;" class="fa-solid fa-chart-simple text-primary"></i>
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
                                <h5 class="text-danger">Hizmet Maliyeti</h5>
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
                                </div>
                                <span class="d-block text-sm text-muted">ortalama maliyet</span>
                            </div>
                            <div class="col-auto">
                                <i style="font-size:70px;" class="fa-solid fa-wallet text-danger"></i>
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
                                <h5 class="text-success">Hizmet Getirileri</h5>
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
                                </div>
                                <span class="d-block text-sm text-muted">ortalama getiri</span>
                            </div>
                            <div class="col-auto">
                                <i style="font-size:70px;" class="fa-solid fa-turkish-lira-sign text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5 shadow p-4 bg-body">
            <div class="row">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active text-dark tab-size" data-bs-toggle="tab" data-bs-target="#hizmetlerinUcretleri" type="button">Hizmet Ücretleri</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-dark tab-size" data-bs-toggle="tab" data-bs-target="#hizmetlerinMaliyetleri" type="button">Hizmet Maliyetleri</button>
                    </li>
                </ul>
                <div class="tab-content h-75" id="myTabContent">
                    <div class="tab-pane fade show active" id="hizmetlerinUcretleri" role="tabpanel">
                        <div class="col-md">
                            <div class="chart" style="height:350px;">
                                <canvas id="personelChart"></canvas>
                                <script>
                                    var hizmetler = [<?php while ($sonuc2 = mysqli_fetch_assoc($hizmetGelir2)) {
                                                            echo '"' . $sonuc2['hizmet_ad'] . '",';
                                                        } ?>];
                                    var hizmetGelir = [<?php while ($sonuc = mysqli_fetch_assoc($hizmetGelir)) {
                                                            echo '"' . $sonuc['hizmetGelir'] . '",';
                                                        } ?>];
                                    var kanvas = document.getElementById('personelChart').getContext('2d');
                                    var chart = new Chart(kanvas, {
                                        type: "bar",
                                        data: {
                                            labels: hizmetler,
                                            datasets: [{
                                                label: 'Hizmet Ücretleri',
                                                backgroundColor: "rgb(25,135,84)",
                                                borderColor: "rgb(25,135,84)",
                                                data: hizmetGelir,

                                            }, ]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            legend: {
                                                labels: {
                                                    fontColor: 'rgb(52,58,64)',
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
                                                    gridLines: {
                                                        color: "rgba(255, 255, 255, 255)",
                                                    },
                                                    barPercentage: 0.3,
                                                    categoryPercentage: 0.3,
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
                    <div class="tab-pane fade" id="hizmetlerinMaliyetleri" role="tabpanel">
                        <div class="col-md">
                            <div class="chart-container" style="height:350px;">
                                <canvas id="hizmetMaliyet"></canvas>
                                <script>
                                    var hizmetler2 = [<?php while ($sonuc4 = mysqli_fetch_assoc($hizmetMaliyet)) {
                                                            echo '"' . $sonuc4['hizmet_ad'] . '",';
                                                        } ?>];
                                    var hizmetMaliyet = [<?php while ($sonuc3 = mysqli_fetch_assoc($hizmetMaliyet2)) {
                                                            echo '"' . $sonuc3['hizmetMaliyet'] . '",';
                                                        } ?>];
                                    var ctx = document.getElementById('hizmetMaliyet').getContext('2d');
                                    var chart = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: hizmetler2,
                                            datasets: [{
                                                label: 'Hizmet Maliyetleri',
                                                backgroundColor: "rgb(220,53,69)",
                                                borderColor: "rgb(220,53,69)",
                                                data: hizmetMaliyet,

                                            }, ]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            legend: {
                                                labels: {
                                                    fontColor: 'rgb(52,58,64)',
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
                                                    gridLines: {
                                                        color: "rgba(255, 255, 255, 255)",
                                                    },
                                                    barPercentage: 0.3,
                                                    categoryPercentage: 0.3,
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
        $.post("control/getirHizmetSayi.php", function(data, status) {
            $("#box-span1").html(data);
        });

        $.post("control/getirHizmetMaliyet.php", function(data, status) {
            $("#box-span2").html(data + "<i style='font-size:17px;'class='fa-solid fa-turkish-lira-sign ms-1'></i>");
        });

        $.post("control/getirHizmetGelir.php", function(data, status) {
            $("#box-span3").html(data + "<i style='font-size:17px;'class='fa-solid fa-turkish-lira-sign ms-1'></i>");
        });
    });
</script>

</html>