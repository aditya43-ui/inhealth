<?php
$modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTImeForUser($modPendaftaran->tgl_pendaftaran);
$modPasien->nama_pasien = $modPasien->namadepan . $modPasien->nama_pasien;
$modPasien->tanggal_lahir = MyFormatter::formatDateTImeForUser($modPasien->tanggal_lahir);
?>
<?php
if (!empty($modPasien)) {
    ?>

    <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">Data Pasien</div>
        </div>
        <div class="panel-body">
            <table width="100%" class="table-condensed">
                <tr>
                    <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?></td>

                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?></td>

                </tr>
                <tr>
                    <td><?php echo CHtml::label("Ruangan", 'ruangan_id', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::textField('ruangan_nama',(isset($modPendaftaran->ruangan_nama)? $modPendaftaran->ruangan_nama: ""),array('readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?></td>
                    <td><?php echo CHtml::label('Dokter DPJP', '', array('class' => 'control-label')); ?></td>
                    <td>
                        <?php
                        $pegawaiNamaDpjp = "";
                        $pegawaiId = $modPendaftaran->pegawai_id;

                        if (!empty($pegawaiId)) {
                            $modPeg = PegawaiM::model()->findByPk($pegawaiId);
                            $pegawaiNamaDpjp = (isset($modPeg) ? $modPeg->namaLengkap : "");
                        }
                        ?>
                        <?php echo CHtml::textField('dokterdpjp_id', $pegawaiNamaDpjp, array('readonly' => true)); ?>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top"><?php echo CHtml::label("Kelas", 'kelaspelayanan_id', array('class' => 'control-label')); ?></td>
                    <td style="vertical-align: top"><?php echo CHtml::textField('kelaspelayanan_nama',(isset($modPendaftaran->kelaspelayanan_nama)? $modPendaftaran->kelaspelayanan_nama: ""),array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?></td>
                    <td style="vertical-align: top"><?php echo CHtml::label("Diagnosa", 'diagnosa_id', array('class' => 'control-label')); ?></td>
                    <td style="vertical-align: top"><?php echo CHtml::textArea('diagnosa_nama',$diagnosa_nama,array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?></td>
                </tr>
            </table>
        </div>
    </div>
    <?php
} else {
    Yii::app()->user->setFlash('error', "Tidak ada pasien");
    $this->widget('bootstrap.widgets.BootAlert');
}
?>
