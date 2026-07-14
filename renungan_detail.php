<?php
include "koneksi.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];
$stmt = mysqli_prepare($conn, "SELECT * FROM tb_renungan WHERE id_renungan = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$renungan = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$renungan) {
    header("Location: index.php");
    exit;
}

include "header.php";
?>

<section class="renungan-detail-page">
    <div class="renungan-detail-container">
        <a href="index.php#renung" class="btn-kembali">&larr; Kembali</a>

        <img src="admin/img/<?= htmlspecialchars($renungan['gambar_renungan']); ?>" alt="Renungan" class="detail-image">

        <h1 class="detail-judul"><?= htmlspecialchars($renungan['judul_renungan']); ?></h1>

        <p class="detail-tanggal">
            <?php
            $bulan_indo = [1=>'Januari' ,2=>'Februari' ,3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
            $timestamp = strtotime($renungan['tanggal_publish']);
            echo date('d', $timestamp) . ' ' . $bulan_indo[(int) date('n', $timestamp)] . ' ' . date('Y', $timestamp);
            ?>
        </p>

        <div class="detail-ayat-box">
            <p class="detail-ayat-judul">Baca: <?= htmlspecialchars($renungan['referensi_ayat']); ?></p>
            <div class="detail-ayat-isi">
                <?= nl2br(htmlspecialchars($renungan['isi_ayat'])); ?>
            </div>
        </div>

        <div class="detail-isi">
            <?= nl2br(htmlspecialchars($renungan['isi_lengkap'])); ?>
        </div>

        <?php if (!empty($renungan['link_sumber'])): ?>
            <p class="detail-sumber">
                Referensi tambahan: <a href="<?= htmlspecialchars($renungan['link_sumber']); ?>" target="_blank" rel="noopener"><?= htmlspecialchars($renungan['link_sumber']); ?></a>
            </p>
        <?php endif; ?>
    </div>
</section>
<?php include "footer.php"; ?>