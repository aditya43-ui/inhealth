<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('subsubkelompok_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->subsubkelompok_id), array('view', 'id'=>$data->subsubkelompok_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subkelompok_id')); ?>:</b>
	<?php echo CHtml::encode($data->subkelompok_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subsubkelompok_kode')); ?>:</b>
	<?php echo CHtml::encode($data->subsubkelompok_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subsubkelompok_nama')); ?>:</b>
	<?php echo CHtml::encode($data->subsubkelompok_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subsubkelompok_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->subsubkelompok_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subsubkelompok_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->subsubkelompok_aktif); ?>
	<br>

</div>