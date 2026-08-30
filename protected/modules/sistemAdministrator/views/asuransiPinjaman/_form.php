<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sapremiasuransi-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($model,'asalaset_nama'),
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'umur',array('class'=>'span3 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>7, 'style' => 'text-align:right;')); ?>
            <?php echo $form->textFieldRow($model,'tahun',array('class'=>'span3 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>7, 'style' => 'text-align:right;')); ?>
            <?php echo $form->textFieldRow($model,'persen',array('class'=>'span3 comadesimal-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10, 'style' => 'text-align:right;')); ?>
            
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                       '', 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
            <?php //$this->widget('UserTips',array('type'=>'create'));?>
        <?php
echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Asuransi Pinjaman', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));

$tips = array(
    '0' => 'simpan',
    '1' => 'ulang'
);
$content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips' => $tips),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>
