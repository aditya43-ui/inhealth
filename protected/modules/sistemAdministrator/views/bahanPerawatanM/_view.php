<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahanperawatan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->bahanperawatan_id),array('view','id'=>$data->bahanperawatan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahanperawatan_jenis')); ?>:</b>
	<?php echo CHtml::encode($data->bahanperawatan_jenis); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahanperawatan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->bahanperawatan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahanperawatan_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->bahanperawatan_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahanperawatan_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->bahanperawatan_aktif); ?>
	<br>

</div>