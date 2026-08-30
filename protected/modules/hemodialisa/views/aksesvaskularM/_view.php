<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('aksesvaskular_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->aksesvaskular_id),array('view','id'=>$data->aksesvaskular_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aksesvaskular_id')); ?>:</b>
	<?php echo CHtml::encode($data->aksesvaskular_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aksesvaskular_nama')); ?>:</b>
	<?php echo CHtml::encode($data->aksesvaskular_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aksesvaskular_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->aksesvaskular_namalain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aksesvaskular_deskripsi')); ?>:</b>
	<?php echo CHtml::encode($data->aksesvaskular_deskripsi); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aksesvaskular_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->aksesvaskular_aktif); ?>
	<br />


</div>