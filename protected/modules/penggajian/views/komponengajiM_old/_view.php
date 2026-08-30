<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponengaji_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->komponengaji_id),array('view','id'=>$data->komponengaji_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nourutgaji')); ?>:</b>
	<?php echo CHtml::encode($data->nourutgaji); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponengaji_kode')); ?>:</b>
	<?php echo CHtml::encode($data->komponengaji_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponengaji_nama')); ?>:</b>
	<?php echo CHtml::encode($data->komponengaji_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponengaji_singkt')); ?>:</b>
	<?php echo CHtml::encode($data->komponengaji_singkt); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ispotongan')); ?>:</b>
	<?php echo CHtml::encode($data->ispotongan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponengaji_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->komponengaji_aktif); ?>
	<br>

</div>