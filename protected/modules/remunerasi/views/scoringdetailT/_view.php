<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('scoringdetail_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->scoringdetail_id), array('view', 'id'=>$data->scoringdetail_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelrem_id')); ?>:</b>
	<?php echo CHtml::encode($data->kelrem_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('personalscoring_id')); ?>:</b>
	<?php echo CHtml::encode($data->personalscoring_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('indexing_id')); ?>:</b>
	<?php echo CHtml::encode($data->indexing_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('index_personal')); ?>:</b>
	<?php echo CHtml::encode($data->index_personal); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ratebobot_personal')); ?>:</b>
	<?php echo CHtml::encode($data->ratebobot_personal); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('score_personal')); ?>:</b>
	<?php echo CHtml::encode($data->score_personal); ?>
	<br>

</div>