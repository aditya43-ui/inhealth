<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('peranpengguna_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->peranpengguna_id),array('view','id'=>$data->peranpengguna_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('peranpenggunanama')); ?>:</b>
	<?php echo CHtml::encode($data->peranpenggunanama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('peranpenggunanamalain')); ?>:</b>
	<?php echo CHtml::encode($data->peranpenggunanamalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('peranpengguna_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->peranpengguna_aktif); ?>
	<br>

</div>