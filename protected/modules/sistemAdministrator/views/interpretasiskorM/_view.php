<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('interpretasiskor_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->interpretasiskor_id),array('view','id'=>$data->interpretasiskor_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('intepretasi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->intepretasi_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('interpretasijmlskor')); ?>:</b>
	<?php echo CHtml::encode($data->interpretasijmlskor); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('interpretasimin')); ?>:</b>
	<?php echo CHtml::encode($data->interpretasimin); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('interpretasimax')); ?>:</b>
	<?php echo CHtml::encode($data->interpretasimax); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('catatan')); ?>:</b>
	<?php echo CHtml::encode($data->catatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('interpretasiskor_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->interpretasiskor_aktif); ?>
	<br>

</div>