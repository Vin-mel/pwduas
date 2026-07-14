<?php
session_start();
$doa_status = $_SESSION['doa_status'] ?? null;
unset($_SESSION['doa_status']); 
?>
<?php
include "header.php";
include "koneksi.php";

     $hari_ini = date('Y-m-d');
     $stmt_renungan = mysqli_prepare($conn, "SELECT * FROM tb_renungan WHERE DATE(tanggal_publish) = ? ORDER BY tanggal_publish DESC LIMIT 1");
     mysqli_stmt_bind_param($stmt_renungan, "s", $hari_ini);
     mysqli_stmt_execute($stmt_renungan);
     $result_renungan = mysqli_stmt_get_result($stmt_renungan);
     $tb_renungan = mysqli_fetch_assoc($result_renungan);
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
                <img src="admin/img/<?php echo htmlspecialchars($tb_renungan['gambar_renungan']); ?>" alt="Renungan Hari Ini">
            </div>
          <div class="renungan-info">
    <div class="renungan-header">
        <span class="tag">Renungan Harian</span>
        <span class="tanggal-renungan">
            <?php 
            $bulan_indo = [
                1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
            ];
            $timestamp = strtotime($tb_renungan['tanggal_publish']);
            echo date('d', $timestamp) . ' ' . $bulan_indo[(int)date('n', $timestamp)] . ' ' . date('Y', $timestamp);
            ?>
        </span>
    </div>
   <blockquote class="ayat">
    "<?php echo nl2br(htmlspecialchars($tb_renungan['isi_ayat_singkat'])); ?>"
    <br><strong>(<?php echo htmlspecialchars($tb_renungan['referensi_ayat']); ?>)</strong>
</blockquote>
    <a href="renungan_detail.php?id=<?= $tb_renungan['id_renungan']; ?>" class="btn-renungan">
        <span>Baca Selengkapnya</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
        </svg>
    </a>
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
   



