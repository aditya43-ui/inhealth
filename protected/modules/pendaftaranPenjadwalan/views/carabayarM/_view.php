<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('carabayar_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->carabayar_id),array('view','id'=>$data->carabayar_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('carabayar_nama')); ?>:</b>
	<?php echo CHtml::encode($data->carabayar_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('carabayar_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->carabayar_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('metode_pembayaran')); ?>:</b>
	<?php echo CHtml::encode($data->metode_pembayaran); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('carabayar_loket')); ?>:</b>
	<?php echo CHtml::encode($data->carabayar_loket); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('carabayar_singkatan')); ?>:</b>
	<?php echo CHtml::encode($data->carabayar_singkatan); ?>
	<br>
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('carabayar_aktif')); ?>:</b>
	<?php echo CHtml::encode(($data->carabayar_aktif)?Yii::t('mds', 'Yes'):Yii::t('mds', 'No')); ?>
	<br>
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('carabayar_nourut')); ?>:</b>
	<?php echo CHtml::encode($data->carabayar_nourut); ?>
	<br>

	*/ ?>

</div>