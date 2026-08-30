<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ruangan_id),array('view','id'=>$data->ruangan_id)); ?>
	<br>	

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->ruangan_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_aktif')); ?>:</b>
	<?php echo CHtml::encode(($data->ruangan_aktif) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')); ?>
	<br>
        
        <b><?php echo CHtml::encode('Kelas Pelayanan','Kelas Pelayanan'); ?>:</b>
	<?php echo $this->renderPartial('_kelaspelayanan',array('ruangan_id'=>$data->ruangan_id),true)?>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_singkatan')); ?>:</b>
	<?php echo CHtml::encode($data->ruangan_singkatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('riwayatruangan_id')); ?>:</b>
	<?php echo CHtml::encode($data->riwayatruangan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_fasilitas')); ?>:</b>
	<?php echo CHtml::encode($data->ruangan_fasilitas); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_image')); ?>:</b>
	<?php echo CHtml::encode($data->ruangan_image); ?>
	<br>

	*/ ?>

</div>