<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sakelompok-tindakan-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'kelompoktindakan_nama', array('placeholder' => 'Kelompok Tindakan', 'class' => 'span3', 'maxlength' => 50)); ?>

        <?php echo $form->textFieldRow($model, 'kelompoktindakan_namalainnya', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 50)); ?>

        <?php //echo $form->textFieldRow($model,'kelompoktindakan_persencyto',array('class'=>'span1','maxlength'=>3)); 
        ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelex($model, 'Cyto', array('class' => "control-label required")) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kelompoktindakan_persencyto', array('placeholder' => '00', 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> %
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'kelompoktindakan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kelompoktindakan_aktif', array('checked' => 'kelompoktindakan_aktif')); ?> <label for="SAKelompokTindakanM_kelompoktindakan_aktif">Aktif</label>
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