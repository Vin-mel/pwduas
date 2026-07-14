<?php
session_start();
$doa_status = $_SESSION['doa_status'] ?? null;
unset($_SESSION['doa_status']); 
?>
<?php
include "header.php";
include "koneksi.php";
  ?>

     <section class="hero" id="home">
        <main class="content">
            <h1> Welcome Home</h1>
            <p>Tempat Bagi Yang Berbeban Berat</p>
        </main>
    </section>

<?php include "renungan.php"; ?>

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

           if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="images">';
                    echo '<img src="admin/img/' . htmlspecialchars($row['nama_file_gambar']) . '" alt="Dokumentasi GKKB" />';
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
        <?php
        $query_jadwal = mysqli_query($conn, "SELECT * FROM tb_jadwal ORDER BY FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'), jam_mulai ASC");

        $jadwal_grouped = [];
        while ($row = mysqli_fetch_assoc($query_jadwal)) {
            $jadwal_grouped[$row['hari']][] = $row;
        }

        foreach ($jadwal_grouped as $hari => $daftar_kegiatan) {
            ?>
            <div class="jadwal">
                <h2><?= strtoupper(htmlspecialchars($hari)); ?></h2>

                <?php if (count($daftar_kegiatan) === 1): ?>
                    <?php $item = $daftar_kegiatan[0]; ?>
                    <h2><?= htmlspecialchars($item['nama_kegiatan']); ?></h2>
                    <div class="jam">
                        <i data-feather="clock"></i>
                        <p class="pkl"><?= date('H:i', strtotime($item['jam_mulai'])); ?></p>
                    </div>
                <?php else: ?>
                    <div class="list-minggu">
                        <?php foreach ($daftar_kegiatan as $item): ?>
                            <div class="sesi">
                                <h3><?= htmlspecialchars($item['nama_kegiatan']); ?></h3>
                                <div class="jam-mini">
                                    <i data-feather="clock"></i>
                                    <span><?= date('H:i', strtotime($item['jam_mulai'])); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php
        }
        ?>
    </div>
</section>

    <!-- Pendeta -->
     <?php
    $query = mysqli_query($conn, "SELECT * FROM tb_pendeta ORDER BY id_pendeta DESC LIMIT 1");
    $pendeta = mysqli_fetch_assoc($query);
    ?>
    <section id="pendeta">
        <h2 class="title-pendeta">PENDETA</h2>
        <div class="pendeta-content">
            <div class="pendeta">
                <img src="admin/img/<?= htmlspecialchars($pendeta['foto_pendeta']??'defualt.jpeg')?>" alt="pendeta" />
            </div>
            <div class="biodata">
                <h2>
                    <?= htmlspecialchars($pendeta['nama_pendeta'] ?? 'Belum ada data')?>
                </h2>
                <p>
                    <?= nl2br(htmlspecialchars($pendeta['biodata'] ?? 'Informasi Belum Tersedia'))?>
                </p>
            </div>
        </div>
    </section>

   <?php include "doa_frm.php"; ?>
<?php
include "footer.php";
?>
<?php if ($doa_status): ?>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
        <?php if ($doa_status === 'berhasil'): ?>
            alert("Permohonan doa berhasil dikirim!");
        <?php elseif ($doa_status === 'kosong'): ?>
            alert("Mohon isi semua kolom.");
        <?php elseif ($doa_status === 'gagal'): ?>
            alert("Gagal mengirim, silakan coba lagi.");
        <?php endif; ?>
    });
    </script>
<?php endif; ?>
   



