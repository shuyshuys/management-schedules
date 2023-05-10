<?php
require_once "auth.php";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (authenticate($username, $password)) {
        // Redirect ke halaman dashboard
        header('Location: ../dashboard');
        exit();
    } else {
        $error_message = "USERNAME atau PASSWORD salah!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Time Management</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Login Time Management</h4>
                    </div>
                    <div class="card-body">

                        <?php if (isset($error_message)) : ?>
                            <div><?php echo $error_message ?></div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary" id="submit" name="submit">Login</button>
                        </form>
                        <div class="mt-3">
                            <p>Belum punya akun? <a href="register">Buat Akun</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>
    <reserved-by></reserved-by>
    <script src="../../js/default.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
</footer>

</html>