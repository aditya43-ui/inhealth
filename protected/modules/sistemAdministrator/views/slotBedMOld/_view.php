<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('slotbed_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->slotbed_id),array('view','id'=>$data->slotbed_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelaspelayanan_id')); ?>:</b>
	<?php echo CHtml::encode($data->kelaspelayanan->kelaspelayanan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_id')); ?>:</b>
	<?php echo CHtml::encode($data->ruangan->ruangan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('slotbed_noslot')); ?>:</b>
	<?php echo CHtml::encode($data->slotbed_noslot); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('slotbed_jmlbed')); ?>:</b>
	<?php echo CHtml::encode($data->slotbed_jmlbed); ?>
	<br>
        <b><?php echo CHtml::encode($data->getAttributeLabel('slotbed_status')); ?>:</b>
	<?php echo CHtml::encode((($data->slotbed_status==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>

        <b><?php echo CHtml::encode($data->getAttributeLabel('slotbed_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->slotbed_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>
	
        <?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('slotbed_status')); ?>:</b>
	<?php echo CHtml::encode($data->slotbed_status); ?>
	<br>

	
	<b><?php echo CHtml::encode($data->getAttributeLabel('slotbed_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->slotbed_aktif); ?>
	<br>
        <b><?php echo CHtml::encode($data->getAttributeLabel('slotbed_nobed')); ?>:</b>
	<?php echo CHtml::encode($data->slotbed_nobed); ?>
	<br>
	*/ ?>

</div>