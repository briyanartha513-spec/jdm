<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "koneksi.php";

// ambil data user yang login
$username = $_SESSION['username'];

$stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<div class="container my-4">
    <h3 class="mb-3">profile</h3>
    <hr>

    <form method="post" action="" enctype="multipart/form-data">

        <!-- Username -->
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" value="<?= $user['username']; ?>" readonly>
        </div>

        <!-- Ganti Password -->
        <div class="mb-3">
            <label class="form-label">Ganti Password</label>
            <input 
                type="password" 
                name="password" 
                class="form-control"
                placeholder="Tuliskan Password Baru">
        </div>
<!-- Ganti Foto -->
        <div class="mb-3">
            <label class="form-label">Ganti Foto Profil</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <!-- Foto Profil Saat Ini -->
        <div class="mb-3">
            <label class="form-label">Foto Profil Saat Ini</label><br>
            <?php if ($user['foto'] != ''): ?>
                <img src="img/<?= $user['foto']; ?>" class="img-thumbnail" width="150">
            <?php else: ?>
                <p class="text-muted">Belum ada foto</p>
            <?php endif; ?>
        </div>

        <button type="submit" name="simpan" class="btn btn-primary">
            simpan
        </button>

    </form>
</div>

<?php
if (isset($_POST['simpan'])) {

    $password_baru = $_POST['password'];
    $foto = $_FILES['foto']['name'];

    // === PASSWORD ===
    if ($password_baru != '') {
        $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE user SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $password_hash, $username);
        $stmt->execute();
    }

    // === FOTO ===
    if ($foto != '') {
        $ext = pathinfo($foto, PATHINFO_EXTENSION);
        $nama_foto = uniqid() . "." . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], "img/" . $nama_foto);

        $stmt = $conn->prepare("UPDATE user SET foto = ? WHERE username = ?");
        $stmt->bind_param("ss", $nama_foto, $username);
        $stmt->execute();
    }

    echo "<script>
        alert('Profile berhasil diperbarui');
        document.location='admin.php?page=profile';
    </script>";
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
