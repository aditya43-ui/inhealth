<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kabupaten_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kabupaten_id),array('view','id'=>$data->kabupaten_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('propinsi_id')); ?>:</b>
	<?php echo CHtml::encode($data->propinsi->propinsi_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kabupaten_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kabupaten_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kabupaten_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->kabupaten_namalainnya); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kabupaten_aktif')); ?>:</b>
	<?php $kabupaten_aktif =(CHtml::encode($data->kabupaten_aktif == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No'); echo $kabupaten_aktif;?>
	<br />


</div>