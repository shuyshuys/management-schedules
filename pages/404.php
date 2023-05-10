<!DOCTYPE html>
<html>

<head>
    <title>404 Not Found</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #ae68ff;
        color: #fff;
        font-family: sans-serif;
        font-size: 18px;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .error-code {
        font-size: 6rem;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .error-message {
        font-size: 2rem;
        font-weight: 500;
    }
    </style>
</head>

<body>
    <div class="text-center">
        <h1 class="error-code">404</h1>
        <p class="error-message">Oops! The page
            <?php
            // $file = $_GET['url'] ?? 'index.php';
            // $page = basename($file, '.php'); // mengambil bagian file saja dari URL dan menghilangkan ekstensi .php
            // echo $page;
            ?>
            you are looking for could not be found.</p>
        <a href="/" class="btn btn-light">Go back to homepage</a>
    </div>
</body>

<footer>
    <reserved-by></reserved-by>
    <script src="../js/default.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>

</footer>

</html>