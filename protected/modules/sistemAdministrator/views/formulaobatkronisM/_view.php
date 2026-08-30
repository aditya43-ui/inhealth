<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('formulaobatkronis_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->formulaobatkronis_id),array('view','id'=>$data->formulaobatkronis_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jumlahobat')); ?>:</b>
	<?php echo CHtml::encode($data->jumlahobat); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jumlahobat_minimal')); ?>:</b>
	<?php echo CHtml::encode($data->jumlahobat_minimal); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jumlahobat_maksimal')); ?>:</b>
	<?php echo CHtml::encode($data->jumlahobat_maksimal); ?>
	<br>
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('pabrik_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->pabrik_aktif); ?>
	<br>

	*/ ?>

</div>