<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('bank_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->bank_id),array('view','id'=>$data->bank_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('propinsi_id')); ?>:</b>
	<?php echo CHtml::encode($data->propinsi_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('matauang_id')); ?>:</b>
	<?php echo CHtml::encode($data->matauang_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kabupaten_id')); ?>:</b>
	<?php echo CHtml::encode($data->kabupaten_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('namabank')); ?>:</b>
	<?php echo CHtml::encode($data->namabank); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('norekening')); ?>:</b>
	<?php echo CHtml::encode($data->norekening); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('alamatbank')); ?>:</b>
	<?php echo CHtml::encode($data->alamatbank); ?>
	<br>

</div>