<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('indexing_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->indexing_id), array('view', 'id'=>$data->indexing_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelrem_id')); ?>:</b>
	<?php echo CHtml::encode($data->kelrem_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('indexing_urutan')); ?>:</b>
	<?php echo CHtml::encode($data->indexing_urutan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('indexing_nama')); ?>:</b>
	<?php echo CHtml::encode($data->indexing_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('indexing_singk')); ?>:</b>
	<?php echo CHtml::encode($data->indexing_singk); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('indexing_nilai')); ?>:</b>
	<?php echo CHtml::encode($data->indexing_nilai); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('indexing_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->indexing_aktif); ?>
	<br>

</div>