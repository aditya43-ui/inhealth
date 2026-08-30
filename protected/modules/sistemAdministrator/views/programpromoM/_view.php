<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('programpromo_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->programpromo_id),array('view','id'=>$data->programpromo_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('namaprogrampromo')); ?>:</b>
	<?php echo CHtml::encode($data->namaprogrampromo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->namalainnya); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deskripsi')); ?>:</b>
	<?php echo CHtml::encode($data->deskripsi); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('keterangan')); ?>:</b>
	<?php echo CHtml::encode($data->keterangan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('programpromo_aktif')); ?>:</b>
	<?php $programpromo_aktif =(CHtml::encode($data->programpromo_aktif == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No'); echo $programpromo_aktif;?>
	<br />


</div>