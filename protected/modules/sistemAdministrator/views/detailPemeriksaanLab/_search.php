<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sapemeriksaanlabdet-m-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Pemeriksaan', 'pemeriksaanlab_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pemeriksaanlab_nama', array('class' => 'span3', 'placeholder' => 'Nama Pemeriksaan')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Kelompok Detail', 'kelompokdet', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kelompokdet', array('class' => 'span3', 'placeholder' => 'Kelompok Detail')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Pemeriksaan Detail', 'namapemeriksaandet', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'namapemeriksaandet', array('class' => 'span3', 'placeholder' => 'Nama Pemeriksaan Detail')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Kelamin', 'nilairujukan_jeniskelamin', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'nilairujukan_jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nilai Rujukan', 'nilairujukan_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nilairujukan_nama', array('class' => 'span3 numbers-only', 'placeholder' => 'Nilai Rujukan')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nilai Minimum', 'nilairujukan_min', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nilairujukan_min', array('class' => 'span3 numbers-only', 'placeholder' => 'Nilai Minimum')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nilai Maksimum', 'nilairujukan_max', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nilairujukan_max', array('class' => 'span3 numbers-only', 'placeholder' => 'Nilai Maksimum')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Satuan', 'nilairujukan_satuan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php //echo $form->textField($model,'nilairujukan_satuan',array('class'=>'span3')); 
                ?>
                <?php echo $form->dropDownList($model, 'nilairujukan_satuan', LookupM::getItems('satuanhasillab'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('No. Urut', 'pemeriksaanlabdet_nourut', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pemeriksaanlabdet_nourut', array('class' => 'span3 numbers-only', 'placeholder' => 'No. Urut')); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
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
); ?>
</div>

<?php $this->endWidget(); ?>