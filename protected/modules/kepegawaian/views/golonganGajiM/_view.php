<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('golongangaji_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->golongangaji_id),array('view','id'=>$data->golongangaji_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('masakerja')); ?>:</b>
	<?php echo CHtml::encode($data->masakerja); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jmlgaji')); ?>:</b>
	<?php echo CHtml::encode($data->jmlgaji); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisgolongan')); ?>:</b>
	<?php echo CHtml::encode($data->jenisgolongan); ?>
	<br>
        
    <b><?php echo CHtml::encode($data->getAttributeLabel('golongangaji_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->golongangaji_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>
</div>