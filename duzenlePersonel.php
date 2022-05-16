<?php
setcookie("cookie_name", "cookie_value", ["samesite" => "None"]);
session_start();
?>
<?php
$baglanti = mysqli_connect("localhost", "root", "", "karardesteksistemleri");
$baglanti->set_charset("utf8");
if (mysqli_connect_error()) {
	echo mysqli_connect_error();
	exit;
}

?>

<!DOCTYPE HTML>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="index.css" rel="stylesheet"/>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/f6190b6e7c.js" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<title>Personel Düzenle</title>
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
	<section class="d-flex align-items-center justify-content-center mt-5" style="padding:2rem;">
		<form action="" method="post" class="border">
			<?php
			$sorgu = mysqli_query($baglanti, "SELECT * FROM personel WHERE per_id =" . (int)$_GET['id']);
			$row = mysqli_fetch_assoc($sorgu);
			?>
			<div class="row">
				<div class="col-md">
					<div class="p-4 shadow rounded-3">
						<div class="mb-3">
							<h4 class="text-right fs-6">Personel Düzenleme</h4>
						</div>
						<div class="row mt-2">
							<div class="col-md-6"><label style="font-size:15px;" class="form-label">Ad</label><input type="text" class="form-control" name="per_ad" value="<?= $row['per_ad']; ?>"></div>
							<div class="col-md-6"><label style="font-size:15px;" class="form-label">Soyad</label><input type="text" class="form-control" name="per_soyad" value="<?= $row['per_soyad']; ?>"></div>
						</div>
						<div class="row mt-2">
							<div class="col-md-6"><label style="font-size:15px;" class="form-label">Müşteri ID</label><input type="text" class="form-control" name="dep_id" value="<?= $row['dep_id']; ?>"></div>
							<div class="col-md-6"><label style="font-size:15px;" class="form-label">Personel ID</label><input type="text" class="form-control" name="per_id" value="<?= $row['per_id']; ?>"></div>
						</div>
						<div class="row mt-3">
							<div class="col-md-6"><label style="font-size:15px;" class="form-label">Başarılı Görev</label><input type="text" class="form-control" name="basarili_gorev" value="<?= $row['basarili_gorev']; ?>"></div>
							<div class="col-md-6"><label style="font-size:15px;" class="form-label">Başarısız Görev</label><input type="text" class="form-control" name="basarisiz_gorev" value="<?= $row['basarisiz_gorev']; ?>"></div>
						</div>
						<div class="row mt-3">
							<div class="col-md-6"><label style="font-size:15px;" class="form-label">Personel Maaş</label><input type="text" class="form-control" name="per_maas" value="<?= $row['per_maas']; ?>"></div>
							<div class="col-md-6"><label style="font-size:15px;" class="form-label">Çalışılan Gün</label><input type="text" class="form-control" name="calisilanGun" value="<?= $row['calisilanGun']; ?>"></div>
						</div>
						<div class="mt-5 text-center">
							<input id="tableButton" type="submit" value="Güncelle" name="guncelle" class="btn btn-primary w-100">
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
	<?php

	if ($_POST) {

		$personelID = $_POST['per_id'];
		$departmanID = $_POST['dep_id'];
		$personelAd = $_POST['per_ad'];
		$personelSoyad = $_POST['per_soyad'];
		$basariliGorev = $_POST['basarili_gorev'];
		$basarisiz_gorev = $_POST['basarisiz_gorev'];
		$personelMaas = $_POST['per_maas'];
		$calisilanGun = $_POST['calisilanGun'];

		if ($personelID != "" && $departmanID != "") {


			if ($baglanti) {
				$sorgu = mysqli_query($baglanti, "UPDATE personel SET per_id = '$personelID', dep_id = '$departmanID', per_ad = '$personelAd', per_soyad = '$personelSoyad',  basarili_gorev = '$basariliGorev',  basarisiz_gorev = '$basarisiz_gorev',  per_maas = '$personelMaas', calisilanGun = '$calisilanGun' WHERE per_id =" . $_GET['id']);
				if ($sorgu) {
					echo("<script>location.replace('listeler.php');</script>");
				}
			} else {
				echo "Hata oluştu";
			}
		}
	}
	?>
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
