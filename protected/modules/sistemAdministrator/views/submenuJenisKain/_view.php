<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahanlinen_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->bahanlinen_id),array('view','id'=>$data->bahanlinen_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahanlinen_nama')); ?>:</b>
	<?php echo CHtml::encode($data->bahanlinen_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahanlinen_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->bahanlinen_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('suhurekomendasi')); ?>:</b>
	<?php echo CHtml::encode($data->suhurekomendasi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahanlinen_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->bahanlinen_aktif); ?>
	<br>

</div>