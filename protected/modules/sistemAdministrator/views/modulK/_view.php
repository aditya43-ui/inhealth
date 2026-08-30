<div class="view">

<!--	<b><?php //echo CHtml::encode($data->getAttributeLabel('icon_modul')); ?></b>-->
	<?php echo CHtml::image(Params::urlIconModulDirectory().$data->icon_modul); ?>
	<br>
        
	<b><?php echo CHtml::encode($data->getAttributeLabel('modul_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->modul_id),array('view','id'=>$data->modul_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('modul_kategori')); ?>:</b>
	<?php echo CHtml::encode($data->modul_kategori); ?>
        <br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokmodul_id')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokModul); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('modul_nama')); ?>:</b>
	<?php echo CHtml::encode($data->modul_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('modul_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->modul_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('modul_fungsi')); ?>:</b>
	<?php echo CHtml::encode($data->modul_fungsi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglrevisimodul')); ?>:</b>
	<?php echo CHtml::encode($data->tglrevisimodul); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglupdatemodul')); ?>:</b>
	<?php echo CHtml::encode($data->tglupdatemodul); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('url_modul')); ?>:</b>
	<?php echo CHtml::encode($data->url_modul); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('modul_key')); ?>:</b>
	<?php echo CHtml::encode($data->modul_key); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('modul_urutan')); ?>:</b>
	<?php echo CHtml::encode($data->modul_urutan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('modul_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->modul_aktif); ?>
	<br>

	*/ ?>

</div>