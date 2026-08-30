<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipepaket_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->tipepaket_id),array('view','id'=>$data->tipepaket_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelaspelayanan_id')); ?>:</b>
	<?php echo CHtml::encode($data->kelaspelayanan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('penjamin_id')); ?>:</b>
	<?php echo CHtml::encode($data->penjamin_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('carabayar_id')); ?>:</b>
	<?php echo CHtml::encode($data->carabayar_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipepaket_nama')); ?>:</b>
	<?php echo CHtml::encode($data->tipepaket_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipepaket_singkatan')); ?>:</b>
	<?php echo CHtml::encode($data->tipepaket_singkatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipepaket_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->tipepaket_namalainnya); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('tglkesepakatantarif')); ?>:</b>
	<?php echo CHtml::encode($data->tglkesepakatantarif); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nokesepakatantarif')); ?>:</b>
	<?php echo CHtml::encode($data->nokesepakatantarif); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tarifpaket')); ?>:</b>
	<?php echo CHtml::encode($data->tarifpaket); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('paketsubsidiasuransi')); ?>:</b>
	<?php echo CHtml::encode($data->paketsubsidiasuransi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('paketsubsidipemerintah')); ?>:</b>
	<?php echo CHtml::encode($data->paketsubsidipemerintah); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('paketsubsidirs')); ?>:</b>
	<?php echo CHtml::encode($data->paketsubsidirs); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('paketiurbiaya')); ?>:</b>
	<?php echo CHtml::encode($data->paketiurbiaya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nourut_tipepaket')); ?>:</b>
	<?php echo CHtml::encode($data->nourut_tipepaket); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('keterangan_tipepaket')); ?>:</b>
	<?php echo CHtml::encode($data->keterangan_tipepaket); ?>
	<br>

	*/ 
        ?>
        <b><?php echo CHtml::encode($data->getAttributeLabel('tipepaket_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->tipepaket_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>
        

</div>