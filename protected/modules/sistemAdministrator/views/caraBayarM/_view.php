<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('carabayar_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->carabayar_id),array('view','id'=>$data->carabayar_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('carabayar_nama')); ?>:</b>
	<?php echo CHtml::encode($data->carabayar_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('carabayar_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->carabayar_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('metode_pembayaran')); ?>:</b>
	<?php echo CHtml::encode($data->metode_pembayaran); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('carabayar_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->carabayar_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>

</div>