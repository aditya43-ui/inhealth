<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kecamatan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kecamatan_id),array('view','id'=>$data->kecamatan_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kabupaten_id')); ?>:</b>
	<?php echo CHtml::encode($data->kabupaten->kabupaten_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kecamatan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kecamatan_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kecamatan_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->kecamatan_namalainnya); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kecamatan_aktif')); ?>:</b>
	<?php $kecamatan_aktif =(CHtml::encode($data->kecamatan_aktif == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No'); echo $kecamatan_aktif; ?>
	<br />


</div>