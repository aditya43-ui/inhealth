<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('prestasikerja_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->prestasikerja_id),array('view','id'=>$data->prestasikerja_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pegawai_id')); ?>:</b>
	<?php echo CHtml::encode($data->pegawai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglprestasidiperoleh')); ?>:</b>
	<?php echo CHtml::encode($data->tglprestasidiperoleh); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nourutprestasi')); ?>:</b>
	<?php echo CHtml::encode($data->nourutprestasi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('instansipemberi')); ?>:</b>
	<?php echo CHtml::encode($data->instansipemberi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pejabatpemberi')); ?>:</b>
	<?php echo CHtml::encode($data->pejabatpemberi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('namapenghargaan')); ?>:</b>
	<?php echo CHtml::encode($data->namapenghargaan); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('keteranganprestasi')); ?>:</b>
	<?php echo CHtml::encode($data->keteranganprestasi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_loginpemakai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_loginpemakai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_ruangan')); ?>:</b>
	<?php echo CHtml::encode($data->create_ruangan); ?>
	<br>

	*/ ?>

</div>