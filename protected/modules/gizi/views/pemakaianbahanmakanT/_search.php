<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'id' => 'gupemakaianbarang-t-search',
	'type' => 'horizontal',
)); ?>
<div class="row">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($model, 'tglpemakaianbrg', array('class' => 'control-label')) ?>
			<div class="controls">
				<div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tglAwal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tglAkhir)) ?>">
					<i class="entypo-calendar"></i>
					<span><?php echo date('d M Y', strtotime($model->tglAwal)) ?> - <?php echo date('d M Y', strtotime($model->tglAkhir)) ?></span>
					<?php echo $form->hiddenField($model, 'tglAwal', array('class' => 'start')) ?>
					<?php echo $form->hiddenField($model, 'tglAkhir', array('class' => 'end')) ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model, 'nopemakaianbrg', array('class' => 'span3', 'maxlength' => 20)); ?>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(
		Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
		array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
	); ?>
	<?php echo CHtml::htmlButton(
		Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
		array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
	); ?>
	<?php
	//$content = $this->renderPartial('gudangUmum.views.tips.informasi',array(),true);
	//$this->widget('TipsMasterData',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>