<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisalatmedis_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenisalatmedis_id),array('view','id'=>$data->jenisalatmedis_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisalatmedis_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenisalatmedis_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisalatmedis_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->jenisalatmedis_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisalatmedis_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenisalatmedis_aktif); ?>
	<br>

</div>