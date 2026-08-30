<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('rujukankeluar_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->rujukankeluar_id),array('view','id'=>$data->rujukankeluar_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rumahsakitrujukan')); ?>:</b>
	<?php echo CHtml::encode($data->rumahsakitrujukan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alamatrsrujukan')); ?>:</b>
	<?php echo CHtml::encode($data->alamatrsrujukan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telp_fax')); ?>:</b>
	<?php echo CHtml::encode($data->telp_fax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rujukankeluar_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->rujukankeluar_aktif); ?>
	<br />


</div>