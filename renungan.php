 <?php
 $hari_ini = date('Y-m-d');
     $stmt_renungan = mysqli_prepare($conn, "SELECT * FROM tb_renungan WHERE DATE(tanggal_publish) = ? ORDER BY tanggal_publish DESC LIMIT 1");
     mysqli_stmt_bind_param($stmt_renungan, "s", $hari_ini);
     mysqli_stmt_execute($stmt_renungan);
     $result_renungan = mysqli_stmt_get_result($stmt_renungan);
     $tb_renungan = mysqli_fetch_assoc($result_renungan);
?>

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
