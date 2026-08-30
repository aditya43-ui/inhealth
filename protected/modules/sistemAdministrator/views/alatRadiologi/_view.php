<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanalatrad_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pemeriksaanalatrad_id),array('view','id'=>$data->pemeriksaanalatrad_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('alatmedis_id')); ?>:</b>
	<?php echo CHtml::encode($data->alatmedis_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanalatrad_kode')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanalatrad_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanalatrad_nama')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanalatrad_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanalatrad_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanalatrad_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanalatrad_aetitle')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanalatrad_aetitle); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanalatrad_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanalatrad_aktif); ?>
	<br>

</div>