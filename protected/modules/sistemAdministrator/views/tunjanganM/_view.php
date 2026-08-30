<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('tunjangan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->tunjangan_id),array('view','id'=>$data->tunjangan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pangkat_id')); ?>:</b>
	<?php echo CHtml::encode($data->pangkat_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jabatan_id')); ?>:</b>
	<?php echo CHtml::encode($data->jabatan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponengaji_id')); ?>:</b>
	<?php echo CHtml::encode($data->komponengaji_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nominaltunjangan')); ?>:</b>
	<?php echo CHtml::encode($data->nominaltunjangan); ?>
	<br>

</div>