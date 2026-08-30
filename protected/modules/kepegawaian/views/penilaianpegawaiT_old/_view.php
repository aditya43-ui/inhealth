<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('penilaianpegawai_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->penilaianpegawai_id),array('view','id'=>$data->penilaianpegawai_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pegawai_id')); ?>:</b>
	<?php echo CHtml::encode($data->pegawai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglpenilaian')); ?>:</b>
	<?php echo CHtml::encode($data->tglpenilaian); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('periodepenilaian')); ?>:</b>
	<?php echo CHtml::encode($data->periodepenilaian); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('sampaidengan')); ?>:</b>
	<?php echo CHtml::encode($data->sampaidengan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kesetiaan')); ?>:</b>
	<?php echo CHtml::encode($data->kesetiaan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('prestasikerja')); ?>:</b>
	<?php echo CHtml::encode($data->prestasikerja); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('tanggungjawab')); ?>:</b>
	<?php echo CHtml::encode($data->tanggungjawab); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ketaatan')); ?>:</b>
	<?php echo CHtml::encode($data->ketaatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kejujuran')); ?>:</b>
	<?php echo CHtml::encode($data->kejujuran); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kerjasama')); ?>:</b>
	<?php echo CHtml::encode($data->kerjasama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('prakarsa')); ?>:</b>
	<?php echo CHtml::encode($data->prakarsa); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kepemimpinan')); ?>:</b>
	<?php echo CHtml::encode($data->kepemimpinan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jumlahpenilaian')); ?>:</b>
	<?php echo CHtml::encode($data->jumlahpenilaian); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilairatapenilaian')); ?>:</b>
	<?php echo CHtml::encode($data->nilairatapenilaian); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('performanceindex')); ?>:</b>
	<?php echo CHtml::encode($data->performanceindex); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('penilaianpegawai_keterangan')); ?>:</b>
	<?php echo CHtml::encode($data->penilaianpegawai_keterangan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('keberatanpegawai')); ?>:</b>
	<?php echo CHtml::encode($data->keberatanpegawai); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tanggal_keberatanpegawai')); ?>:</b>
	<?php echo CHtml::encode($data->tanggal_keberatanpegawai); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tanggapanpejabat')); ?>:</b>
	<?php echo CHtml::encode($data->tanggapanpejabat); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tanggal_tanggapanpejabat')); ?>:</b>
	<?php echo CHtml::encode($data->tanggal_tanggapanpejabat); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('keputusanatasan')); ?>:</b>
	<?php echo CHtml::encode($data->keputusanatasan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tanggal_keputusanatasan')); ?>:</b>
	<?php echo CHtml::encode($data->tanggal_keputusanatasan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lainlain')); ?>:</b>
	<?php echo CHtml::encode($data->lainlain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('dibuattanggalpejabat')); ?>:</b>
	<?php echo CHtml::encode($data->dibuattanggalpejabat); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diterimatanggalpegawai')); ?>:</b>
	<?php echo CHtml::encode($data->diterimatanggalpegawai); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diterimatanggalatasan')); ?>:</b>
	<?php echo CHtml::encode($data->diterimatanggalatasan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('penilainama')); ?>:</b>
	<?php echo CHtml::encode($data->penilainama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('penilainip')); ?>:</b>
	<?php echo CHtml::encode($data->penilainip); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('penilaipangkatgol')); ?>:</b>
	<?php echo CHtml::encode($data->penilaipangkatgol); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('penilaijabatan')); ?>:</b>
	<?php echo CHtml::encode($data->penilaijabatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('penilaiunitorganisasi')); ?>:</b>
	<?php echo CHtml::encode($data->penilaiunitorganisasi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pimpinannama')); ?>:</b>
	<?php echo CHtml::encode($data->pimpinannama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pimpinannip')); ?>:</b>
	<?php echo CHtml::encode($data->pimpinannip); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pimpinanpangkatgol')); ?>:</b>
	<?php echo CHtml::encode($data->pimpinanpangkatgol); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pimpinanjabatan')); ?>:</b>
	<?php echo CHtml::encode($data->pimpinanjabatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pimpinanunitorganisasi')); ?>:</b>
	<?php echo CHtml::encode($data->pimpinanunitorganisasi); ?>
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