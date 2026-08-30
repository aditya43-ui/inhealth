<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kolomrating_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kolomrating_id),array('view','id'=>$data->kolomrating_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kolomrating_namalevel')); ?>:</b>
	<?php echo CHtml::encode($data->kolomrating_namalevel); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kolomrating_point')); ?>:</b>
	<?php echo CHtml::encode($data->kolomrating_point); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kolomrating_uraian')); ?>:</b>
	<?php echo CHtml::encode($data->kolomrating_uraian); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kolomrating_deskripsi')); ?>:</b>
	<?php echo CHtml::encode($data->kolomrating_deskripsi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kolomrating_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->kolomrating_aktif); ?>
	<br>

</div>