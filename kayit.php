<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/f6190b6e7c.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Kayıt Ol</title>
</head>

<body>
    <main>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form class="p-5" action="control/kayitOl.php" method="get">
                        <h1 class="text-center fs-2 pb-5">Kayıt Ol</h1>
                        <div class="mb-3">
                            <input placeholder="Adınız" style="background-color:#e6e6e6; font-size:13px;" class="form-control p-3" type="text" name="yon_ad">
                        </div>
                        <div class="mb-3">
                            <input placeholder="Soyadınız" style="background-color:#e6e6e6; font-size:13px;" class="form-control p-3" type="text" name="yon_soyad">
                        </div>
                        <div class="mb-3">
                            <select style="background-color:#e6e6e6; font-size:13px;" class="form-control p-3" name="dep_id">
                                <option selected> Departman numaranızı seçin.</option>
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
                        <div class="mb-3">
                            <input placeholder="E-Mail" style="background-color:#e6e6e6; font-size:13px;" class="form-control p-3" type="text" name="email">
                        </div>
                        <div class="mb-3">
                            <input placeholder="Cep Telefonu" style="background-color:#e6e6e6; font-size:13px;" class="form-control p-3" type="text" name="cepTelefonu">
                        </div>
                        <div class="mb-3">
                            <input placeholder="Sabit Telefon" style="background-color:#e6e6e6; font-size:13px;" class="form-control p-3" type="text" name="sabitTelefon">
                        </div>
                        <div class="mb-3">
                            <input placeholder="Adres" style="background-color:#e6e6e6; font-size:13px;" class="form-control p-3" type="text" name="adres">
                        </div>
                        <div class="mb-3">
                            <input placeholder="Şifreniz" style="background-color:#e6e6e6; font-size:13px;" class="form-control p-3" type="password" name="sifre">
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="" checked>
                            <label class="form-check-label" for="flexCheckChecked"> Tüm şartları kabul ediyorum </label>
                        </div>
                        <button class="btn btn-primary w-100 mb-2" type="submit">Kayıt Ol</button>
                        <footer>Hesabınız var mı? <a class="text-decoration-none fw-bold" href="index.php">Giriş Yap</a></footer>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>