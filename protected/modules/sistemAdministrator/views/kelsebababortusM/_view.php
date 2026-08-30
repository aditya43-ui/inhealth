<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelsebababortus_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kelsebababortus_id),array('view','id'=>$data->kelsebababortus_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelsebababortus_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kelsebababortus_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelsebababortus_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->kelsebababortus_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelsebababortus_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->kelsebababortus_aktif); ?>
	<br>

</div>