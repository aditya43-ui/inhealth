<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'lkrujukankeluar-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
			'onsubmit' => 'return requiredCheck(this);'),
        'focus'=>'#LKRujukankeluarM_rumahsakitrujukan',
)); ?>
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
<?php echo $form->errorSummary($model); ?>
<div class="row">
	<div class="col-sm-12">
		<div class="control-group">
			<?php echo CHtml::label("Rujukan Keluar <span class='required'>*</span>",'',array('class' => 'control-label required')) ?>
			<div class="controls">
				<?php echo $form->textField($model,'rumahsakitrujukan',array('class'=>'span3 form-control', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo CHtml::label("Alamat",'',array('class' => 'control-label')) ?>
			<div class="controls">	
				<?php echo $form->textArea($model,'alamatrsrujukan',array('rows'=>3, 'style'=>'width:170px;', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
    
		<div class="control-group">
			<?php echo CHtml::label("Telp Fax",'',array('class' => 'control-label')) ?>
			<div class="controls">	
				<?php echo $form->textField($model,'telp_fax',array('class'=>'span3 form-control', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			</div>
		</div>
            
	</div>
</div>

<div class="form-actions">
    <?php 
	if (!isset($_GET['sukses'])){
		echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); 
	}else{
		echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type'=>'button','onKeypress'=>'return formSubmit(this,event)', 'disabled'=>true)); 
	}
		?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), 
        array('class' => 'btn btn-default',
        'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>   
</div>

<?php $this->endWidget(); ?>
