<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Rencana Tindakan</div>
    </div>
    <div class="panel-body">
        <table id="table_riwayatrenctindakan" class="table table-condensed table-bordered">
            <thead>
            <th>Pilih</th>
            <th>Tanggal Rencana Tindakan</th>
            <th>Kategori Rencana Tindakan</th>
            <th width="30%">Rencana Tindakan</th>
            <th>Jumlah</th>
            <th>Dokter</th>
        </thead>
        <tbody>
            <?php
            if (count((array)$modRiwayatTindakans) > 0) {
                foreach ($modRiwayatTindakans AS $i => $tindakan) {
                    ?>
                    <tr>
                        <td>
                            <?php echo CHtml::hiddenField('no_urut', 0, array('readonly' => true,
                                'class' => 'span1 integer', 'style' => 'width:20px;')); ?>
                            <?php
                            echo CHtml::activeCheckBox($tindakan, '[' . $tindakan->daftartindakan_id . ']is_pilihtindakan', array(
                                'value' => $tindakan->daftartindakan_id, 'onclick' => "addRencanaTindakan(this)"));
        //            echo '<label class="checkbox inline">'.CHtml::activeCheckBox($pemeriksaanRad,'['.$pemeriksaanRad->pemeriksaanrad_id.']is_pilih', array('value'=>$pemeriksaanRad->pemeriksaanrad_id, 'onclick' => "pilihPemeriksaanIni(this)"));
                            ?>
                            <?php echo CHtml::activeHiddenField($tindakan, '[0]tarifsatuan', array(
                                'readonly' => true, 'class' => 'span1 ')) ?>
                            <?php echo CHtml::activeHiddenField($tindakan, '[0]daftartindakan_id', array(
                                'readonly' => true, 'class' => 'span1 ')) ?>
                <?php echo CHtml::activeHiddenField($tindakan, '[0]pendaftaran_id', array(
                    'readonly' => true, 'class' => 'span1 ')) ?>
                            <?php echo CHtml::activeHiddenField($tindakan, '[0]pasien_id', array(
                                'readonly' => true, 'class' => 'span1')) ?>
                            <?php echo CHtml::activeHiddenField($tindakan, '[0]verifrenctindakan_id', array(
                                'readonly' => true, 'class' => 'span1 ')) ?>
                <?php echo CHtml::activeHiddenField($tindakan, '[0]rencanatindakan_id', array(
                    'readonly' => true, 'class' => 'span1 ')) ?>
                        </td>
                        <td><?php echo ($format->formatDateTimeForUser($tindakan->tglrencanatindakan)); ?></td>
                        <td>
                    <?php echo $tindakan->daftartindakan->kategoritindakan_nama; ?><br>
                        </td>
                        <td>
                <?php echo $tindakan->daftartindakan->daftartindakan_nama; ?><br>
                        </td>
                        <td style='text-align:center'><?php echo CHtml::textField('riwayatTindakan[' . $i . '][qty_tindakan]', $tindakan->qty_rentindakan, array(
                    'readonly' => true, 'class' => 'integer', 'style' => 'width:30px;')); ?></td>
                        <td><?php echo isset($tindakan->pegawai->NamaLengkap) ? $tindakan->pegawai->NamaLengkap : ""; ?></td>
                    </tr>
                <?php
            }
        }
        ?>
        </tbody>
        </table>

    </div>
</div>

