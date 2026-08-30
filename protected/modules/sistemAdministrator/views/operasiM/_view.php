<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('operasi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->operasi_id),array('view','id'=>$data->operasi_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_id')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kegiatanoperasi_id')); ?>:</b>
	<?php echo CHtml::encode($data->kegiatanoperasi_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('operasi_kode')); ?>:</b>
	<?php echo CHtml::encode($data->operasi_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('operasi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->operasi_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('operasi_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->operasi_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('operasi_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->operasi_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>

</div>