<?php
//query untuk mengambil data article
$sql1 = "SELECT * FROM article ORDER BY tanggal DESC";
$hasil1 = $conn->query($sql1);
$hasil2 = $conn->query("SELECT * FROM gallery ORDER BY tanggal DESC");



//menghitung jumlah baris data article
$jumlah_article = $hasil1->num_rows;
$jumlah_gallery = $hasil2->num_rows;



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "koneksi.php";

$username = $_SESSION['username'];

// ambil data user (foto)
$stmt = $conn->prepare("SELECT foto FROM user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// hitung artikel
$artikel = $conn->query("SELECT COUNT(*) AS total FROM article")->fetch_assoc();

// hitung gallery
$gallery = $conn->query("SELECT COUNT(*) AS total FROM gallery")->fetch_assoc();



?>
<div class="container my-4">
    <!-- Sambutan -->
    <div class="text-center mb-4">
        <p class="fs-5">Selamat Datang,</p>
        <h4 class="text-danger fw-bold"><?= $username ?></h4>

        <!-- Foto Profil -->
        <?php if ($user['foto'] != ''): ?>
            <img 
                src="img/<?= $user['foto'] ?>" 
                class="rounded-circle img-thumbnail mt-3"
                style="width:200px; height:200px; object-fit:cover;"
                alt="foto profil">

        <?php else: ?>
            <img 
                src="img/default.png" 
                class="rounded-circle img-thumbnail mt-3"
                width="200"
                height="200">
        <?php endif; ?>
    </div>



</div>
<div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center pt-4">
    <div class="col">
        <div class="card border border-danger mb-3 shadow" style="max-width: 18rem;">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="p-3">
                        <h5 class="card-title"><i class="bi bi-newspaper"></i> Article</h5> 
                    </div>
                    <div class="p-3">
                        <span class="badge rounded-pill text-bg-danger fs-2"><?php echo $jumlah_article; ?></span>
                    </div> 
                </div>
            </div>
        </div>
    </div> 
    <div class="col">
        <div class="card border border-danger mb-3 shadow" style="max-width: 18rem;">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="p-3">
                        <h5 class="card-title"><i class="bi bi-camera"></i> Gallery</h5> 
                    </div>
                    <div class="p-3">
                        <span class="badge rounded-pill text-bg-danger fs-2"><?php echo $jumlah_gallery; ?></span>
                    </div> 
                </div>
            </div>
        </div>
    </div> 
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>