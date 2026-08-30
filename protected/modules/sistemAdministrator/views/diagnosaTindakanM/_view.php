<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosatindakan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->diagnosatindakan_id),array('view','id'=>$data->diagnosatindakan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosatindakan_kode')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosatindakan_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosatindakan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosatindakan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosatindakan_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosatindakan_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosatindakan_katakunci')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosatindakan_katakunci); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosatindakan_nourut')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosatindakan_nourut); ?>
	<br>
        <b><?php echo CHtml::encode($data->getAttributeLabel('diagnosatindakan_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->diagnosatindakan_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>


</div>