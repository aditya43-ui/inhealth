<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskasuspenyakit_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jeniskasuspenyakit_id),array('view','id'=>$data->jeniskasuspenyakit_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskasuspenyakit_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskasuspenyakit_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskasuspenyakit_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskasuspenyakit_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskasuspenyakit_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->jeniskasuspenyakit_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>
        
         <b><?php echo CHtml::encode('Ruangan','Ruangan'); ?>:</b>
	<?php echo $this->renderPartial($this->path_view.'_ruangan',array('jeniskasuspenyakit_id'=>$data->jeniskasuspenyakit_id),true)?>

</div>