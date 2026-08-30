<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelrem_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kelrem_id), array('view', 'id'=>$data->kelrem_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelrem_urutan')); ?>:</b>
	<?php echo CHtml::encode($data->kelrem_urutan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelrem_kode')); ?>:</b>
	<?php echo CHtml::encode($data->kelrem_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelrem_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kelrem_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelrem_desc')); ?>:</b>
	<?php echo CHtml::encode($data->kelrem_desc); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelrem_singkatan')); ?>:</b>
	<?php echo CHtml::encode($data->kelrem_singkatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelrem_rate')); ?>:</b>
	<?php echo CHtml::encode($data->kelrem_rate); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('kelrem_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->kelrem_aktif); ?>
	<br>

	*/ ?>

</div>