
<table class="status" width="100%" class="">
    <tr class="identitas">
        <td width="10%">Nama</td>
        <td width="40%">: <?php echo (isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : " - "); ?></td>
        <td width="20%">No. RM</td>
        <td width="30%">: <?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : " - "; ?></td>
    </tr>
    <tr class="identitas">
        <td width="10%">Umur</td>
        <td width="40%">: <?php echo (isset($modPasien->umur) ? $modPasien->umur : " - "); ?></td>
        <td width="20%">Kamar / Kelas</td>
        <td width="30%">: <?php echo (isset($modPasien->kamarruangan_nokamar) ? $modPasien->kamarruangan_nokamar : $model->getNoKamar($modPasien->pendaftaran_id)) . ' / ' . (isset($modPasien->kelaspelayanan_nama) ? $modPasien->kelaspelayanan_nama : $model->getKelasPelayanan($modPasien->pendaftaran_id)); ?></td>
    </tr>
    <tr class="identitas">
        <td width="10%">Diagnosa Medis</td>
        <td width="40%">: <?php echo (isset($modPasien->diagnosa_nama) ? $modPasien->diagnosa_nama : $model->getDiagnosaMedis($modPasien->pasien_id, $modPasien->pendaftaran_id)); ?></td>
        <td width="20%">Tgl. Masuk RS</td>
        <td width="30%">: <?php echo isset($modPasien->tgl_pendaftaran) ? MyFormatter::formatDateTimeForUser($modPasien->tgl_pendaftaran) : " - "; ?></td>
    </tr>
    <tr class="identitas">
        <td width="10%">Dokter</td>
        <td width="40%">: <?php echo $model->implementasiaskep->rencanaaskep->diagnosisaskep->pengkajianaskep->anamesa->pegawai->namaLengkap; ?></td>
    </tr>
</table>

<table width="100%" class="grubrincian grid rincian-detail ">
    <tr>
        <th>Tanggal / Jam</th>
        <th colspan="2">Evaluasi</th>
        <th>Paraf / Nama Perawat</th>
    </tr>
    <?php
    $modDetail = ASEvaluasiaskepdetT::model()->findAllByAttributes(array('evaluasiaskep_id' => $model->evaluasiaskep_id));

    if (count($modDetail)) {
        foreach ($modDetail as $i => $detail) {
            ?>
            <tr>
                <td>
                    <?php echo MyFormatter::formatDateTimeForUser($model->evaluasiaskep_tgl); ?>
                </td>
                <td colspan="2">
                    <?php echo "<b>Subjektif:</b>"; ?>
                    <?php echo "<br>"; ?>
                    <?php echo $detail->evaluasiaskepdet_subjektif; ?>
                    <br>
                    <br>
                    <?php echo "<b>Objektif:</b>"; ?>
                    <?php echo "<br>"; ?>
                    <?php echo $detail->evaluasiaskepdet_objektif; ?>
                    <br>
                    <br>
                    <?php echo "<b>Assessment:</b>"; ?>
                    <?php echo "<br>"; ?>
                    <?php echo $detail->evaluasiaskepdet_assessment; ?>
                    <br>
                    <br>
                    <?php echo "<b>Planning:</b>"; ?>
                    <?php echo "<br>"; ?>
                    <?php echo $detail->evaluasiaskepdet_planning; ?>
                    <br>
                    <br>
                    <?php echo "<b>Implementasi:</b>"; ?>
                    <?php echo "<br>"; ?>
                    <?php echo $detail->evaluasiaskepdet_implementasi; ?>
                    <br>
                    <?php echo "<b>Hasil:</b>"; ?>
                    <?php echo "<br>"; ?>
                    <?php echo $detail->evaluasiaskepdet_hasil; ?>
                </td>
                <td>

                </td>

            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td colspan="4">Data tidak ditemukan.</td>
        </tr>
    <?php } ?>
</table>