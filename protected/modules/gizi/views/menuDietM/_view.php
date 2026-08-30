<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('menudiet_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->menudiet_id), array('view', 'id'=>$data->menudiet_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdiet_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenisdiet_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('menudiet_nama')); ?>:</b>
	<?php echo CHtml::encode($data->menudiet_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('menudiet_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->menudiet_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jml_porsi')); ?>:</b>
	<?php echo CHtml::encode($data->jml_porsi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ukuranrumahtangga')); ?>:</b>
	<?php echo CHtml::encode($data->ukuranrumahtangga); ?>
	<br>

</div>