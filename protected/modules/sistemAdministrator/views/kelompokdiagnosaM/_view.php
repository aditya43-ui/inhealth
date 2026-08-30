<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokdiagnosa_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kelompokdiagnosa_id),array('view','id'=>$data->kelompokdiagnosa_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokdiagnosa_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokdiagnosa_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokdiagnosa_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokdiagnosa_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokdiagnosa_aktif')); ?>:</b>
	<?php $kelompokdiagnosa_aktif =(CHtml::encode($data->kelompokdiagnosa_aktif == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No'); echo $kelompokdiagnosa_aktif;?>
	<br>

</div>