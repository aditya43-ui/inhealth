<div class="panel-body table-responsive">
    <table class="table table-striped table-condensed" id="tblListSurveilans">
        <thead>
            <tr>
                <th rowspan="2">Nama</th>
                <th rowspan="2">Tgl. Pasang</th>
                <th rowspan="2">Tgl. Lepas</th>
                <th rowspan="2">Tgl. Infeksi</th>
                <th colspan="5" style="text-align: center">Hari Pemasangan</th>
                <th>Tindakan</th>
                <th colspan="6" style="text-align: center">Infeksi</th>
                <th colspan="4" style="text-align: center">Hasil Kultur</th>
                <th rowspan="2">Ubah</th>
                <th rowspan="2">Batal</th>
            </tr>
            <tr>
                <th>ETT</th>
                <th>PVC</th>
                <th>CVC</th>
                <th>CDL</th>
                <th>UC</th>
                <th>Surgery</th>
                <th>VAP</th>
                <th>IADP</th>
                <th>ISK</th>
                <th>IDO</th>
                <th>Phlebitis</th>
                <th>Dekubitus</th>
                <th>SPUTUM</th>
                <th>Darah</th>
                <th>URINE</th>
                <th>ANTIBIOTIK</th>

            </tr>
        </thead>
        <tbody>
            <?php
            if (count((array)$modRiwayatSurveilans) > 0) {

                foreach ($modRiwayatSurveilans as $data) {

                    $modPasien = PasienM::model()->findByAttributes(array('pasien_id' => $data->pasien_id));

                    $tglpasang = date('Y-m-d');
                    $tglsurveilans = date('Y-m-d');
                    if (!empty($data->pelepasan_tgl)) {
                        $tglpasang = $data->pelepasan_tgl;
                    }
                    if (!empty($data->surveilans_tgl)) {
                        $tglsurveilans = $data->surveilans_tgl;
                    }
                    $selisiSurveilans = CustomFunction::hitungHari($tglpasang, $tglsurveilans);
            ?>
                    <tr>
                        <td><?php echo isset($data->pasien_id) ? $modPasien->nama_pasien : ' '; ?></td>
                        <td><?php echo isset($data->surveilans_tgl) ? MyFormatter::formatDateTimeForUser($data->surveilans_tgl) : ''; ?></td>
                        <td><?php echo isset($data->pelepasan_tgl) ? MyFormatter::formatDateTimeForUser($data->pelepasan_tgl) : ''; ?></td>
                        <td><?php echo isset($data->infeksi_tgl) ? MyFormatter::formatDateTimeForUser($data->infeksi_tgl) : ''; ?></td>
                        <td><?php echo ($data->ett == true) ? $selisiSurveilans : 0; ?></td>
                        <td><?php echo ($data->cvp == true) ? $selisiSurveilans : 0; ?></td>
                        <td><?php echo ($data->cvc == true) ? $selisiSurveilans : 0; ?></td>
                        <td><?php echo ($data->cdl == true) ? $selisiSurveilans : 0; ?></td>
                        <td><?php echo ($data->uc == true) ? $selisiSurveilans : 0; ?></td>
                        <td><?php echo ($data->surgery == true) ? 1 : 0; ?></td>
                        <!--Surgery-->
                        <td><?php echo ($data->vap == true) ? 1 : 0; ?></td>
                        <td><?php echo ($data->iad == true) ? 1 : 0; ?></td>
                        <td><?php echo ($data->isk == true) ? 1 : 0; ?></td>
                        <td><?php echo ($data->ido == true) ? 1 : 0; ?></td>
                        <td><?php echo ($data->pleb == true) ? 1 : 0; ?></td>
                        <td><?php echo ($data->deku == '1') ? 1 : 0; ?></td>
                        <td><?php echo isset($data->sputum) ? $data->sputum : ''; ?></td>
                        <td><?php echo isset($data->darah) ? $data->darah : ''; ?></td>
                        <td><?php echo isset($data->urine) ? $data->urine : ''; ?></td>
                        <td><?php echo isset($data->antibiotik) ? $data->antibiotik : ''; ?></td>
                        <td style="text-align: center; width: 60px;">
                            <?php echo CHtml::link("<i class='icon-form-ubah'></i>", $this->createUrl('index', array('pendaftaran_id' => $data->pendaftaran_id, 'surveilans_id' => $data->surveilans_id))); ?>
                        </td>
                        <td style="text-align: center; width: 60px;">
                            <?php echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'batalSurveilans(' . $data->surveilans_id . ',' . $data->pasien_id . ');return false;')); ?>
                        </td>
                    </tr>

            <?php }
            }

            ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    function batalSurveilans(idSurveilans, pasien_id) {
        myConfirm("Apakah Anda akan mengahapus Pemeriksaan Infeksi ini?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxBatalSurveilans') ?>', {
                    idSurveilans: idSurveilans,
                    pasien_id: pasien_id
                }, function(data) {
                    $('#tblListSurveilans').html(data.result);
                    location.reload();
                }, 'json');
            }
        });
    }
</script>