<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosa_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->diagnosa_id),array('view','id'=>$data->diagnosa_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosa_kode')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosa_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosa_nama')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosa_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosa_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosa_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosa_katakunci')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosa_katakunci); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosa_nourut')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosa_nourut); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosa_imunisasi')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosa_imunisasi); ?>
	<br>
        <b><?php echo CHtml::encode($data->getAttributeLabel('diagnosa_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->diagnosa_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>
	<?php /*

	*/ ?>

</div>