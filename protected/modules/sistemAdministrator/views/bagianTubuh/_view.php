<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('bagiantubuh_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->bagiantubuh_id),array('view','id'=>$data->bagiantubuh_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('namabagtubuh')); ?>:</b>
	<?php echo CHtml::encode($data->namabagtubuh); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bagtubuh_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->bagtubuh_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kordinat_x')); ?>:</b>
	<?php echo CHtml::encode($data->kordinat_x); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kordinat_y')); ?>:</b>
	<?php echo CHtml::encode($data->kordinat_y); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bagiantubuh_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->bagiantubuh_aktif); ?>
	<br>

</div>