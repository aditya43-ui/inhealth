<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdialisat_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenisdialisat_id),array('view','id'=>$data->jenisdialisat_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdialisat_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenisdialisat_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdialisat_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenisdialisat_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdialisat_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->jenisdialisat_namalain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdialisat_deskripsi')); ?>:</b>
	<?php echo CHtml::encode($data->jenisdialisat_deskripsi); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdialisat_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenisdialisat_aktif); ?>
	<br />


</div>