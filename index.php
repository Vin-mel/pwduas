    <?php
    include "header.php";
    include "koneksi.php";

     $query_renungan = mysqli_query($conn, "SELECT * FROM tb_renungan ORDER BY tanggal_publish DESC LIMIT 1");
    $tb_renungan = mysqli_fetch_assoc($query_renungan);
  ?>

     <section class="hero" id="home">
        <main class="content">
            <h1> Welcome Home</h1>
            <p>Tempat Bagi Yang Berbeban Berat</p>
        </main>
    </section>

    <!-- Renungan-->
 <section id="renungan" class="Renungan">
    <div class="renungan-container">
        <?php if ($tb_renungan): ?>
        <div class="renungan-card">
            <div class="renungan-image">
                <img src="img/<?php echo $tb_renungan['gambar_renungan']; ?>" alt="Renungan Hari Ini">
            </div>
            <div class="renungan-info">
                <span class="tag">Renungan Harian</span>
                <blockquote class="ayat">
                    "<?php echo $tb_renungan['isi_ayat']; ?>"
                    <br><strong>(<?php echo $tb_renungan['referensi_ayat']; ?>)</strong>
                </blockquote>
                <a href="<?php echo $tb_renungan['link_sumber']; ?>" target="_blank" class="btn-renungan">
                    <span>Baca Selengkapnya</span>
                </a>
            </div>
        </div>
        <?php else: ?>
            <div class="renungan-card" style="text-align: center; padding: 40px; color: #000;">
                <h3>Belum Ada Renungan Hari Ini</h3>
                <p>Silakan hubungi admin untuk memperbarui konten renungan harian.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

    <!--Sejarah singkat-->
    <section id="about" class="sejarah">
        <div class="container">
            <h2 class="section-title"> Perjalanan Iman GKKB Purnama</h2>
            <div class="timeline">

                <!--titik 1:awal Mula-->
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">1999</div>
                    <div class="timeline-content">
                        <h3> Awal Perintisan</h3>
                        <p> Gereja Dimulai dari Kerinduan dan diresponi sebuah ketaatan pada amanat Agung Tuhan Yesus
                            "Jadikanlah semua Bangsa Murid-Ku", Pos Perintisan dibentuk di kompleks Purnama Anggrek.
                            Diresmikan pada 14 Agustus 1999 oleh Pdt. Samuel Fu. Tempat persekutuan waktu itu di Purnama
                            Anggrek 1 M-121 sebagai Pos Perintisan.</p>
                    </div>
                </div>
                <!-- titik 2: Pertumbuhan-->
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date"> 2003 - 2005</div>
                    <div class="timeline-content">
                        <h3> Masa Pertumbuhan</h3>
                        <p>Jemaat berkembang hingga 40-65 orang, sehingga ibadah pindah ke Jl. Karya Baru. Pada 11
                            September 2003,
                            pada 17 November 2005 GKKB Pontianak membeli ruko di Kompleks Purnama Agung 3 sebagai tempat
                            ibadah permanen dan diresmikan oleh Pembimas Kristen, Drs. Yohanes Kalvin Pieter.</p>
                    </div>
                </div>
                <!--titik 3: Renovasi Besar-->
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2018 - 2020</div>
                    <div class="timeline-content">
                        <h3> Renovasi & Perluasan</h3>
                        <p> Dimulailah renovasi perluasan ruang ibadah. April 2019 di momen Paskah, ruangan gereja
                            selesai direnovasi
                            dan digunakan secara permanen.</p>
                    </div>
                </div>
                <!--titk 4: masa sekarang-->
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2022 - 2025</div>
                    <div class="timeline-content">
                        <h3> Terus Melayani</h3>
                        <p>Tim pelayanan diperkuat dengan bergabungnya Penginjil. David, Dorkas, Lidia, dan Kristoper.
                            Mei 2025, renovasi lantai 2 dimulai untuk kebutuhan ruang Sekolah Minggu dan pastori Gereja.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- VISI MISI-->
    <section id="visimisi">
        <div class="vismis">
            <div class="visi">
                <h2>Visi</h2>
                <p>
                    Gereja Tionghoa yang dibangun di atas dasar kebenaran Alkitab untuk
                    menghadirkan Kerajaan Allah di tengah masyarakat Kalimantan Barat.
                </p>
            </div>
        </div>
        <div class="misvis">
            <div class="Misi">
                <h2>Misi</h2>
                <p>
                    Menjadikan setiap Anggota GKKB gereja yang memberitakan Injil dan
                    membina orang percaya menjadi murid Kristus sesuai dengan konteks
                    masyarakat Kalimantan Barat.
                </p>
            </div>
        </div>
    </section>

    <!-- Dokumentasi -->
<section id="dokumentasi"> 
    <h2>Dokumentasi</h2>
    <div class="documentation">
        <div class="doc-track">
            <?php
            $sql = "SELECT nama_file_gambar FROM tb_dokumentasi ORDER BY id_foto DESC";
            $result = mysqli_query($conn, $sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="images">';
                    echo '<img src="img/' . htmlspecialchars($row['nama_file_gambar']) . '" alt="Dokumentasi GKKB" />';
                    echo '</div>';
                }
            } else {
                echo '<p style="text-align:center; padding:20px; color:#fff">Belum ada dokumentasi.</p>';
            }
            ?>
        </div>
    </div>
</section>  

    <!--Jadwal -->
    <section id="jadwal">
        <h2 class="titlejadwal">JADWAL IBADAH</h2>
        <div class="borderjadwal">
            <div class="jadwal">
                <h2>
                    SELASA
                </h2>
                <h2>
                    PERSEKUTUAN WANITA
                </h2>
                <div class="jam">
                    <i data-feather="clock"></i>
                    <p class="pkl">
                        18:30
                    </p>
                </div>
                <p class="minggu">
                </p>
            </div>
            <div class="jadwal">
                <h2>
                    RABU
                </h2>
                <h2>
                    KTB REMAJA PEMUDA
                </h2>
                <div class="jam">
                    <i data-feather="clock"></i>
                    <p class="pkl">
                        19:00
                    </p>
                </div>
            </div>
            <div class="jadwal">
                <h2>
                    KAMIS
                </h2>
                <h2>
                    PERSEKUTUAN KASIH
                </h2>
                <div class="jam">
                    <i data-feather="clock"></i>
                    <p class="pkl">
                        18:30
                    </p>
                </div>
            </div>
            <div class="jadwal">
                <h2>
                    SABTU
                </h2>
                <h2>
                    PERSEKUTUAN REMAJA
                </h2>
                <div class="jam">
                    <i data-feather="clock"></i>
                    <p class="pkl">
                        18:00
                    </p>
                </div>
            </div>
            <div class="jadwal">
                <h2>MINGGU</h2>
                <div class="list-minggu">
                    <!--sesi 1-->
                    <div class="sesi">
                        <h3>KU-1</h3>
                        <div class="jam-mini">
                            <i data-feather="clock"></i>
                            <span>08:00</span>
                        </div>
                    </div>
                    <!-- sesi 2-->
                    <div class="sesi">
                        <h3>Sekolah Minggu</h3>
                        <div class="jam-mini">
                            <i data-feather="clock"></i>
                            <span>15:00</span>
                        </div>
                    </div>
                    <!--sesi 3-->
                    <div class="sesi">
                        <h3>KU-2</h3>
                        <div class="jam-mini">
                            <i data-feather="clock"></i>
                            <span>18:00</span>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- Pendeta -->
    <section id="pendeta">
        <h2 class="title-pendeta">PENDETA</h2>
        <div class="pendeta-content">
            <div class="pendeta"><img src="img/pendeta.jpeg" alt="pendeta" /> </div>
            <div class="biodata">
                <h2>
                    Pdt. Djong Tsiu Hiong
                </h2>
                <p>
                    Dikarenakan Pdt. Djong Tsiu Hiong selalu sibuk, kami tidak dapat mendapatkan informasi tentang
                    beliau.
                </p>
            </div>
        </div>
    </section>

   <?php include "doa_frm.php"; ?>
<?php
include "footer.php";
?>


   



