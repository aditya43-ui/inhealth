<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('penjamin_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->penjamin_id),array('view','id'=>$data->penjamin_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('carabayar_id')); ?>:</b>
	<?php echo CHtml::encode($data->carabayar->carabayar_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('penjamin_id')); ?>:</b>
	<?php echo CHtml::encode($data->penjamin_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rekeningdebit_id')); ?>:</b>
	<?php echo CHtml::encode($data->rekeningdebit->nmrekening5); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rekeningkredit_id')); ?>:</b>
	<?php echo CHtml::encode($data->rekeningkredit->nmrekening5); ?>
	<br>

</div>