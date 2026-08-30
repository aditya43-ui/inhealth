<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ruangan_id),array('view','id'=>$data->ruangan_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instalasi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->instalasi->instalasi_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->ruangan_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->ruangan_namalainnya); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_lokasi')); ?>:</b>
	<?php echo CHtml::encode($data->ruangan_lokasi); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->ruangan_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br />
        
        <b><?php echo CHtml::encode('Kasus Penyakit','Kasus Penyakit'); ?>:</b>
	<?php echo $this->renderPartial('_kasusPenyakit',array('ruangan_id'=>$data->ruangan_id),true)?>
        <br />
        <b><?php echo CHtml::encode('Kelas','Kelas'); ?>:</b>
	<?php echo $this->renderPartial('_kelasPelayanan',array('ruangan_id'=>$data->ruangan_id),true)?>
	<br />
        <b><?php echo CHtml::encode('Daftar Tindakan','Daftar Tindakan'); ?>:</b>
	<?php echo $this->renderPartial('_daftarTindakan',array('ruangan_id'=>$data->ruangan_id),true)?>
	<br />
        <b><?php echo CHtml::encode('Pegawai','Pegawai'); ?>:</b>
	<?php echo $this->renderPartial('_ruanganPegawai',array('ruangan_id'=>$data->ruangan_id),true)?>
	<br />


</div>