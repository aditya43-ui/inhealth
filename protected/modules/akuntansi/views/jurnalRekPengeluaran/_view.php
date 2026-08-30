<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispengeluaran_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenispengeluaran_id),array('view','id'=>$data->jenispengeluaran_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispengeluaran_kode')); ?>:</b>
	<?php echo CHtml::encode($data->jenispengeluaran_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispengeluaran_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenispengeluaran_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispengeluaran_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->jenispengeluaran_namalain); ?>
	<br>
        
	<b><?php //echo CHtml::encode($data->getAttributeLabel('rekeningdebit_id')); ?>:</b>
	<?php //echo CHtml::encode($data->rekeningdebit_id); ?>
	<br>
        
	<b><?php //echo CHtml::encode($data->getAttributeLabel('rekeningkredit_id')); ?>:</b>
	<?php //echo CHtml::encode($data->rekeningkredit_id); ?>
	<br>

</div>