<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'edukasib-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label("Nama Edukasi", '', array('class' => 'control-label')) ?>
			<div class="controls">
					<?php echo $form->dropdownList($model,'nama_edukasi',array('Penjelasan/KIE'=>'Penjelasan/KIE','Keterangan dan Evaluasi'=>'Keterangan dan Evaluasi'),array('class'=>'span3','empty'=>'- Pilih -')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label("Isi Edukasi", '', array('class' => 'control-label')) ?>
			<div class="controls">
					<?php echo $form->textField($model,'isi_edukasi',array('class'=>'span3')); ?>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="control-group">
				<?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
				<div class="controls">
						<?php echo $form->checkBox($model, 'status', array('checked' => 'status')) ?> <label>Aktif</label>
				</div>
		</div>
	</div>
</div>

<div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-default', 'type'=>'reset')); ?>
</div>

<?php $this->endWidget(); ?>
