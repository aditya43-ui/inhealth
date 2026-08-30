<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('indikatorpenilaianiku_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->indikatorpenilaianiku_id),array('view','id'=>$data->indikatorpenilaianiku_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kompetensi_id')); ?>:</b>
	<?php echo CHtml::encode($data->kompetensi_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispenilaian_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenispenilaian_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('indikatorpenilaianiku_nama')); ?>:</b>
	<?php echo CHtml::encode($data->indikatorpenilaianiku_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('indikatorpenilaianiku_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->indikatorpenilaianiku_namalain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('indikatorpenilaianiku_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->indikatorpenilaianiku_aktif); ?>
	<br />


</div>