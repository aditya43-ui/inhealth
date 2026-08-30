<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('generik_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->generik_id),array('view','id'=>$data->generik_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('generik_nama')); ?>:</b>
	<?php echo CHtml::encode($data->generik_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('generik_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->generik_namalain); ?>
	<br>
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('generik_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->generik_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>


</div>