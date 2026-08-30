<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pegawai_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pegawai_id),array('view','id'=>$data->pegawai_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelurahan_id')); ?>:</b>
	<?php echo CHtml::encode($data->kelurahan_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kecamatan_id')); ?>:</b>
	<?php echo CHtml::encode($data->kecamatan_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('profilrs_id')); ?>:</b>
	<?php echo CHtml::encode($data->profilrs_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gelarbelakang_id')); ?>:</b>
	<?php echo CHtml::encode($data->gelarbelakang_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('suku_id')); ?>:</b>
	<?php echo CHtml::encode($data->suku_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokpegawai_id')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokpegawai_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('pendkualifikasi_id')); ?>:</b>
	<?php echo CHtml::encode($data->pendkualifikasi_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jabatan_id')); ?>:</b>
	<?php echo CHtml::encode($data->jabatan_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pendidikan_id')); ?>:</b>
	<?php echo CHtml::encode($data->pendidikan_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('propinsi_id')); ?>:</b>
	<?php echo CHtml::encode($data->propinsi_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pangkat_id')); ?>:</b>
	<?php echo CHtml::encode($data->pangkat_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kabupaten_id')); ?>:</b>
	<?php echo CHtml::encode($data->kabupaten_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nomorindukpegawai')); ?>:</b>
	<?php echo CHtml::encode($data->nomorindukpegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_kartupegawainegerisipil')); ?>:</b>
	<?php echo CHtml::encode($data->no_kartupegawainegerisipil); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_karis_karsu')); ?>:</b>
	<?php echo CHtml::encode($data->no_karis_karsu); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_taspen')); ?>:</b>
	<?php echo CHtml::encode($data->no_taspen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_askes')); ?>:</b>
	<?php echo CHtml::encode($data->no_askes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gelardepan')); ?>:</b>
	<?php echo CHtml::encode($data->gelardepan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama_pegawai')); ?>:</b>
	<?php echo CHtml::encode($data->nama_pegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama_keluarga')); ?>:</b>
	<?php echo CHtml::encode($data->nama_keluarga); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tempatlahir_pegawai')); ?>:</b>
	<?php echo CHtml::encode($data->tempatlahir_pegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tgl_lahirpegawai')); ?>:</b>
	<?php echo CHtml::encode($data->tgl_lahirpegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskelamin')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskelamin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('statusperkawinan')); ?>:</b>
	<?php echo CHtml::encode($data->statusperkawinan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alamat_pegawai')); ?>:</b>
	<?php echo CHtml::encode($data->alamat_pegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('agama')); ?>:</b>
	<?php echo CHtml::encode($data->agama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('golongandarah')); ?>:</b>
	<?php echo CHtml::encode($data->golongandarah); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rhesus')); ?>:</b>
	<?php echo CHtml::encode($data->rhesus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alamatemail')); ?>:</b>
	<?php echo CHtml::encode($data->alamatemail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notelp_pegawai')); ?>:</b>
	<?php echo CHtml::encode($data->notelp_pegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nomobile_pegawai')); ?>:</b>
	<?php echo CHtml::encode($data->nomobile_pegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('warganegara_pegawai')); ?>:</b>
	<?php echo CHtml::encode($data->warganegara_pegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniswaktukerja')); ?>:</b>
	<?php echo CHtml::encode($data->jeniswaktukerja); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokjabatan')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokjabatan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kategoripegawai')); ?>:</b>
	<?php echo CHtml::encode($data->kategoripegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kategoripegawaiasal')); ?>:</b>
	<?php echo CHtml::encode($data->kategoripegawaiasal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('photopegawai')); ?>:</b>
	<?php echo CHtml::encode($data->photopegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pegawai_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->pegawai_aktif); ?>
	<br />

	*/ ?>

</div>