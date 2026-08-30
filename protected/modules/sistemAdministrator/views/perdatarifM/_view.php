<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('perdatarif_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->perdatarif_id),array('view','id'=>$data->perdatarif_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('perdanama_sk')); ?>:</b>
	<?php echo CHtml::encode($data->perdanama_sk); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('noperda')); ?>:</b>
	<?php echo CHtml::encode($data->noperda); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglperda')); ?>:</b>
	<?php echo CHtml::encode($data->tglperda); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('perdatentang')); ?>:</b>
	<?php echo CHtml::encode($data->perdatentang); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ditetapkanoleh')); ?>:</b>
	<?php echo CHtml::encode($data->ditetapkanoleh); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tempatditetapkan')); ?>:</b>
	<?php echo CHtml::encode($data->tempatditetapkan); ?>
	<br>

	
	<b><?php echo CHtml::encode($data->getAttributeLabel('perda_aktif')); ?>:</b>
	<?php $perda_aktif =(CHtml::encode($data->perda_aktif == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No'); echo $perda_aktif;?>
	<br>

	

</div>