<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'setting-print-form',
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('class'=>'form-horizontal'),
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="control-group">
    <?php echo CHtml::label('Ukuran Kertas', 'print_ukuranKertas', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::dropDownList('print[ukuranKertas]',Yii::app()->user->getState('ukuran_kertas'), CustomFunction::getUkuranKertas(), array('class'=>'span3')); ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('Posisi Kertas', 'print_posisiKertas', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::dropDownList('print[posisiKertas]', Yii::app()->user->getState('posisi_kertas'), CustomFunction::getPosisiKertas(), array('class'=>'span3')); ?>
    </div>
</div>
<div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                        array('class' => 'btn btn-danger', 'type'=>'submit', 'name'=>'btn_simpan')); ?>
</div>
<?php $this->endWidget(); ?>
