<style>
    body {
        font-size: 8pt;
    }

    .anamnesa_content .ttd {
        text-align: center;
    }
</style>
<div class="anamnesis_judul">PEMERIKSAAN RADIOLOGI</div>
<table class="anamnesa_content">
    <tr>
        <td><?php echo $modKunjungan->getAttributeLabel('nama_pasien') ?></td><td>: <?php echo $modKunjungan->namadepan.$modKunjungan->nama_pasien ?></td>
    </tr>
    <tr>
        <td><?php echo $modKunjungan->getAttributeLabel('umur') ?></td><td>: <?php echo $modKunjungan->umur ?></td>
    </tr>
    <tr>
        <td><?php echo $modKunjungan->getAttributeLabel('jeniskelamin') ?></td><td>: <?php echo $modKunjungan->jeniskelamin ?></td>
    </tr>
    <tr>
        <td><?php echo $modKunjungan->getAttributeLabel('alamat_pasien') ?></td><td>: <?php echo $modKunjungan->alamat_pasien ?></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td width="100">TANGGAL</td>
        <td width="200"><?php echo empty($modKunjungan->tglmasukpenunjang) ? "-" : MyFormatter::formatDateTimeForUser($modKunjungan->tglmasukpenunjang); ?></td>
    </tr>
    <tr>
        <td><?php echo $modKunjungan->getAttributeLabel('no_rekam_medik') ?></td><td>: <?php echo $modKunjungan->no_rekam_medik ?></td>
    </tr>
    <tr>
        <td><?php echo $modKunjungan->getAttributeLabel('tanggal_lahir') ?></td><td>: <?php echo MyFormatter::formatDateTimeForUser($modKunjungan->tanggal_lahir) ?></td>
    </tr>
    <tr>
        <td><?php echo $detailHasil[0]->getAttributeLabel('tglpemeriksaanrad') ?></td>
        <td>: <?php echo empty($detailHasil[0]->tglpemeriksaanrad) ? "-" : MyFormatter::formatDateTimeForUser($detailHasil[0]->tglpemeriksaanrad); ?></td>
    </tr>

</table>
<br/><br/>
Yth, hasil pemeriksaan radiologi :<br/>
<ul>
<?php foreach ($detailHasil as $det){ 
    echo "<li>";
    echo "<strong>".$det->pemeriksaanrad->pemeriksaanrad_nama."</strong><br/>";
    echo "Kesimpulan : ".$det->kesimpulan_hasilrad;
    echo "</li>";
} ?>
</ul>

<table class="anamnesa_content">
    <tr>
        <td>&nbsp;</td>
        <td width="150" class="ttd">
            Banyak Terima Kasih<br/>
            Salam Sejawat<br/>
            <br/><br/><br/><br/>
            <?php 
            $peg = PegawaiM::model()->findByPk($modKunjungan->pegawai_id);
            echo $peg->namaLengkap ?? "-"; echo "<br/>";
            echo "NIP. ".($peg->nomorindukpegawai ?? "-");
            ?>
        </td>
    </tr>
</table>