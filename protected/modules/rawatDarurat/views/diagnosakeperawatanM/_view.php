<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosakeperawatan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->diagnosakeperawatan_id),array('view','id'=>$data->diagnosakeperawatan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosa_id')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosa_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosakeperawatan_kode')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosakeperawatan_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosa_medis')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosa_medis); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosa_keperawatan')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosa_keperawatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosa_tujuan')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosa_tujuan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosa_keperawatan_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosa_keperawatan_aktif); ?>
	<br>
        
        

</div>