<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pbf_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pbf_id),array('view','id'=>$data->pbf_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pbf_kode')); ?>:</b>
	<?php echo CHtml::encode($data->pbf_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pbf_nama')); ?>:</b>
	<?php echo CHtml::encode($data->pbf_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pbf_singkatan')); ?>:</b>
	<?php echo CHtml::encode($data->pbf_singkatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pbf_alamat')); ?>:</b>
	<?php echo CHtml::encode($data->pbf_alamat); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pbf_propinsi')); ?>:</b>
	<?php echo CHtml::encode($data->pbf_propinsi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pbf_kabupaten')); ?>:</b>
	<?php echo CHtml::encode($data->pbf_kabupaten); ?>
	<br>
        
          <b><?php echo CHtml::encode($data->getAttributeLabel('pbf_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->pbf_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>

</div>