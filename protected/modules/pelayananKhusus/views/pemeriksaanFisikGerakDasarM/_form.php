<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'skrining-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "col-sm-12">
			<div class="control-group ">
				<?php echo $form->labelEx($model,'periksafungsigerakdasar_nama',array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model,'periksafungsigerakdasar_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>100)); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($model,'periksafungsigerakdasar_namalainnya',array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model,'periksafungsigerakdasar_namalainnya',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>100)); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($model,'periksafungsigerakdasar_urutan',array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model,'periksafungsigerakdasar_urutan',array('class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
				</div>
			</div>
		</div>

	</div>
	<div class="row-fluid">
		<div class="form-actions">
			<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
			<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
					$this->createUrl('create'),
					array('class'=>'btn btn-danger',
						  'onclick'=>'return refreshForm(this);')); ?>
			<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Pemeriksaan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
			<?php
                        $tips = array(
                            '0' => 'simpan',
                            '1' => 'ulang',
                        );
                        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips' => $tips),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
        ?>
		</div>
	</div>
<?php $this->endWidget(); ?>
