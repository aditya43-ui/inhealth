<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskelas_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jeniskelas_id),array('view','id'=>$data->jeniskelas_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskelas_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskelas_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskelas_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskelas_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskelas_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->jeniskelas_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>
</div>