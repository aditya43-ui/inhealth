<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('paketbmhp_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->paketbmhp_id),array('view','id'=>$data->paketbmhp_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_id')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipepaket_id')); ?>:</b>
	<?php echo CHtml::encode($data->tipepaket_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('satuankecil_id')); ?>:</b>
	<?php echo CHtml::encode($data->satuankecil_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('obatalkes_id')); ?>:</b>
	<?php echo CHtml::encode($data->obatalkes_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('qtypemakaian')); ?>:</b>
	<?php echo CHtml::encode($data->qtypemakaian); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('qtystokout')); ?>:</b>
	<?php echo CHtml::encode($data->qtystokout); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('hargapemakaian')); ?>:</b>
	<?php echo CHtml::encode($data->hargapemakaian); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokumur_id')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokumur_id); ?>
	<br>

	*/ ?>

</div>