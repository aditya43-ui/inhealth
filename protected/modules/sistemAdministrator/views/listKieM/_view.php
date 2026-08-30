<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('listkie_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->listkie_id),array('view','id'=>$data->listkie_id)); ?>
	<br />
		<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskie')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskie); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('listkie_nama')); ?>:</b>
	<?php echo CHtml::encode($data->listkie_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('listkie_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->listkie_namalain); ?>
	<br />



	<b><?php echo CHtml::encode($data->getAttributeLabel('listkie_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->listkie_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br />


</div>