<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sakelompok-umur-m-search',
    'type' => 'horizontal',
)); ?>

<?php //echo $form->textFieldRow($model,'kelompokumur_id',array('class'=>'span5')); 
?>

<?php echo $form->textFieldRow($model, 'kelompokumur_nama', array('class' => 'span5', 'maxlength' => 25)); ?>

<?php echo $form->textFieldRow($model, 'kelompokumur_namalainnya', array('class' => 'span5', 'maxlength' => 25)); ?>

<?php echo $form->textFieldRow($model, 'kelompokumur_minimal', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'kelompokumur_maksimal', array('class' => 'span5')); ?>

<?php echo $form->checkBoxRow($model, 'kelompokumur_aktif'); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>