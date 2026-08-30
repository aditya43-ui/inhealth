<?php
/**
 * digunakan untuk modul portal rs post berita
 * RSST-2443
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 *
 */
?>
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('penilaianuraian_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->penilaianuraian_id),array('view','id'=>$data->penilaianuraian_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('penilaianaspek_id')); ?>:</b>
	<?php echo CHtml::encode($data->penilaianaspek_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('penilaianuraian_nama')); ?>:</b>
	<?php echo CHtml::encode($data->penilaianuraian_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('penilaianuraian_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->penilaianuraian_namalain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('penilaianuraian_kode')); ?>:</b>
	<?php echo CHtml::encode($data->penilaianuraian_kode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('penilaianuraian_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->penilaianuraian_aktif); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_loginpemakai_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_loginpemakai_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_ruangan')); ?>:</b>
	<?php echo CHtml::encode($data->create_ruangan); ?>
	<br />

	*/ ?>

</div>