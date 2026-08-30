<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'ppkelurahan-m-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'kecamatan_id'),
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php //echo $form->textFieldRow($model,'kelurahan_id',array('class'=>'span5')); 
        ?>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'kecamatan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'kecamatan_id',  CHtml::listData($model->KecamatanItems, 'kecamatan_id', 'kecamatan_nama'), array('class' => 'span3 form-control', 'style' => 'width:160px', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'kelurahan_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kelurahan_nama', array('placeholder' => 'Kelurahan', 'class' => 'span3  form-control', 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'kelurahan_namalainnya', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kelurahan_namalainnya', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'kode_pos', array('placeholder' => 'Kode Pos', 'class' => 'span3  form-control', 'maxlength' => 15)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'kelurahan_aktif', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kelurahan_aktif', array('checked' => 'checked')); ?> <label>Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
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