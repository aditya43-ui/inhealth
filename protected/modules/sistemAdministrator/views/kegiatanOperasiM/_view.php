<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kegiatanoperasi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kegiatanoperasi_id),array('view','id'=>$data->kegiatanoperasi_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kegiatanoperasi_kode')); ?>:</b>
	<?php echo CHtml::encode($data->kegiatanoperasi_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kegiatanoperasi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kegiatanoperasi_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kegiatanoperasi_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->kegiatanoperasi_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kegiatanoperasi_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->kegiatanoperasi_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>

</div>