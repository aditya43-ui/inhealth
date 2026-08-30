<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelurahan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kelurahan_id),array('view','id'=>$data->kelurahan_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kecamatan_id')); ?>:</b>
	<?php echo CHtml::encode($data->kecamatan->kecamatan_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelurahan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kelurahan_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelurahan_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->kelurahan_namalainnya); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kode_pos')); ?>:</b>
	<?php echo CHtml::encode($data->kode_pos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelurahan_aktif')); ?>:</b>
	<?php $kelurahan_aktif =(CHtml::encode($data->kelurahan_aktif == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No'); echo $kelurahan_aktif; ?>
	<br />


</div>