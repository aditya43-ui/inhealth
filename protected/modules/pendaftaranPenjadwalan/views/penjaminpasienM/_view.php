<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('penjamin_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->penjamin_id),array('view','id'=>$data->penjamin_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('carabayar_id')); ?>:</b>
	<?php echo CHtml::encode($data->carabayar->carabayar_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('penjamin_nama')); ?>:</b>
	<?php echo CHtml::encode($data->penjamin_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('penjamin_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->penjamin_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('penjamin_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->penjamin_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No'))); ?>
	<br>

</div>