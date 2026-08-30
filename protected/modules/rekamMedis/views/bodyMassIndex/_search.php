<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'rmbody-mass-index-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'bmi_range', array('placeholder' => 'BMI Range', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'bmi_minimum', array('placeholder' => 'BMI Minimum', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'bmi_maksimum', array('placeholder' => 'BMI Maksimum', 'class' => 'span3')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'bmi_sign', array('placeholder' => 'BMI Sign', 'class' => 'span3', 'maxlength' => 2)); ?>
        <?php echo $form->textAreaRow($model, 'bmi_defenisi', array('placeholder' => 'BMI Defenisi', 'rows' => 3, 'cols' => 50, 'class' => 'span3')); ?>
        <?php echo $form->checkBoxRow($model, 'bodymassindex_aktif', array('checked' => '$data->subrak_aktif')); ?>
    </div>
</div>
<?php //echo $form->textFieldRow($model,'bodymassindex_id',array('class'=>'span3')); 
?>
<?php //echo $form->textFieldRow($model,'bmi_pesan',array('class'=>'span3','maxlength'=>100)); 
?>
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