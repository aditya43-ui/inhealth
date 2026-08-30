<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'backdate-k-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
            <?php echo $form->dropDownListRow($model,'modul_id',CHtml::listData(ModulK::model()->findAll('modul_aktif = true order by modul_nama asc'), 'modul_id', 'modul_nama'), array('empty' => '-- Pilih --', 'class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'deskripsi_menu',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'deskripsi_backdate',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model,'isbackdate', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
	<div class="row-fluid">
            <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                $this->createUrl('create'), 
                                array('class'=>'btn btn-danger',
                                          'onclick'=>'return refreshForm(this);')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Konfigurasi Konfigurasi ',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
                <?php $this->widget('UserTips',array('content'=>''));?>
            </div>
	</div>
<?php $this->endWidget(); ?>
