<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelkumurhasillab_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kelkumurhasillab_id),array('view','id'=>$data->kelkumurhasillab_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelkumurhasillabnama')); ?>:</b>
	<?php echo CHtml::encode($data->kelkumurhasillabnama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('umurminlab')); ?>:</b>
	<?php echo CHtml::encode($data->umurminlab); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('umurmakslab')); ?>:</b>
	<?php echo CHtml::encode($data->umurmakslab); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('satuankelumur')); ?>:</b>
	<?php echo CHtml::encode($data->satuankelumur); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelkumurhasillab_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->kelkumurhasillab_aktif); ?>
	<br>

</div>