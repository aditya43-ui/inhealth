<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('konfigfarmasi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->konfigfarmasi_id),array('view','id'=>$data->konfigfarmasi_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglberlaku')); ?>:</b>
	<?php echo CHtml::encode($data->tglberlaku); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('persenppn')); ?>:</b>
	<?php echo CHtml::encode($data->persenppn); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('persenpph')); ?>:</b>
	<?php echo CHtml::encode($data->persenpph); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('persehargajual')); ?>:</b>
	<?php echo CHtml::encode($data->persehargajual); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('totalpersenhargajual')); ?>:</b>
	<?php echo CHtml::encode($data->totalpersenhargajual); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bayarlangsung')); ?>:</b>
	<?php echo CHtml::encode($data->bayarlangsung); ?>
	<br>

</div>