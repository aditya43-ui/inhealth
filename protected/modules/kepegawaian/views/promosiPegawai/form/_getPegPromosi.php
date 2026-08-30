<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahKelPenyakit-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit' => 'return cekSubmit(this);return false;'),
        )
    );
?>

<?php echo $form->hiddenField($model, 'pegpromosi_id',array('readonly'=>true)); ?>
<?php echo $form->hiddenField($model, 'prom_pimpinan_nama',array('readonly'=>true)); ?>

<div class="control-group">
    <?php echo CHtml::label('Status', 'ap', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->dropDownList($model,'prom_status', Params::getStatusPromosi(),  
                        array('class' => 'required','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", )); ?>   

    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Alasan', 'k', array('class'=>'control-label')) ?>
    <div class="controls">       
       <?php echo $form->textArea($model,'prom_alasan',array('placeholder'=>'Alasan Ditolak/Disetujui','rows'=>2, 'cols'=>60, 'class'=>'autogrow required ', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit'));
    ?>
	
</div>
<?php $this->endWidget(); ?>
