<?php
//menyertakan code dari file koneksi
include "koneksi.php";
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>JDM</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />
    <link rel="icon" href="img/ml.jpg" />
    <style>
      .accordion-button:not(.collapsed) {
        background-color: #ffffff;
        color: white;
      }
       body.dark {
    background-color: #333 !important;
    color: #fff !important;
  }

  .img-fluid{
    border-radius: 10%;
  }

  #gallery .carousel-inner .carousel-item img {
    border-radius: 15px;
  }

  body.dark section {
    background-color: #444 !important;
    color: #fff !important;
  }

  body.dark footer {
    background-color: #222 !important;
    color: white !important;
  }

  body.dark .card {
    background-color: #555 !important;
    color: white !important;
  }

  body.dark .accordion-button {
    background-color: #444 !important;
    color: white !important;
  }

  body.dark .accordion-body {
    background-color: #555 !important;
    color: white !important;
  }

  body.dark nav {
  background-color: #ffffff !important;
  color: #000 !important;
}

/* Warna tulisan menu navbar */
body.dark nav .nav-link {
  color: #000 !important;
}

/* Hover tetap gelap */
body.dark nav .nav-link:hover {
  color: #444 !important;
}

/* Biar tulisan Last updated putih saat dark mode */
body.dark .card-footer small {
  color: #fff !important;
}

    </style>
  </head>
  <body>
    <!-- NAVBAR START -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
      <div class="container">
        <a class="navbar-brand" href="#">jdm</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
            <li class="nav-item">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#article">Article</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#gallery">Gallery</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#schedule">Schedule</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#aboutme">About Me</a>
            </li>
            <li class="nav-item">
             <a class="nav-link" href="login.php" target="_blank">Login</a>
            </li>
            <li class="nav-item">
            <button id="toggle-dark" class="btn btn-outline-dark ms-3">🌓</button>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- NAVBAR END -->
    <!-- HERO START -->
    <section id="hero" class="text-center p-5 text-sm-start" style="background-color: #7c0000ff;">

      <div class="container">
        <div class="d-sm-flex flex-sm-row-reverse align-items-center">
          <img src="img/JDM ICON.jpeg" class="img-fluid" width="300" />
          <div>
            <h1 class="fw-bold display-4">
              Apa itu jdm?
            </h1>
            <h4 class="lead display-6">
              JDM mengacu pada mobil, motor, atau part otomotif yang dibuat khusus untuk pasar Jepang, bukan untuk ekspor. Karena itu, banyak spesifikasi JDM yang berbeda dari versi luar Jepang.
            </h4>
            <h6>
              <span id="tanggal"></span>
              <span id="jam"></span>
            </h6>
          </div>
        </div>
      </div>
    </section>
    <!-- HERO END -->
    <!-- ARTICLE START -->
    <section id="article" class="text-center p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">Article</h1>
        <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
        <?php
        $sql = "SELECT * FROM article ORDER BY tanggal DESC";
        $hasil = $conn->query($sql); 

        while($row = $hasil->fetch_assoc()){

        ?>
          <!--col mulai-->
          <div class="col">
            <div class="card h-100">
              <img src="img/<?=$row["Gambar"]?>" class="card-img-top" alt="..." />
              <div class="card-body">
                <h5 class="card-title"><?=$row["Judul"]?></h5>
                <p class="card-text">
                  <?=$row["Isi"]?>
                </p>
              </div>
              <div class="card-footer">
                <small class="text-body-secondary">
                  <?=$row["Tanggal"]?>
                </small>
              </div>
            </div>
          </div>
          <!--col akhir-->

          <?php
        }
        ?>
        </div>
      </div>
    </section>
    <!-- ARTICLE END -->
    <!-- GALLERY START -->
    <section id="gallery" class="bg-subtle text-center p-5" style="background-color: #7c0000ff;">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">Gallery</h1>
        <div id="carouselExample" class="carousel slide">
          <div class="carousel-inner">
            <<?php
            $sql = "SELECT * FROM gallery ORDER BY tanggal DESC";
            $hasil = $conn->query($sql);
            $active = "active";

            while ($row = $hasil->fetch_assoc()) {
            ?>
              <div class="carousel-item <?= $active ?>">
                <img 
                  src="img/<?= $row['Gambar'] ?>" 
                  class="d-block w-100"
                  alt="<?= htmlspecialchars($row['deskripsi']) ?>"
                >
              </div>
            <?php
              $active = ""; // hanya item pertama yg active
            }
            ?>
          </div>
          <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#carouselExample"
            data-bs-slide="prev"
          >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#carouselExample"
            data-bs-slide="next"
          >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </section>
    <!-- GALLERY END -->
    <!-- ACTIVITY START -->
    <section id="schedule" class="text-center p-5">
      <h1 class="fw-bold display-4 pb-3">Schedule</h1>
      <div
        class="row row-cols-2 row-cols-sm-3 row-cols-lg-4 g-4 justify-content-center"
      >
        <div class="col">
          <div class="p-4 border rounded shadow-sm h-100">
            <i class="bi bi-book text-danger fs-1"></i>
            <h5 class="mt-3">Membaca</h5>
            <p>Menambah wawasan setiap pagi sebelum beraktivitas.</p>
          </div>
        </div>
        <div class="col">
          <div class="p-4 border rounded shadow-sm h-100">
            <i class="bi bi-laptop text-danger fs-1"></i>
            <h5 class="mt-3">Menulis</h5>
            <p>Mencatat setiap pengalaman harian di jurnal pribadi.</p>
          </div>
        </div>
        <div class="col">
          <div class="p-4 border rounded shadow-sm h-100">
            <i class="bi bi-people text-danger fs-1"></i>
            <h5 class="mt-3">Diskusi</h5>
            <p>Bertukar ide dengan teman dalam kelompok belajar.</p>
          </div>
        </div>
        <div class="col">
          <div class="p-4 border rounded shadow-sm h-100">
            <i class="bi bi-bicycle text-danger fs-1"></i>
            <h5 class="mt-3">Olahraga</h5>
            <p>Menjaga kesehatan dengan bersepeda sore hari.</p>
          </div>
        </div>
        <div class="col">
          <div class="p-4 border rounded shadow-sm h-100">
            <i class="bi bi-film text-danger fs-1"></i>
            <h5 class="mt-3">Movie</h5>
            <p>Menonton film yang bagus di bioskop.</p>
          </div>
        </div>
        <div class="col">
          <div class="p-4 border rounded shadow-sm h-100">
            <i class="bi bi-bag text-danger fs-1"></i>
            <h5 class="mt-3">Belanja</h5>
            <p>Membeli kebutuhan bulanan di supermarket.</p>
          </div>
        </div>
      </div>
    </section>
    <!-- ACTIVITY END -->
    <!-- ABOUT ME START -->
    <section id="aboutme" class="bg-subtle text-center p-5" style="background-color: #7c0000ff;">
      <h1 class="fw-bold display-4 pb-3">About Me</h1>
      <div class="accordion" id="accordionExample">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button
              class="accordion-button"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapseOne"
              aria-expanded="true"
              aria-controls="collapseOne"
            >
              Tentang Kami
            </button>
          </h2>
          <div
            id="collapseOne"
            class="accordion-collapse collapse show"
            data-bs-parent="#accordionExample"
          >
            <div class="accordion-body">
              <b>JDM</b> JDM (Japanese Domestic Market) adalah istilah yang digunakan untuk menggambarkan mobil, motor, dan komponen otomotif yang diproduksi khusus untuk pasar Jepang. Produk JDM biasanya memiliki spesifikasi berbeda dibanding versi ekspor, baik dari segi desain, performa, maupun fitur.</b>JDM dikenal dengan fokus pada performa, handling, dan keseimbangan kendaraan, bukan hanya tampilan. Banyak mobil JDM menggunakan mesin berteknologi tinggi, bobot ringan, serta pengaturan suspensi yang presisi. Ciri khas lainnya adalah setir kanan, desain fungsional, dan pilihan mesin yang unik.Selain sebagai istilah pasar, JDM juga berkembang menjadi budaya otomotif, mencakup gaya modifikasi, balap jalanan, drift, touge, hingga time attack. Budaya ini dipopulerkan oleh mobil legendaris seperti Honda Civic, Toyota Supra, Nissan Skyline GT-R, Mazda RX-7, dan AE86, serta media seperti anime dan film.Singkatnya, JDM bukan hanya tentang mobil Jepang, tetapi tentang filosofi otomotif yang mengutamakan karakter, performa, dan identitas khas Jepang.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button
              class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapseTwo"
              aria-expanded="false"
              aria-controls="collapseTwo"
            >
              Presented By
            </button>
          </h2>
          <div
            id="collapseTwo"
            class="accordion-collapse collapse"
            data-bs-parent="#accordionExample"
          >
            <div class="accordion-body">
              <b>HONDA,MICHELIN,Bridgestone</b>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button
              class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapseThree"
              aria-expanded="false"
              aria-controls="collapseThree"
            >
              lokasi penyebaran JDM
            </button>
          </h2>
          <div
            id="collapseThree"
            class="accordion-collapse collapse"
            data-bs-parent="#accordionExample"
          >
            <div class="accordion-body">
              XO Hall, Jl. Tanjung Duren Barat III No.1, RT.9/RW.5, Tj. Duren Utara, Kec. Grogol petamburan, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11470. Link google maps: <code>https://maps.app.goo.gl/qDzKj6SQZBQeSq3H9</code>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ABOUT ME END -->
    <!-- FOOTER START -->
    <footer class="text-center p-5">
      <div>
        <i class="h2 bi bi-instagram p-2"></i>
        <i class="h2 bi bi-twitter p-2"></i>
        <i class="h2 bi bi-whatsapp p-2"></i>
      </div>
      <div><p>Briyan Dhanuartha &copy; 2025</p></div>
    </footer>
    <!-- FOOTER END -->
     		<!-- Tombol Back to Top -->
    <button
      id="backToTop"
      class="btn btn-danger rounded-circle position-fixed bottom-0 end-0 m-3"
    >
      <i class="bi bi-arrow-up" title="Back to Top"></i>
    </button>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
    <script type="text/javascript">
      function tampilwaktu() {
     var waktu = new Date();
  
     var tanggal = waktu.getDate();
     var bulan = waktu.getMonth();
     var tahun = waktu.getFullYear();
     var jam = waktu.getHours();
     var menit = waktu.getMinutes();
     var detik = waktu.getSeconds();

     var arrBulan = ["1", "2", "3", "4","5","6","7","8","9","10","11","12"];

    var tanggal_full = tanggal + "/" + arrBulan[bulan] + "/" + tahun;
    var jam_full = jam + ":" + menit + ":" + detik; 

    document.getElementById("tanggal").innerHTML = tanggal_full;
    document.getElementById("jam").innerHTML = jam_full;
    }

    setInterval(tampilwaktu, 1000);
    </script>
    <script type="text/javascript"> 
  const backToTop = document.getElementById("backToTop");

  			window.addEventListener("scroll", function () {
        				if (window.scrollY > 300) {
          backToTop.classList.remove("d-none");
          backToTop.classList.add("d-block");
        } else {
          backToTop.classList.remove("d-block");
          backToTop.classList.add("d-none");
        }
      });

  backToTop.addEventListener("click", function () {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
</script>
<script>
  const toggle = document.getElementById("toggle-dark");

  toggle.addEventListener("click", function () {
    document.body.classList.toggle("dark");
  });
</script>

  </body>
</html>
