<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pendidikan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pendidikan_id),array('view','id'=>$data->pendidikan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pendidikan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->pendidikan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pendidikan_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->pendidikan_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pendidikan_aktif')); ?>:</b>
	<?php echo CHtml::encode(($data->pendidikan_aktif)? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')); ?>
	<br>

</div>