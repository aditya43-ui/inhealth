<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('asalaset_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->asalaset_id),array('view','id'=>$data->asalaset_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('asalaset_nama')); ?>:</b>
	<?php echo CHtml::encode($data->asalaset_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('asalaset_singkatan')); ?>:</b>
	<?php echo CHtml::encode($data->asalaset_singkatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('asalaset_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->asalaset_aktif); ?>
	<br>

</div>