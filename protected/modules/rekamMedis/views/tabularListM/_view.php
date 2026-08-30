<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('tabularlist_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->tabularlist_id),array('view','id'=>$data->tabularlist_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tabularlist_chapter')); ?>:</b>
	<?php echo CHtml::encode($data->tabularlist_chapter); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tabularlist_block')); ?>:</b>
	<?php echo CHtml::encode($data->tabularlist_block); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tabularlist_title')); ?>:</b>
	<?php echo CHtml::encode($data->tabularlist_title); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tabularlist_revisi')); ?>:</b>
	<?php echo CHtml::encode($data->tabularlist_revisi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tabularlist_versi')); ?>:</b>
	<?php echo CHtml::encode($data->tabularlist_versi); ?>
	<br>
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('tabularlist_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->tabularlist_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>


</div>