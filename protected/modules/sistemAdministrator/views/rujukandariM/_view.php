<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('rujukandari_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->rujukandari_id),array('view','id'=>$data->rujukandari_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('asalrujukan_id')); ?>:</b>
	<?php echo CHtml::encode($data->asalrujukan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('namaperujuk')); ?>:</b>
	<?php echo CHtml::encode($data->namaperujuk); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('spesialis')); ?>:</b>
	<?php echo CHtml::encode($data->spesialis); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('alamatlengkap')); ?>:</b>
	<?php echo CHtml::encode($data->alamatlengkap); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('notelp')); ?>:</b>
	<?php echo CHtml::encode($data->notelp); ?>
	<br>

</div>