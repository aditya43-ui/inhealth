<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('obatalkesdetail_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->obatalkesdetail_id),array('view','id'=>$data->obatalkesdetail_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('obatalkes_id')); ?>:</b>
	<?php echo CHtml::encode($data->obatalkes_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('indikasi')); ?>:</b>
	<?php echo CHtml::encode($data->indikasi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kontraindikasi')); ?>:</b>
	<?php echo CHtml::encode($data->kontraindikasi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('komposisi')); ?>:</b>
	<?php echo CHtml::encode($data->komposisi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('efeksamping')); ?>:</b>
	<?php echo CHtml::encode($data->efeksamping); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('interaksiobat')); ?>:</b>
	<?php echo CHtml::encode($data->interaksiobat); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('carapenyimpanan')); ?>:</b>
	<?php echo CHtml::encode($data->carapenyimpanan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('peringatan')); ?>:</b>
	<?php echo CHtml::encode($data->peringatan); ?>
	<br>

	*/ ?>

</div>