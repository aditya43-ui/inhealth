<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'rdkeadaan-masuk-m-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'Keadaan/Kondisi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'lookup_name', array('class' => 'span3', 'maxlength' => 200, 'placeholder' => 'Keadaan/Kondisi')); ?>
            </div>
        </div>
        <?php echo $form->checkBoxRow($model, 'lookup_aktif', array('checked' => 'checked')); ?>
    </div>
</div>
<?php //echo $form->textFieldRow($model,'lookup_id',array('class'=>'span5')); 
//echo $form->textFieldRow($model,'lookup_type',array('class'=>'span5','maxlength'=>100)); 
//echo $form->textFieldRow($model,'lookup_name',array('class'=>'span3','maxlength'=>200)); 
//echo $form->textFieldRow($model,'lookup_value',array('class'=>'span5','maxlength'=>200)); 
//echo $form->textFieldRow($model,'lookup_urutan',array('class'=>'span5')); 
//echo $form->textFieldRow($model,'lookup_kode',array('class'=>'span5','maxlength'=>50)); 
?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array(
            'class' => 'btn btn-primary',
            'type' => 'submit',
            'title' => 'Cari',
        )
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