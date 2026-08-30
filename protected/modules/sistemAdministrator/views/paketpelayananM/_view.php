<div class="view">
	<b><?php echo CHtml::encode($data->getAttributeLabel('paketpelayanan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->paketpelayanan_id),array('view','id'=>$data->paketpelayanan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_id')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipepaket_id')); ?>:</b>
	<?php echo CHtml::encode($data->tipepaket_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_id')); ?>:</b>
	<?php echo CHtml::encode($data->ruangan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('namatindakan')); ?>:</b>
	<?php echo CHtml::encode($data->namatindakan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subsidiasuransi')); ?>:</b>
	<?php echo CHtml::encode($data->subsidiasuransi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subsidipemerintah')); ?>:</b>
	<?php echo CHtml::encode($data->subsidipemerintah); ?>
	<br>
</div>