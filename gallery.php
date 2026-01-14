<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



<div class="container">
	<div class="row mb-2">
        <div class="col-md-6">
            <!-- Button tambah data -->
             <button type="button" class="btn btn-secondary mb-2"       data-bs-toggle="modal" data-bs-target="#modalTambah">
                 <i class="bi bi-plus-lg"></i> Tambah Galeri
             </button>
        </div>
        <div class="col-md-6">
			<div class="input-group">
                <input type="text" id="search" class="form-control" placeholder="Ketik minimal 3 karakter untuk pencarian...">
                <span class="input-group-text">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>
    </div>
    
   
    <div class="row">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th class="w-50">Deskripsi</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
				<tbody id="result">
                    
                </tbody>
            </table>
        </div>





        <!-- Modal Tambah gallery -->
         <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalTambahLabel">Tambah Gallery</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="modal-body">
                		<div class="mb-3">
							<label for="deskripsi" class="form-label">deskripsi</label>
                            <input type="text" class="form-control" name="deskripsi" placeholder="Tuliskan deskripsi Artikel" required>
                        </div>
                        <div class="mb-3">
                            <label for="Gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" name="Gambar">
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
    </div>
 </div>


<script>
    function loadData(keyword = '') {
        $.ajax({
            url: "gallery_search.php",
            type: "POST",
            data: {
                keyword: keyword
            },
            success: function(data) {
                $("#result").html(data);
            }
        });
    }

    // load awal
    loadData();

    		// event pencarian
    $("#search").on("keyup", function() {
        let keyword = $(this).val();
        
        if (keyword.length >= 3 || keyword.length == 0) {
            loadData(keyword);
        }
    });
</script>

 
 <?php
include "upload_foto.php";

//jika tombol simpan diklik
if (isset($_POST['simpan'])) {
    $deskripsi = $_POST['deskripsi'];
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];
    $Gambar = '';
    $nama_Gambar = $_FILES['Gambar']['name'];

    //jika ada file baru yang dikirim  
    if ($nama_Gambar != '') {
        //panggil function upload_foto untuk cek detail file yg diupload user
        //function ini memiliki keluaran sebuah array yang berisi status dan message
        $cek_upload = upload_foto($_FILES["Gambar"]);

        //cek status upload file hasilnya true/false
        if ($cek_upload['status']) {
            //jika true maka message berisi nama file gambar
            $Gambar = $cek_upload['message'];
        } else {
            //jika true maka message berisi pesan error, tampilkan dalam alert
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='admin.php?page=gallery';
            </script>";
            die;
        }
    }

		//cek apakah ada id yang dikirimkan dari form
    if (isset($_POST['id'])) {
        //jika ada id, lakukan update data dengan id tersebut
        $id = $_POST['id'];

        if ($nama_Gambar == '') {
            //jika tidak ganti gambar
            $Gambar = $_POST['Gambar_lama'];
        } else {
            //jika ganti gambar, hapus gambar lama
            unlink("img/" . $_POST['Gambar_lama']);
        }

        $stmt = $conn->prepare("UPDATE gallery 
                                SET 
                                deskripsi =?,
                                Gambar = ?,
                                tanggal = ?,
                                username = ?
                                WHERE id = ?");

        $stmt->bind_param("ssssi", $deskripsi, $Gambar, $tanggal, $username, $id);
        $simpan = $stmt->execute();
    } else {
		    //jika tidak ada id, lakukan insert data baru
        $stmt = $conn->prepare("INSERT INTO gallery (deskripsi,Gambar,tanggal,username)
                                VALUES (?,?,?,?)");

        $stmt->bind_param("ssss", $deskripsi, $Gambar, $tanggal, $username);
        $simpan = $stmt->execute();
    }

    if ($simpan) {
        echo "<script>
            alert('Simpan data sukses');
            document.location='admin.php?page=gallery';
        </script>";
    } else {
        echo "<script>
            alert('Simpan data gagal');
            document.location='admin.php?page=gallery';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
 

//jika tombol hapus diklik
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $Gambar = $_POST['Gambar'];

    if ($Gambar != '') {
        //hapus file gambar dari folder /img
        unlink("img/" . $Gambar);
    }

    $stmt = $conn->prepare("DELETE FROM gallery WHERE id =?");

    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    if ($hapus) {
        echo "<script>
            alert('Hapus data sukses');
            document.location='admin.php?page=gallery';
        </script>";
    } else {
        echo "<script>
            alert('Hapus data gagal');
            document.location='admin.php?page=gallery';
        </script>";
    }

    $stmt->close();
    $conn->close();
}

?>