<div class="view">

                
	<b><?php echo CHtml::encode($data->getAttributeLabel('tariftindakan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->tariftindakan_id),array('view','id'=>$data->tariftindakan_id)); ?>
	<br />
        
                <b><?php echo CHtml::encode($data->getAttributeLabel('perdatarif_id')); ?>:</b>
	<?php echo CHtml::encode($data->perdatarif->perdanama_sk); ?>
	<br />
        
	<b><?php echo CHtml::encode($data->getAttributeLabel('jenistarif_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenistarif->jenistarif_nama); ?>
	<br />
        
                <b><?php echo CHtml::encode($data->getAttributeLabel('jenistarif_id')); ?>:</b>
	<?php echo CHtml::encode($data->kelaspelayanan->kelaspelayanan_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_id')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan->daftartindakan_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponentarif_id')); ?>:</b>
	<?php echo CHtml::encode($data->komponentarif->komponentarif_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('harga_tariftindakan')); ?>:</b>
	<?php echo CHtml::encode($data->harga_tariftindakan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('persendiskon_tind')); ?>:</b>
	<?php echo CHtml::encode($data->persendiskon_tind); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('hargadiskon_tind')); ?>:</b>
	<?php echo CHtml::encode($data->hargadiskon_tind); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('persencyto_tind')); ?>:</b>
	<?php echo CHtml::encode($data->persencyto_tind); ?>
	<br />

	*/ ?>

</div>