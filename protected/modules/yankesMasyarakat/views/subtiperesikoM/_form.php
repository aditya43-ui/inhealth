<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'subtiperesiko-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span6">
                    <?php echo $form->dropDownListRow($model,'tiperesiko_id',Chtml::listData(TiperesikoM::model()->findAllByAttributes(array('tiperesiko_aktif'=>true)),'tiperesiko_id','tiperesiko_nama'),array('class'=>'span3','empty'=>'-- Pilih --')); ?>
                    <?php echo $form->textFieldRow($model,'subtiperesiko_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>500)); ?>
		</div>
		<div class = "span6">
                    <?php echo $form->textFieldRow($model,'subtiperesiko_urutan',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textAreaRow($model,'subtiperesiko_keterangan',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php 
                     if (isset($_GET['id'])) {
                        echo $form->checkBoxRow($model,'subtiperesiko_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);", 'title' => 'Klik untuk Mengaktifkan / Menonaktifkan Sub Tipe Risiko'));     
                     }
                    ?>
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Sub Tipe Risiko',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php 
                    $content = $this->renderPartial($this->path_tips . 'master', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>
		</div>
	</div>
<?php $this->endWidget(); ?>
