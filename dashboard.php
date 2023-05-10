<?php
// menghubungkan file auth.php untuk memproses login
require_once 'auth/auth.php';
if (!is_authenticated()) {
    // Jika user belum login, redirect ke halaman login
    header('Location: auth/login');
    exit();
}

// jika sudah, tampilkan halaman dashboard
echo "Here Dashboard<br>";
$user_login = $_SESSION['user']['username'];
$id_login = $_SESSION['user']['id'];
// echo "Username: $user_login<br>";
// echo "ID: $id_login<br>";

// Import string koneksi ke database
include('koneksi.php');

// Proses simpan data
if (isset($_POST['submit'])) {
    // Menangkap data yang dikirimkan dari form
    $nama = $_POST['nama_buat'];
    $id_jabatan = $_POST['jabatan_buat'];

    // Menyimpan data ke tabel
    $sql = "INSERT INTO pegawai (nama_pegawai, id_jabatan) VALUES ('$nama', '$id_jabatan')";
    if (mysqli_query($con, $sql)) {
        echo "<div class='alert alert-success'>Data berhasil disimpan.</div>";
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan saat menyimpan data: " . mysqli_error($con) . "</div>";
    }
}

// Proses mengubah data
if (isset($_POST['change'])) {
    // Menangkap data yang dikirimkan dari form
    $id = $_POST['id_ubah'];
    $nama = $_POST['nama_ubah'];
    $jabatan = $_POST['jabatan_ubah'];

    // Menyimpan data ke tabel
    $sql = "UPDATE pegawai SET nama_pegawai='$nama', id_jabatan='$jabatan' WHERE id_pegawai='$id'";

    // Memunculkan pesan sukses/error
    if (mysqli_query($con, $sql)) {
        echo "<div class='alert alert-success'>Data berhasil disimpan.</div>";
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan saat menyimpan data: " . mysqli_error($con) . "</div>";
    }
}

// Memeriksa apakah tombol Hapus telah ditekan
if (isset($_GET['delete_id'])) {
    // Mendapatkan id_bt yang dipilih
    $id = $_GET['delete_id'];

    // Menghapus data dari tabel
    $sql = "DELETE FROM pegawai WHERE id_pegawai = $id";

    // Memunculkan pesan sukses/error
    if (mysqli_query($con, $sql)) {
        echo "<div class='alert alert-success'>Data berhasil dihapus.</div>";
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan saat menghapus data: " . mysqli_error($con) . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
    * {
        scroll-behavior: smooth;
    }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <title>Data Tugas Kelas D</title>
</head>

<body>
    <div class="container">
        <h1>
            Selamat datang di dashboard, <?php echo $user_login ?>!<br>
        </h1>
        <a href="auth/logout" class="btn btn-info mt-2">Logout</a>
        <h1 class="mb-3">Daftar Tugas</h1>
        <!-- Tabel daftar pegawai -->
        <table class="table mx-auto">
            <thead class="thead-dark">
                <tr>
                    <th>NPM</th>
                    <th>Nama Mata Kuliah</th>
                    <th>Nama Dosen</th>
                    <th>Nama Tugas</th>
                    <th>Deadline</th>
                    <th>Status Tugas</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan data pegawai dari database
                $sql = "SELECT m.id, mk.nama_mata_kuliah, d.nama_dosen, t.nama_tugas, t.deadline, mt.status_tugas 
                FROM mahasiswa m 
                JOIN mahasiswa_tugas mt ON m.id = mt.npm
                JOIN tugas t ON t.id_tugas = mt.id_tugas 
                JOIN mata_kuliah mk ON t.id_mata_kuliah = mk.id_mata_kuliah
                JOIN dosen d ON d.id_dosen = mk.id_dosen 
                WHERE m.id = '$id_login'
                ORDER BY t.deadline ASC";
                $result = mysqli_query($koneksi, $sql);

                // Menampilkan data pegawai ke dalam tabel
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nama_mata_kuliah'] . "</td>";
                    echo "<td>" . $row['nama_dosen'] . "</td>";
                    echo "<td>" . $row['nama_tugas'] . "</td>";
                    echo "<td>" . $row['deadline'] . "</td>";
                    echo "<td>" . $row['status_tugas'] . "</td>";
                    echo "<td>
                <button class='btn btn-primary' data-toggle='modal' data-target='#myModal' data-id='" . $row['id'] .
                        "'data-nama-mata-kuliah='" . $row['nama_mata_kuliah'] .
                        "'data-nama-dosen='" . $row['nama_dosen'] .
                        "' data-nama-tugas='" . $row['nama_tugas'] .
                        "' data-deadline='" . $row['deadline'] . "'
                data-status-tugas='" . $row['status_tugas'] . "'>Tampilkan Data</button>
                <a onclick='fillForm(" . $row['id'] . "," . $row['id'] . ")' class='btn btn-warning'>Edit</a>
                <a href='?delete_id=$row[id]' class='btn btn-danger'>Hapus</a>
                </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <hr>
        <!-- Modal button tampilkan data -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Detail Pegawai</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>ID: <span id="modal-id"></span></p>
                        <p>Nama Mata Kuliah: <span id="modal-nama-mata-kuliah"></span></p>
                        <p>Nama Dosen: <span id="modal-nama-dosen"></span></p>
                        <p>Nama Tugas: <span id="modal-nama-tugas"></span></p>
                        <p>Deadline: <span id="modal-deadline"></span></p>
                        <p>Status Tugas: <span id="modal-status-tugas"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Form tambah data -->
        <h1 class="mt-2">Form Input Tugas</h1>
        <div class="row mt-2">
            <?php
            $query_tugas = "SELECT * FROM tugas";
            $result_tugas = mysqli_query($koneksi, $query_tugas);
            ?>
            <div class="col-sm-6 mx-auto">
                <div class="card-header text-white bg-secondary text-center">
                    Tambah Data Pegawai
                </div>
                <div class="card px-5">
                    <form method="POST">
                        <!-- Label nama pegawai -->
                        <div class="form-group mt-3">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama_buat" name="nama_buat" required>
                        </div>
                        <!-- Label jabatan pegawai berupa dropdown -->
                        <div class="form-group">
                            <label for="text">Jabatan</label>
                            <select class="form-control" id="jabatan_buat" name="jabatan_buat">
                                <option value="">- Pilih Jabatan -</option>
                                <?php while ($row_jabatan = mysqli_fetch_assoc($result_tugas)) { ?>
                                <option value="<?php echo $row_jabatan['id_jabatan']; ?>" name="jabatan_buat"
                                    id="jabatan_buat">
                                    <?php echo $row_jabatan['nama_jabatan']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- Label gaji pegawai -->
                        <div class="form-group">
                            <label for="gaji">Gaji</label>
                            <input class="form-control" id="gaji_buat" name="gaji_buat" readonly value=""></input>
                        </div>
                        <!-- Tombol submit -->
                        <button type="submit" class="btn btn-primary mb-3" name="submit">Tambah</button>
                    </form>
                </div>
            </div>
            <div class="col-sm-6 mx-auto">
                <div class="card-header text-white bg-secondary text-center">
                    Ubah Data Pegawai
                </div>
                <div class="card px-5">
                    <form method="POST">
                        <!-- Label id pegawai -->
                        <div class="form-group mt-3">
                            <label for="nama">ID</label>
                            <input type="text" class="form-control" id="id_ubah" name="id_ubah" readonly>
                        </div>
                        <!-- Label nama pegawai -->
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama_ubah" name="nama_ubah" required>
                        </div>
                        <?php
                        // Menampilkan data jabatan ke dalam dropdown
                        $query_jabatan = "SELECT * FROM jabatan";
                        $result_jabatan = mysqli_query($con, $query_jabatan);
                        ?>
                        <!-- Label Jabatan berupa dropdown -->
                        <div class="form-group">
                            <label for="text">Jabatan</label>
                            <select class="form-control" id="jabatan_ubah" name="jabatan_ubah">
                                <option value="">- Pilih Jabatan -</option>
                                <?php while ($row_jabatan = mysqli_fetch_assoc($result_jabatan)) { ?>
                                <option value="<?php echo $row_jabatan['id_jabatan']; ?>" name="jabatan_ubah"
                                    id="jabatan_ubah">
                                    <?php echo $row_jabatan['nama_jabatan']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- Label Gaji pegawai -->
                        <div class="form-group">
                            <label for="isi">Gaji</label>
                            <input class="form-control" id="gaji_ubah" name="gaji" readonly value=""></input>
                        </div>
                        <button type="submit" class="btn btn-primary mb-3" name="change">Ubah</button>
                    </form>
                </div>
            </div>
        </div>
        <hr>


        <script src="js/jquery-3.6.3.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <script>
        // Script untuk menampilkan data pegawai ke dalam modal
        $('#myModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_bt = button.data('id')
            var mata_kuliah_bt = button.data('nama-mata-kuliah')
            var dosen_bt = button.data('nama-dosen')
            var tugas_bt = button.data('nama-tugas')
            var deadline_bt = button.data('deadline')
            var status_bt = button.data('status-tugas')

            var modal = $(this)
            modal.find('#modal-id').text(id_bt)
            modal.find('#modal-nama-mata-kuliah').text(mata_kuliah_bt)
            modal.find('#modal-nama-dosen').text(dosen_bt)
            modal.find('#modal-nama-tugas').text(tugas_bt)
            modal.find('#modal-deadline').text(deadline_bt)
            modal.find('#modal-status-tugas').text(status_bt)
        })

        // Script untuk mengisi form edit pegawai 
        function fillForm(id, jabatan) {
            console.log(id);
            document.getElementById("id_ubah").value = id;
            var dropdown = document.getElementById("jabatan_ubah");
            dropdown.value = jabatan;
            var event = new Event('change');
            dropdown.dispatchEvent(event);
            document.getElementById("nama_ubah").focus();
            window.scrollTo(0, 0);
        }

        // Menambahkan event listener untuk dropdown
        document.getElementById("jabatan_ubah").addEventListener("change", function() {
            // Mendapatkan nilai id_jabatan yang dipilih
            var id_jabatan = this.value;
            // Mengirim request AJAX ke file PHP untuk mendapatkan gaji berdasarkan id_jabatan
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Mengisi nilai gaji dengan hasil request AJAX
                    document.getElementById("gaji_ubah").value = this.responseText;
                }
            };
            // Mengirim request AJAX
            xmlhttp.open("GET", "get_gaji.php?id_jabatan=" + id_jabatan, true);
            xmlhttp.send();
        });

        // Menambahkan event listener untuk dropdown
        document.getElementById("jabatan_buat").addEventListener("change", function() {
            // Mendapatkan nilai id_jabatan yang dipilih
            var id_jabatan = this.value;
            console.log(id_jabatan);
            // Mengirim request AJAX ke file PHP untuk mendapatkan gaji berdasarkan id_jabatan
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Mengisi nilai gaji dengan hasil request AJAX
                    document.getElementById("gaji_buat").value = this.responseText;
                }
            };
            // Mengirim request AJAX
            xmlhttp.open("GET", "get_gaji.php?id_jabatan=" + id_jabatan, true);
            xmlhttp.send();

        });
        </script>
</body>

<footer>
    <!-- memanggil footer menggunakan component javascript -->
    <reserved-by></reserved-by>
</footer>

<script src="js/default.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>

</html>