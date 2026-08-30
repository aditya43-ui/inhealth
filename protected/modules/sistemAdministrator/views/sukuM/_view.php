<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('suku_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->suku_id),array('view','id'=>$data->suku_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('suku_nama')); ?>:</b>
	<?php echo CHtml::encode($data->suku_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('suku_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->suku_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('suku_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->suku_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>

</div>