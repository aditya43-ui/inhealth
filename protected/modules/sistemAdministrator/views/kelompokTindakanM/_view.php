<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompoktindakan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kelompoktindakan_id),array('view','id'=>$data->kelompoktindakan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompoktindakan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kelompoktindakan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompoktindakan_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->kelompoktindakan_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompoktindakan_persencyto')); ?>:</b>
	<?php echo CHtml::encode($data->kelompoktindakan_persencyto); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompoktindakan_urutan')); ?>:</b>
	<?php echo CHtml::encode($data->kelompoktindakan_urutan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompoktindakan_aktif')); ?>:</b>
	<?php $kelompoktindakan_aktif =(CHtml::encode($data->kelompoktindakan_aktif == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No'); echo $kelompoktindakan_aktif;?>
	<br>

</div>