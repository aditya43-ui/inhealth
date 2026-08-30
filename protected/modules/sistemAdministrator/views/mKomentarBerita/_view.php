<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('mberitakomentar_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->mberitakomentar_id),array('view','id'=>$data->mberitakomentar_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('mberita_id')); ?>:</b>
	<?php echo CHtml::encode($data->mberita_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglkomentar')); ?>:</b>
	<?php echo CHtml::encode($data->tglkomentar); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('namakomentar')); ?>:</b>
	<?php echo CHtml::encode($data->namakomentar); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('emailkomentar')); ?>:</b>
	<?php echo CHtml::encode($data->emailkomentar); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('isikomentar')); ?>:</b>
	<?php echo CHtml::encode($data->isikomentar); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tampilkankomentar')); ?>:</b>
	<?php echo CHtml::encode($data->tampilkankomentar); ?>
	<br>

</div>