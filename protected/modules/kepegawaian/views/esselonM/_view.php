<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('esselon_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->esselon_id), array('view', 'id'=>$data->esselon_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('esselon_nama')); ?>:</b>
	<?php echo CHtml::encode($data->esselon_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('esselon_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->esselon_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('esselon_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->esselon_aktif); ?>
	<br>

</div>