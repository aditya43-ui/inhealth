<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('metodeapgar_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->metodeapgar_id),array('view','id'=>$data->metodeapgar_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('akronim')); ?>:</b>
	<?php echo CHtml::encode($data->akronim); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kriteria')); ?>:</b>
	<?php echo CHtml::encode($data->kriteria); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilai_2')); ?>:</b>
	<?php echo CHtml::encode($data->nilai_2); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilai_1')); ?>:</b>
	<?php echo CHtml::encode($data->nilai_1); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilai_0')); ?>:</b>
	<?php echo CHtml::encode($data->nilai_0); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('metodeapgar_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->metodeapgar_aktif); ?>
	<br>

</div>