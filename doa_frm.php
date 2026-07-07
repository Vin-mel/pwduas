<?php
include "koneksi.php";?>
 <!--Permohonan doa-->
    <section id="permohonan">
        <div class="doa-container">
            <div class="doa-header">
                <h2> Permohonan Doa</h2>
                <p>Tuliskan pergumulanmu, kami akan turut mendoakan</p>
            </div>
            <form id="doaForm" action="sv_doa.php" method="POST">
                <div class="input-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama Kamu...">
                </div>
                <div class="input-group">
                    <label for="isi_doa">Isi Doa/ PergumulanMu</label>
                    <textarea id="isi_doa" name="isi_doa" rows="4" placeholder="Apa yang ingin kamu daokan?"></textarea>
                </div>
                <button type="submit" class="btn-submit">Kirim Permohonan</button>
            </form>
    </section>