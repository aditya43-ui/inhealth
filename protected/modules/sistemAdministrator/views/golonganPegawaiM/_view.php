<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('golonganpegawai_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->golonganpegawai_id),array('view','id'=>$data->golonganpegawai_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('golonganpegawai_nama')); ?>:</b>
	<?php echo CHtml::encode($data->golonganpegawai_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('golonganpegawai_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->golonganpegawai_namalainnya); ?>
	<br>
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('golonganpegawai_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->golonganpegawai_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>
</div>