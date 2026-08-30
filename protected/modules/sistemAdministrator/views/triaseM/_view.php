<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('triase_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->triase_id),array('view','id'=>$data->triase_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('triase_nama')); ?>:</b>
	<?php echo CHtml::encode($data->triase_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('triase_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->triase_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('warna_triase')); ?>:</b>
	<?php echo CHtml::encode($data->warna_triase); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kode_warnatriase')); ?>:</b>
	<?php echo CHtml::encode($data->kode_warnatriase); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('keterangan_triase')); ?>:</b>
	<?php echo CHtml::encode($data->keterangan_triase); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('triase_aktif')); ?>:</b>
	<?php $triase_aktif =(CHtml::encode($data->triase_aktif == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No'); echo $triase_aktif; ?>
	<br>

</div>