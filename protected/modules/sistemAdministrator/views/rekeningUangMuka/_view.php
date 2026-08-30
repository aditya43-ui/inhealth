<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('instalasi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->instalasi_id),array('view','id'=>$data->instalasi_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('instalasi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->instalasi->instalasi_nama); ?>
	<br>
        <b><?php echo CHtml::encode('Daftar Tindakan','Daftar Tindakan'); ?>:</b>
	<?php echo $this->renderPartial($this->path_view.'_daftarTindakan',array('instalasi_id'=>$data->instalasi_id),true)?>
	<br>

</div>