<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('labklinikrujukan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->labklinikrujukan_id),array('view','id'=>$data->labklinikrujukan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('labklinikrujukan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->labklinikrujukan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('labklinikrujukan_alamat')); ?>:</b>
	<?php echo CHtml::encode($data->labklinikrujukan_alamat); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('labklinikrujukan_telp')); ?>:</b>
	<?php echo CHtml::encode($data->labklinikrujukan_telp); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('labklinikrujukan_mobile')); ?>:</b>
	<?php echo CHtml::encode($data->labklinikrujukan_mobile); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('labklinikrujukan_dokterpj')); ?>:</b>
	<?php echo CHtml::encode($data->labklinikrujukan_dokterpj); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('labklinikrujukan_aktif')); ?>:</b>
	<?php $labklinikrujukan_aktif =(CHtml::encode($data->labklinikrujukan_aktif == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No'); echo $labklinikrujukan_aktif;?>
	<br>

</div>