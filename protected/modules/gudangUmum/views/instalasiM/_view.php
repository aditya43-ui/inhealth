<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('instalasi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->instalasi_id),array('view','id'=>$data->instalasi_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('instalasi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->instalasi_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('instalasi_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->instalasi_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('instalasi_singkatan')); ?>:</b>
	<?php echo CHtml::encode($data->instalasi_singkatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('instalasi_lokasi')); ?>:</b>
	<?php echo CHtml::encode($data->instalasi_lokasi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('instalasi_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->instalasi_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>

</div>