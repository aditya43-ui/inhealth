<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispenerimaan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenispenerimaan_id),array('view','id'=>$data->jenispenerimaan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispenerimaan_kode')); ?>:</b>
	<?php echo CHtml::encode($data->jenispenerimaan_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispenerimaan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenispenerimaan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispenerimaan_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->jenispenerimaan_namalain); ?>
	<br>
        
	<b><?php //echo CHtml::encode($data->getAttributeLabel('rekeningdebit_id')); ?>:</b>
	<?php //echo CHtml::encode($data->rekeningdebit_id); ?>
	<br>
        
	<b><?php //echo CHtml::encode($data->getAttributeLabel('rekeningkredit_id')); ?>:</b>
	<?php //echo CHtml::encode($data->rekeningkredit_id); ?>
	<br>

</div>