<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisobatalkes_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenisobatalkes_id),array('view','id'=>$data->jenisobatalkes_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisobatalkes_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenisobatalkes_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisobatalkes_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->jenisobatalkes_namalain); ?>
	<br>
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('jenisobatalkes_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->jenisobatalkes_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>


</div>