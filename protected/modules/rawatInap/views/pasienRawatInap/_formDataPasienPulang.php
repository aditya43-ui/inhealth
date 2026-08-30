<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if (!empty($modRD)) {
    $modRD->nama_pasien = $modRD->namadepan . $modRD->nama_pasien;
?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="far fa-file-alt"></i> Data <b>Pasien</b>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-condensed">
                <tr>
                    <td><?php echo CHtml::activeLabel($modRD, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modRD, 'tgl_pendaftaran', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modRD, 'no_rekam_medik', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modRD, 'no_rekam_medik', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><label class="control-label">No. Pendaftaran</label></td>
                    <td>
                        <?php echo CHtml::activeTextField($modRD, 'no_pendaftaran', array('readonly' => true, 'class' => 'span2')); ?>
                    </td>

                    <td><?php echo CHtml::activeLabel($modRD, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modRD, 'jeniskelamin', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modRD, 'umur', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modRD, 'umur', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modRD, 'nama_pasien', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modRD, 'nama_pasien', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modRD, 'jeniskasuspenyakit_nama', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modRD, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modRD, 'nama_bin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modRD, 'nama_bin', array('readonly' => true)); ?></td>
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