<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('indikatorperilaku_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->indikatorperilaku_id),array('view','id'=>$data->indikatorperilaku_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kompetensi_id')); ?>:</b>
	<?php echo CHtml::encode($data->kompetensi_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispenilaian_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenispenilaian_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('indikatorperilaku_nama')); ?>:</b>
	<?php echo CHtml::encode($data->indikatorperilaku_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('indikatorperilaku_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->indikatorperilaku_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('indikatorperilaku_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->indikatorperilaku_aktif); ?>
	<br>

</div>