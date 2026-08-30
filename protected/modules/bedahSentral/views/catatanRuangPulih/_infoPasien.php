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
                    <?php echo CHtml::activeLabel($model, 'instalasiasal_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'instalasiasal_nama', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'ruanganasal_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'ruanganasal_nama', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'carabayar_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'carabayar_nama', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'penjamin_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'penjamin_nama', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'no_rekam_medik', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'no_rekam_medik', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'nama_pasien', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'nama_pasien', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'tanggal_lahir', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'tanggal_lahir', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'umur', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'umur', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'jeniskelamin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'jeniskelamin', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>