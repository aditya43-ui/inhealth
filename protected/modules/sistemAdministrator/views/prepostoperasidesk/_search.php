<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'checklistprapost_op-search',
	'type'=>'horizontal',
)); ?>
<div class="row">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label("Jenis Checklist", '', array('class' => 'control-label')) ?>
			<div class="controls">
					<?php echo $form->dropdownList($model,'jenischecklist', array('Pre Operasi'=>'Pre Operasi','Post Operasi'=>'Post Operasi'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)','class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label("Nama Deskripsi", '', array('class' => 'control-label')) ?>
			<div class="controls">
					<?php echo $form->textField($model,'nama_prepostoperasidesk',array('class'=>'span3')); ?>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label("Level", '', array('class' => 'control-label')) ?>
			<div class="controls">
					<?php echo $form->dropdownList($model,'level_prepostoperasidesk', array(1=>1,2=>2,3=>3),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)','class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label("Berhubungan Dengan", '', array('class' => 'control-label')) ?>
			<div class="controls">
					<?php echo $form->dropdownList($model,'parent_id', CHtml::listData(PrepostoperasideskM::model()->findAll('status = true'),'prepostoperasidesk_id','nama_prepostoperasidesk'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)','class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
				<?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
				<div class="controls">
						<?php echo $form->checkBox($model, 'status', array('checked' => 'status')) ?> <label>Aktif</label>
				</div>
		</div>
	</div>
</div>

<div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>

<?php $this->endWidget(); ?>
