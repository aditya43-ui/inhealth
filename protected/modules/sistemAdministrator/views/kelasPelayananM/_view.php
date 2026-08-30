<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelaspelayanan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kelaspelayanan_id),array('view','id'=>$data->kelaspelayanan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskelas_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskelas->jeniskelas_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelaspelayanan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kelaspelayanan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelaspelayanan_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->kelaspelayanan_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelaspelayanan_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->kelaspelayanan_aktif); ?>
	<br>
        
        <b><?php echo CHtml::encode('Ruangan','Ruangan'); ?>:</b>
	<?php echo $this->renderPartial('_ruangan',array('kelaspelayanan_id'=>$data->kelaspelayanan_id),true)?>

</div>