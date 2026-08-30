<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosaicdix_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->diagnosaicdix_id),array('view','id'=>$data->diagnosaicdix_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosaicdix_kode')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosaicdix_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosaicdix_nama')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosaicdix_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosaicdix_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosaicdix_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosatindakan_katakunci')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosatindakan_katakunci); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosaicdix_nourut')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosaicdix_nourut); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosaicdix_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosaicdix_aktif); ?>
	<br>

</div>