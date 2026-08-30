<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kategoripengaduan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kategoripengaduan_id),array('view','id'=>$data->kategoripengaduan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('namakategori')); ?>:</b>
	<?php echo CHtml::encode($data->namakategori); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('warnakategoripengaduan')); ?>:</b>
	<?php echo CHtml::encode($data->warnakategoripengaduan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('estimasipenyelesaian')); ?>:</b>
	<?php echo CHtml::encode($data->estimasipenyelesaian); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kategoripengaduan_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->kategoripengaduan_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>

</div>