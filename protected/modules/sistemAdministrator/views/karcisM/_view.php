<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('karcis_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->karcis_id),array('view','id'=>$data->karcis_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_id')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_id')); ?>:</b>
	<?php echo CHtml::encode($data->ruangan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('karcis_nama')); ?>:</b>
	<?php echo CHtml::encode($data->karcis_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('karcis_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->karcis_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('statuspasien')); ?>:</b>
	<?php echo CHtml::encode($data->statuspasien); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('karcis_aktif')); ?>:</b>
	<?php $kabupaten_aktif =(CHtml::encode($data->karcis_aktif == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No');?>
	<br>

</div>