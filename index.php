<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="index.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script>
        $(document).ready(function() {
            $("#login-btn").click(function() {
                $.post("control/girisKontrol.php", {
                    email: $("#email").val(),
                    password: $("#password").val()
                }, function(data, status) {
                    if (data == 1) {
                        $(location).attr("href", "main.php");
                    } else {
                        alert("Kullanıcı adı veya şifre hatalı.");
                    };
                });
            });
        });
    </script>
</head>

<body class="m-0" style="background-color:#f8f9f9;">
    <div class="container girisYap">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form class="p-5">
                    <h1 class="text-center fs-2 pb-5">Giriş Yap</h1>
                    <div class="mb-3">
                        <input placeholder="Kullanıcı Adı" style="background-color:#e6e6e6; font-size:13px;" type="text" class="form-control p-3" id="email" aria-describedby="emailYardim">
                        <div id="emailYardim" class="form-text fw-lighter">Bilgileriniz üçüncü şahıslarla paylaşılmayacaktır.</div>
                    </div>
                    <div class="mb-3">
                        <input placeholder="Şifre" type="password" style="background-color:#e6e6e6; font-size:13px;" class="form-control p-3" id="password">
                    </div>
                    <div class="mb-3 clearfix">
                        <a href="#" class="text-decoration-none float-end fw-bold" style="color:#343a40;">Şifremi Unuttum</a>
                    </div>
                    <div class="d-grid gap-2 girisYapbutonu">
                        <button id="login-btn" type="button" class="btn btn-primary border-0">Giriş</button>
                    </div>
                    <footer class="mt-3">Hesabınız yok mu? <a class="text-decoration-none fw-bold" href="kayit.php">Kayıt ol</a></footer>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>