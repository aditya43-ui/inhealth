<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pangkat_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pangkat_id),array('view','id'=>$data->pangkat_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('golonganpegawai_id')); ?>:</b>
	<?php echo CHtml::encode($data->golonganpegawai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pangkat_nama')); ?>:</b>
	<?php echo CHtml::encode($data->pangkat_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pangkat_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->pangkat_namalainnya); ?>
	<br>
        
         <b><?php echo CHtml::encode($data->getAttributeLabel('pangkat_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->pangkat_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>
	<b><?php echo CHtml::encode($data->getAttributeLabel('')); ?>:</b>
</div>