<?php
// ambil URL yang diminta
$url = isset($_GET['url']) ? $_GET['url'] : 'index';

// pisahkan URL menjadi array dengan delimiter '/'
$url_parts = explode('/', $url);

// ambil nama halaman
$page_name = isset($url_parts[0]) ? $url_parts[0] : 'home';

// cek apakah halaman yang diminta ada
if (file_exists($page_name . '.php')) {
    // tampilkan halaman yang diminta
    require_once $page_name . '.php';
} else {
    // tampilkan halaman 404 jika halaman tidak ditemukan
    header('HTTP/1.0 404 Not Found');
    include 'pages/404.php';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <title>File Index</title>
</head>

<body>
    <h1>Index</h1>
    <p>Halaman ini adalah halaman index</p>
    <a href="auth/login" class="btn btn-success">Ke Halaman Login</a>
</body>
<footer>
    <reserved-by></reserved-by>
    <script src="js/default.js"></script>
    <?php
    // require_once "auth.php";
    // logout();
    // header('Location: login.php');
    exit();
    ?>

</footer>

</html>