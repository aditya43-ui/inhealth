<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pasien_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pasien_id),array('view','id'=>$data->pasien_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pekerjaan_id')); ?>:</b>
	<?php echo CHtml::encode($data->pekerjaan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelurahan_id')); ?>:</b>
	<?php echo CHtml::encode($data->kelurahan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pendidikan_id')); ?>:</b>
	<?php echo CHtml::encode($data->pendidikan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('propinsi_id')); ?>:</b>
	<?php echo CHtml::encode($data->propinsi_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kecamatan_id')); ?>:</b>
	<?php echo CHtml::encode($data->kecamatan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('suku_id')); ?>:</b>
	<?php echo CHtml::encode($data->suku_id); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('profilrs_id')); ?>:</b>
	<?php echo CHtml::encode($data->profilrs_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kabupaten_id')); ?>:</b>
	<?php echo CHtml::encode($data->kabupaten_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_rekam_medik')); ?>:</b>
	<?php echo CHtml::encode($data->no_rekam_medik); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tgl_rekam_medik')); ?>:</b>
	<?php echo CHtml::encode($data->tgl_rekam_medik); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisidentitas')); ?>:</b>
	<?php echo CHtml::encode($data->jenisidentitas); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_identitas_pasien')); ?>:</b>
	<?php echo CHtml::encode($data->no_identitas_pasien); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('namadepan')); ?>:</b>
	<?php echo CHtml::encode($data->namadepan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama_pasien')); ?>:</b>
	<?php echo CHtml::encode($data->nama_pasien); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama_bin')); ?>:</b>
	<?php echo CHtml::encode($data->nama_bin); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskelamin')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskelamin); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokumur')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokumur); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tempat_lahir')); ?>:</b>
	<?php echo CHtml::encode($data->tempat_lahir); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tanggal_lahir')); ?>:</b>
	<?php echo CHtml::encode($data->tanggal_lahir); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('alamat_pasien')); ?>:</b>
	<?php echo CHtml::encode($data->alamat_pasien); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rt')); ?>:</b>
	<?php echo CHtml::encode($data->rt); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rw')); ?>:</b>
	<?php echo CHtml::encode($data->rw); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('statusperkawinan')); ?>:</b>
	<?php echo CHtml::encode($data->statusperkawinan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('agama')); ?>:</b>
	<?php echo CHtml::encode($data->agama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('golongandarah')); ?>:</b>
	<?php echo CHtml::encode($data->golongandarah); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rhesus')); ?>:</b>
	<?php echo CHtml::encode($data->rhesus); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('anakke')); ?>:</b>
	<?php echo CHtml::encode($data->anakke); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jumlah_bersaudara')); ?>:</b>
	<?php echo CHtml::encode($data->jumlah_bersaudara); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_telepon_pasien')); ?>:</b>
	<?php echo CHtml::encode($data->no_telepon_pasien); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_mobile_pasien')); ?>:</b>
	<?php echo CHtml::encode($data->no_mobile_pasien); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('warga_negara')); ?>:</b>
	<?php echo CHtml::encode($data->warga_negara); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('photopasien')); ?>:</b>
	<?php echo CHtml::encode($data->photopasien); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('alamatemail')); ?>:</b>
	<?php echo CHtml::encode($data->alamatemail); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('statusrekammedis')); ?>:</b>
	<?php echo CHtml::encode($data->statusrekammedis); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('tgl_meninggal')); ?>:</b>
	<?php echo CHtml::encode($data->tgl_meninggal); ?>
	<br>

	*/ ?>

</div>