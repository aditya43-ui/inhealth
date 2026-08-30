<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('caramasuk_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->caramasuk_id),array('view','id'=>$data->caramasuk_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('caramasuk_nama')); ?>:</b>
	<?php echo CHtml::encode($data->caramasuk_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('caramasuk_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->caramasuk_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('caramasuk_aktif')); ?>:</b>
	<?php echo CHtml::encode(($data->caramasuk_aktif) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')); ?>
	<br>

</div>