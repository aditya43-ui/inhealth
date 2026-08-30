<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahKelPenyakit-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )
    );
?>
<p class="help-block">
    <?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?>
</p>
<?php echo $form->errorSummary(array($model)); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
<div class="control-group">
    <div class="controls">
        <?php
            echo $form->dropDownListRow($model, 'bed_triage_id', CHtml::listData(BedTriageM::model()->findAllByAttributes(array('is_aktif'=>true)), 'bed_triage_id', 'no_bed'), array('empty' => '-- Pilih --', 'class' => 'span2 required', 'style'=>'width:200px;','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => isset($model->pendaftaran_id) ? true : false, 'disabled' => isset($model->pendaftaran_id) ? true : false));
        ?>
    </div>
</div>
<div class="control-group">
    <div class="controls">
        <?php echo $form->textFieldRow($model, 'no_bed_triage',array('readonly'=>true, 'class' => 'span2')); ?>
    </div>
</div>
<div class="control-group">
    <div class="controls">
       <?php echo $form->textAreaRow($model,'keterangan',array('rows'=>2, 'cols'=>60, 'class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
    ?>
	<?php
        echo CHtml::htmlButton(
			Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
			array('class' => 'btn btn-default', 'type'=>'button','onClick'=>'closeDialog();')
		);
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
	function closeDialog(){
        $.fn.yiiGridView.update('daftarpasien-v-grid', {
                data: $('form').serialize()
        });
		window.parent.$('#tambahTriage').dialog('close');
	}
</script>