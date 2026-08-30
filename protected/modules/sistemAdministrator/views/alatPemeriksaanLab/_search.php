<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sapemeriksaanlabmapping-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Alat lab.', 'pemeriksaanlabalat_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pemeriksaanlabalat_nama', array('class' => 'span3', 'placeholder' => 'Nama Alat Lab.')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Kode Pemeriksaan ', 'pemeriksaanlabalat_kode', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pemeriksaanlabalat_kode', array('class' => 'span3', 'placeholder' => 'Kode Pemeriksaan')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Kelompok Detail ', 'kelompokdet', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kelompokdet', array('class' => 'span3', 'placeholder' => 'Kelompok Detail')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Pemeriksaan Detail ', 'namapemeriksaandet', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'namapemeriksaandet', array('class' => 'span3', 'placeholder' => 'Pemeriksaan Detail')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Kelamin', 'nilairujukan_jeniskelamin', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'nilairujukan_jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nilai Rujukan', 'nilairujukan_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nilairujukan_nama', array('class' => 'span3', 'placeholder' => 'Nilai Rujukan')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nilai Minimum', 'nilairujukan_min', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nilairujukan_min', array('class' => 'span3', 'placeholder' => 'Nilai Minimum')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nilai Maksimum', 'nilairujukan_max', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nilairujukan_max', array('class' => 'span3', 'placeholder' => 'Nilai Maksimum')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Satuan', 'nilairujukan_satuan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nilairujukan_satuan', array('class' => 'span3', 'placeholder' => 'Satuan')); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'submit', 'title' => 'Cari')
    ); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
); ?></div>

<?php $this->endWidget(); ?>