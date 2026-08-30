<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenistransaksi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenistransaksi_id),array('view','id'=>$data->jenistransaksi_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenistransaksi_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenistransaksi_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('namatransaksi')); ?>:</b>
	<?php echo CHtml::encode($data->namatransaksi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('namatransaksilainnnya')); ?>:</b>
	<?php echo CHtml::encode($data->namatransaksilainnnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('akundebit')); ?>:</b>
	<?php echo CHtml::encode($data->akundebit); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('akunkredit')); ?>:</b>
	<?php echo CHtml::encode($data->akunkredit); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenistransaksi_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenistransaksi_aktif); ?>
	<br>

</div>