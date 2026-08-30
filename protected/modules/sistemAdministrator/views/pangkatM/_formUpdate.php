
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sapangkat-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
			'onsubmit' => 'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->dropDownListRow($model,'golonganpegawai_id',  CHtml::listData($model->GolonganPegawaiItems, 'golonganpegawai_id', 'golonganpegawai_nama'),array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <?php echo $form->textFieldRow($model,'pangkat_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'pangkat_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <div class="control-group">
				<?php echo CHtml::label("",'pangkat_aktif', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->checkBox($model,'pangkat_aktif',array('checked'=>'pangkat_aktif')); ?> <label>Aktif</label>
				</div>
				<?php //echo $form->checkBoxRow($model,'pangkat_aktif',array('checked'=>'pangkat_aktif')); ?>
			</div>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                 <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                                                    Yii::app()->createUrl($this->module->id.'/pangkatM/admin'), 
                                                                    array('class' => 'btn btn-default',
                                                                    'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pangkat', array('{icon}'=>'<i class="entypo-folder"></i>')), $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
		<?php
$content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>
