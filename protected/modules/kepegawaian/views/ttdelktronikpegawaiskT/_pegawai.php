<?php

if (!empty($pegawai->tgl_lahirpegawai)) {
    $pegawai->tgl_lahirpegawai = MyFormatter::formatDateTimeForUser($pegawai->tgl_lahirpegawai);
}
if (!empty($pegawai->jabatan)) {
    $pegawai->jabatan_nama = $pegawai->jabatan->jabatan_nama;
}
if (!empty($pegawai->kelompokpegawai)) {
    $pegawai->kelompokpegawai_nama = $pegawai->kelompokpegawai->kelompokpegawai_nama;
}

?>

<div class="row-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Data Pegawai</div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pegawai, 'nomorindukpegawai', array('class' => 'control-label')); ?>
                            <div clss="controls">
                                <?php echo CHtml::activeTextField($pegawai, 'nomorindukpegawai', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pegawai, 'nama_pegawai', array('class' => 'control-label')); ?>
                            <div clss="controls">
                                <?php echo CHtml::activeTextField($pegawai, 'nama_pegawai', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pegawai, 'tempatlahir_pegawai', array('class' => 'control-label')); ?>
                            <div clss="controls">
                                <?php echo CHtml::activeTextField($pegawai, 'tempatlahir_pegawai', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pegawai, 'tgl_lahirpegawai', array('class' => 'control-label')); ?>
                            <div clss="controls">
                                <?php echo CHtml::activeTextField($pegawai, 'tgl_lahirpegawai', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pegawai, 'jeniskelamin', array('class' => 'control-label')); ?>
                            <div clss="controls">
                                <?php echo CHtml::activeTextField($pegawai, 'jeniskelamin', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pegawai, 'statusperkawinan', array('class' => 'control-label')); ?>
                            <div clss="controls">
                                <?php echo CHtml::activeTextField($pegawai, 'statusperkawinan', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pegawai, 'jabatan_id', array('class' => 'control-label')); ?>
                            <div clss="controls">
                                <?php echo CHtml::activeTextField($pegawai, 'jabatan_nama', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pegawai, 'kelompokpegawai_id', array('class' => 'control-label')); ?>
                            <div clss="controls">
                                <?php echo CHtml::activeTextField($pegawai, 'kelompokpegawai_nama', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>