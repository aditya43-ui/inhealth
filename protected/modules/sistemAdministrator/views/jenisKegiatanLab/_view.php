<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskegiatanlab_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jeniskegiatanlab_id),array('view','id'=>$data->jeniskegiatanlab_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskegiatanlab_kode')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskegiatanlab_kode); ?>
	<br>
	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskegiatanlab1')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskegiatanlab1); ?>
	<br>
	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskegiatanlab2')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskegiatanlab2); ?>
	<br>
	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskegiatanlab3')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskegiatanlab3); ?>
	<br>
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskegiatanlab_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskegiatanlab_aktif); ?>
	<br>

	*/ ?>

</div>