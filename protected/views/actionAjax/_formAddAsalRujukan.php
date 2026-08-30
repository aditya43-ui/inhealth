<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'asalrujukan-add-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#AsalrujukanM_asalrujukan_nama',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>


	<!-- <p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p> -->

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'asalrujukan_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'asalrujukan_institusi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>20)); ?>
            <?php echo $form->textFieldRow($model,'asalrujukan_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>20)); ?>
            <?php //echo $form->checkBoxRow($model,'asalrujukan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
	
	<div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                   Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                    array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
	</div>

<?php $this->endWidget(); ?>
