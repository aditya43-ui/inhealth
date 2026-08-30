<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('zatbahanmakan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->zatbahanmakan_id), array('view', 'id'=>$data->zatbahanmakan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('zatgizi_id')); ?>:</b>
	<?php echo CHtml::encode($data->zatgizi_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahanmakanan_id')); ?>:</b>
	<?php echo CHtml::encode($data->bahanmakanan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kandunganbahan')); ?>:</b>
	<?php echo CHtml::encode($data->kandunganbahan); ?>
	<br>

</div>