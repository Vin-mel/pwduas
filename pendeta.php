 <?php
    $query = mysqli_query($conn, "SELECT * FROM tb_pendeta ORDER BY id_pendeta ASC");
    $daftar_pendeta = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $daftar_pendeta[] = $row;
    }
    ?>
   <section id="pendeta">

    <?php if (count($daftar_pendeta) > 0): ?>
    <div class="pendeta-slider">
        <?php foreach($daftar_pendeta as $index => $p): ?>
            <div class="pendeta-slide <?= $index === 0 ? 'aktif' : ''; ?>">
                <h2 class="title-pendeta"><?= strtoupper(htmlspecialchars($p['jabatan'] ?? 'Pendeta')); ?></h2>
                <div class="pendeta-content">
                    <div class="pendeta">
                        <img src="admin/img/<?= htmlspecialchars($p['foto_pendeta']??'default.jpeg')?>" alt="pendeta" />
                    </div>
                    <div class="biodata">
                        <h2><?= htmlspecialchars($p['nama_pendeta'] ?? 'Belum ada data')?></h2>
                        <p><?= nl2br(htmlspecialchars($p['biodata'] ?? 'Informasi Belum Tersedia'))?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

            <?php if(count($daftar_pendeta) > 1) : ?>
                <div class="pendeta-dots">
                    <?php foreach($daftar_pendeta as $index => $p): ?>
                        <span class="dot <?= $index === 0 ? 'aktif' : ''; ?>" data-index="<?= $index; ?>"></span>
                        <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php else: ?>
                    <p style="text-align:center; color: #194d5a; ">Belum ada data pendeta.</p>
                    <?php endif; ?>
    </section>