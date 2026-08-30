<?php

$admisi = PasienadmisiT::model()->findByAttributes(array(
    'pendaftaran_id' => $model->pendaftaran_id,
), array(
    'order' => 'pasienadmisi_id desc'
));

if (!empty($admisi)) {
    $model->ruangan_id = $admisi->ruangan_id;
    $model->instalasi_id = $admisi->ruangan->instalasi_id;
}

$model->pasien->tanggal_lahir = MyFormatter::formatDateTimeForUser($model->pasien->tanggal_lahir);
$model->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($model->tgl_pendaftaran);

?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <form class="form-horizontal">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'tgl_pendaftaran', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'no_pendaftaran', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'no_pendaftaran', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model->instalasi, 'instalasi_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model->instalasi, 'instalasi_nama', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model->ruangan, 'ruangan_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model->ruangan, 'ruangan_nama', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model->carabayar, 'carabayar_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model->carabayar, 'carabayar_nama', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model->penjamin, 'penjamin_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model->penjamin, 'penjamin_nama', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model->pasien, 'no_rekam_medik', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model->pasien, 'no_rekam_medik', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model->pasien, 'nama_pasien', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model->pasien, 'nama_pasien', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model->pasien, 'tanggal_lahir', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model->pasien, 'tanggal_lahir', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'umur', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'umur', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model->pasien, 'jeniskelamin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model->pasien, 'jeniskelamin', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>