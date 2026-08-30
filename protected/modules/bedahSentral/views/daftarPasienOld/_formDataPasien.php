<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if (!empty($modPasienPenunjang)) {
?>

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Data <b>Pasien</b>
            </div>
        </div>
        <div class="panel-body">
            <table style="width: 100%; border: none;">
                <tr>
                    <td><?php echo CHtml::activeLabel($modPasienPenunjang, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
                    <td>
                        <?php
                        echo CHtml::activeTextField($modPasienPenunjang, 'tgl_pendaftaran', array('readonly' => true));
                        echo CHtml::activeHiddenField($modPasienPenunjang, 'kelaspelayanan_id', array('readonly' => true));
                        ?>
                    </td>
                    <td><?php echo CHtml::activeLabel($modPasienPenunjang, 'no_rekam_medik', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'no_rekam_medik', array('readonly' => true)); ?></td>
                    <td rowspan="4">
                        <?php
                        if (!empty($modPasienPenunjang->photopasien)) {
                            echo CHtml::image(Params::urlPhotoPasienDirectory() . $modPasienPenunjang->photopasien, 'Foto pasien', array('width' => 120));
                        } else {
                            echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('width' => 120));
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="control-label">No. Pendaftaran - Penunjang</label></td>
                    <td>
                        <?php echo CHtml::activeTextField($modPasienPenunjang, 'no_pendaftaran', array('readonly' => true, 'class' => 'span2')); ?>
                        -
                        <?php echo CHtml::activeTextField($modPasienPenunjang, 'no_masukpenunjang', array('readonly' => true, 'class' => 'span2')); ?>
                    </td>

                    <td><?php echo CHtml::activeLabel($modPasienPenunjang, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'jeniskelamin', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPasienPenunjang, 'umur', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'umur', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPasienPenunjang, 'nama_pasien', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'nama_pasien', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPasienPenunjang, 'jeniskasuspenyakit_nama', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?></td>
                    <td><?php echo CHtml::activeLabel($modPasienPenunjang, 'kelaspelayanan_nama', array('class' => 'control-label')); ?></td>
                    <td>
                        <?php echo CHtml::activeTextField($modPasienPenunjang, 'kelaspelayanan_nama', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modPasienPenunjang, 'kelaspelayanan_id', array('readonly' => true)); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPasienPenunjang, 'ruanganasal_nama', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'ruanganasal_nama', array('readonly' => true)); ?></td>
                    <td><?php echo CHtml::label("Kelas Tanggungan", 'kelaspelayanan_nama', array('class' => 'control-label')); ?></td>
                    <td>
                        <?php echo CHtml::activeTextField($modPasienPenunjang, 'kelastanggungan_nama', array('readonly' => true)); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo CHtml::label("Dokter Penerima", 'jeniskasuspenyakit_nama', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'dokterpenerima_nama', array('readonly' => true)); ?></td>
                    <td><?php echo CHtml::label('Jenis Penjamin', 'nama_bin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'penjamin_nama', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::label("DPJP", 'nama_bin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'dpjp_nama', array('readonly' => true)); ?></td>
                    <td><?php echo CHtml::label("Penjamin", 'nama_bin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'carabayar_nama', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><?php echo CHtml::label("Kamar", 'nama_bin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'kamarruangan_nokamar', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><?php echo CHtml::label("No. Bed", 'nama_bin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'kamarruangan_nobed', array('readonly' => true)); ?></td>
                </tr>
            </table>
        </div>
    </div>

    <hr>
<?php
} else {
    Yii::app()->user->setFlash('error', "Data pasien tidak ditemukan");
    $this->widget('bootstrap.widgets.BootAlert');
}

$js = <<< JS
$('#cekRiwayatPasien').change(function(){
        $('#divRiwayatPasien').slideToggle(500);
});
JS;
Yii::app()->clientScript->registerScript('JSriwayatPasien', $js, CClientScript::POS_READY);
?>