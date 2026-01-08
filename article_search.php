<?php
include "koneksi.php";

$keyword = $_POST['keyword'];

$sql = "SELECT * FROM article 
        WHERE judul LIKE ? OR isi LIKE ? OR tanggal LIKE ? OR username LIKE ?
        ORDER BY tanggal DESC";

$stmt = $conn->prepare($sql);
$search = "%" . $keyword . "%";
$stmt->bind_param("ssss", $search, $search, $search, $search);
$stmt->execute();

$hasil = $stmt->get_result();

                        $no = 1;
                        while ($row = $hasil->fetch_assoc()) {
                    ?>
        				<tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong><?= $row["Judul"] ?></strong>
                                <br>pada : <?= $row["Tanggal"] ?>
                                <br>oleh : <?= $row["Username"] ?>
                            </td>
                            <td><?= $row["Isi"] ?></td>
                            <td>
                                <?php
                                    if ($row["Gambar"] != '') {
                                        if (file_exists('img/' . $row["Gambar"] . '')) { 
                                            echo '<img src="img/' . $row["Gambar"] . '" class="img-fluid" alt="Gambar Artikel">'; 
                                        }
                                    }
                                ?>
                            </td>
                            
                            <td>
                         <a href="#" title="edit" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>"><i class="bi bi-pencil"></i></a>
                         <a href="#" title="delete" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>"><i class="bi bi-x-circle"></i></a>

                         <!-- Awal Modal Edit -->
<div class="modal fade" id="modalEdit<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Article</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="Judul" class="form-label">Judul</label>
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                        <input type="text" class="form-control" name="Judul" placeholder="Tuliskan Judul Artikel" value="<?= $row["Judul"] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="isi">Isi</label>
                        <textarea class="form-control" placeholder="Tuliskan Isi Artikel" name="Isi" required><?= $row["Isi"] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="Gambar" class="form-label">Ganti Gambar</label>
                        <input type="file" class="form-control" name="Gambar">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput3" class="form-label">Gambar Lama</label>
                        <?php
                        if ($row["Gambar"] != '') {
                            if (file_exists('img/' . $row["Gambar"] . '')) { 
                                echo '<br><img src="img/' . $row["Gambar"] . '" class="img-fluid" alt="Gambar Artikel">';
                            }
                        }
                        ?>
                        <input type="hidden" name="gambar_lama" value="<?= $row["Gambar"] ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                </div>
            </form>                   
        </div>
    </div>
</div>
<!-- Akhir Modal Edit -->

<!-- Awal Modal Hapus -->
<div class="modal fade" id="modalHapus<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus Article</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Yakin akan menghapus artikel "<strong><?= $row["Judul"] ?></strong>"?</label>
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                        <input type="hidden" name="Gambar" value="<?= $row["Gambar"] ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">batal</button>
                    <input type="submit" value="hapus" name="hapus" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Akhir Modal Hapus -->
                        </td>
                        </tr>
                    <?php
                    }
                    ?>