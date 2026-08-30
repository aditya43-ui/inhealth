<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kamarruangan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kamarruangan_id),array('view','id'=>$data->kamarruangan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelaspelayanan_id')); ?>:</b>
	<?php echo CHtml::encode($data->kelaspelayanan->kelaspelayanan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_id')); ?>:</b>
	<?php echo CHtml::encode($data->ruangan->ruangan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kamarruangan_nokamar')); ?>:</b>
	<?php echo CHtml::encode($data->kamarruangan_nokamar); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kamarruangan_jmlbed')); ?>:</b>
	<?php echo CHtml::encode($data->kamarruangan_jmlbed); ?>
	<br>
        <b><?php echo CHtml::encode($data->getAttributeLabel('kamarruangan_status')); ?>:</b>
	<?php echo CHtml::encode((($data->kamarruangan_status==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>

        <b><?php echo CHtml::encode($data->getAttributeLabel('kamarruangan_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->kamarruangan_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>
	
        <?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('kamarruangan_status')); ?>:</b>
	<?php echo CHtml::encode($data->kamarruangan_status); ?>
	<br>

	
	<b><?php echo CHtml::encode($data->getAttributeLabel('kamarruangan_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->kamarruangan_aktif); ?>
	<br>
        <b><?php echo CHtml::encode($data->getAttributeLabel('kamarruangan_nobed')); ?>:</b>
	<?php echo CHtml::encode($data->kamarruangan_nobed); ?>
	<br>
	*/ ?>

</div>