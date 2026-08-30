<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniswaktu_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jeniswaktu_id), array('view', 'id'=>$data->jeniswaktu_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniswaktu_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jeniswaktu_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniswaktu_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->jeniswaktu_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniswaktu_jam')); ?>:</b>
	<?php echo CHtml::encode($data->jeniswaktu_jam); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniswaktu_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jeniswaktu_aktif); ?>
	<br>

</div>