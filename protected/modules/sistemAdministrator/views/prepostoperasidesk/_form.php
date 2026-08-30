<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'checklistprapost_op-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
		<div class = "col-sm-6">
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Jenis Checklist <span class="required">*</span>',array('class'=>'control-label required')); ?>
					<div class="controls">
						<?php echo $form->dropDownList($model,'jenischecklist', array('Pre Operasi'=>'Pre Operasi','Post Operasi'=>'Post Operasi'),array('class'=>'span3', 'empty' => '-- Pilih --')); ?>
				</div>
			</div>
			<?php echo $form->textFieldRow($model,'nama_prepostoperasidesk',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
			<?php echo $form->textFieldRow($model,'urutan',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

		</div>
		<div class = "col-sm-6">
			<div class="control-group ">
				<?php echo $form->labelEx($model,'level_prepostoperasidesk',array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->dropDownList($model,'level_prepostoperasidesk', array(1=>1,2=>2,3=>3),array('class'=>'span3', 'empty' => '-- Pilih --')); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($model,'parent_id',array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->dropDownList($model,'parent_id', CHtml::listData(PrepostoperasideskM::model()->findAll('status = true'),'prepostoperasidesk_id','jenisNamaOperasi'),array('class'=>'span3', 'empty' => '-- Pilih --')); ?>
				</div>
			</div>
			<?php if(!empty($model->prepostoperasidesk_id)){ ?>
			<div class="control-group ">
				<?php echo CHtml::label('','',array('class'=>'control-label')); ?>
					<div class="controls">
						<div class="checkbox">
							<?php echo $form->checkBox($model,'status', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>Aktif</label>
						</div>
					</div>
			</div>
			<?php } ?>

		</div>

	</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
				$this->createUrl('create'),
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Checklist Pra dan Post Operasi',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php
                        $tips = array(
                            '0' => 'autocomplete-search',
                            '1' => 'simpan',
                            '2' => 'ulang',
                        );
                        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips' => $tips),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
        ?>
		</div>
<?php $this->endWidget(); ?>
