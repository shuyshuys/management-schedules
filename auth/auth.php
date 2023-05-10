<?php
// Memanggil koneksi.php untuk menghubungkan ke database
// Memulai sesi
session_start();

function authenticate($username, $password)
{
    include "../koneksi.php";

    // Query untuk mencari data user berdasarkan username
    $query = "SELECT * FROM mahasiswa WHERE username = '$username'";


    // Eksekusi query
    $result = mysqli_query($koneksi, $query);

    // Cek apakah query berhasil dieksekusi
    if (!$result) {
        die("Query gagal dijalankan: " . mysqli_error($koneksi));
    }

    // Ambil data user dari hasil query
    $hasiluser = mysqli_fetch_assoc($result);

    // Verifikasi password dengan password_hash()
    if ($username && password_verify($password, $hasiluser['password'])) {
        // Jika username dan password cocok, simpan data user ke dalam sesi
        $_SESSION['user'] = $hasiluser;
        return true;
    } else {
        // Jika username atau password tidak cocok, kembalikan false
        return false;
    }
}

function is_authenticated()
{
    return isset($_SESSION['user']);
}

function logout()
{
    unset($_SESSION['user']);
    session_destroy();
}

function register($id, $username, $password)
{
    include '../koneksi.php';
    // Enkripsi password dengan fungsi password_hash() sebelum disimpan ke database
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk menambahkan data baru ke dalam tabel mahasiswa
    $query = "INSERT INTO mahasiswa (id, username, password) VALUES ('$id', '$username', '$password')";

    // Eksekusi query
    $result = mysqli_query($koneksi, $query);

    // Cek apakah query berhasil dieksekusi
    if (!$result) {
        die("Query gagal dijalankan: " . mysqli_error($koneksi));
        return false;
    } else {
        return true;
    }
}
// $_SESSION['timeout'] = time() + 1800;

// Mengecek apakah pengguna sudah login atau belum
// if (!isset($_SESSION['username'])) {
//     // Jika belum, arahkan ke halaman login
//     header('Location: login.php');
//     exit;
// }

// // Mengecek apakah sesi sudah kadaluwarsa atau belum
// $inactive = 21600; // Set waktu sesi aktif dalam detik (6 jam)
// $session_life = time() - $_SESSION['timeout'];

// if ($session_life > $inactive) {
//     session_unset();
//     session_destroy();
//     header('Location: pages/authentication/login.php');
//     exit;
// }

// Refresh waktu timeout pada sesi
// $_SESSION['timeout'] = time();

// Halaman setelah login
// echo 'Selamat datang di halaman utama ' . $_SESSION['username'] . '!';