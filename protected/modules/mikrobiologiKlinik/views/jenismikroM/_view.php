<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('mikroorganisme_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->mikroorganisme_id),array('view','id'=>$data->mikroorganisme_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompok_mikroorganisme')); ?>:</b>
	<?php echo CHtml::encode($data->kelompok_mikroorganisme); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama_mikroorganisme')); ?>:</b>
	<?php echo CHtml::encode($data->nama_mikroorganisme); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('antibiotikmikro_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->mikroorganisme_aktif); ?>
	<br>

</div>