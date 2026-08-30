<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jadwalbukapoli_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jadwalbukapoli_id),array('view','id'=>$data->jadwalbukapoli_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_id')); ?>:</b>
	<?php echo CHtml::encode($data->ruangan->ruangan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('hari')); ?>:</b>
	<?php echo CHtml::encode($data->hari); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jmabuka')); ?>:</b>
	<?php echo CHtml::encode($data->jmabuka); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jammulai')); ?>:</b>
	<?php echo CHtml::encode($data->jammulai); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jamtutup')); ?>:</b>
	<?php echo CHtml::encode($data->jamtutup); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('maxantiranpoli')); ?>:</b>
	<?php echo CHtml::encode($data->maxantiranpoli); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_loginpemakai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_loginpemakai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_ruangan')); ?>:</b>
	<?php echo CHtml::encode($data->create_ruangan); ?>
	<br>

	*/ ?>

</div>