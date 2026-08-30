<style>
	.spasi1 {
		margin: 0 0px 0px 10px;
	}

	.spasi2 {
		padding: 0 0px 0px 20px;
	}
</style>
<div class="white-container">
	<?php
	if ($caraPrint == 'EXCEL') {
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
		header('Cache-Control: max-age=0');
	}
	echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 7));
	$no_urut = 1;
	$class='';
	if (isset($_GET['frame'])) {
		$class="table table-striped";
	}
	?>
    <table width="100%" class="spasi1">
		<tr>
			<td width="20%">Nama</td>
			<td width="30%">: <?php echo $model->pasien->nama_pasien; ?></td>
			<td width="20%">No. Rekam Medis</td>
			<td width="30%">: <?php echo $model->pasien->no_rekam_medik; ?></td>
		</tr>
		<tr>
			<td width="20%">Umur</td>
			<td width="30%">: <?php echo $model->pendaftaran->umur; ?></td>
			<td width="20%">Ruang / Kelas</td>
			<td width="30%">: <?php echo $model->pendaftaran->ruangan->ruangan_nama. ' / ' . $model->pendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
		</tr>
		<tr>
			<td width="20%">Diagnosa Medis</td>
			<td width="30%">: <?php //echo $model->pendaftaran->diagnosa->diagnosa_nama; 
                            $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id));
                            
                            $diagnosa = PasienmorbiditasT::model()->findByAttributes(array('pasienadmisi_id'=>$admisi->pasienadmisi_id));
                            
                            if (!empty($diagnosa->diagnosa_id)){
                                echo $diagnosa->diagnosa->diagnosa_nama;
                            }
                        
                        ?></td>
			<td width="20%">Tgl. Masuk RS</td>
			<td width="30%">: <?php echo MyFormatter::formatDateTimeForUser($model->pendaftaran->tgl_pendaftaran); ?></td>

		</tr>
		<tr>
			<td width="20%">Dokter</td>
			<td width="30%">: <?php echo $model->pendaftaran->pegawai->namaLengkap; ?></td>
			<td width="20%">Tgl. keluar RS</td>
			<td width="30%">: <?php echo !empty($model->pendaftaran->pasienpulang_id) ? MyFormatter::formatDateTimeForUser($model->pendaftaran->pasienpulang->tglpasienpulang) : "  "; ?></td>
		</tr>
	</table>
	<hr>
	<br>
	<br>
	<?php echo '<b>1. Kondisi pasien saat masuk RS</b>'; ?>
	<table width="100%" class="spasi1">
		<tr>
			<td width="5%">
				a. 
			</td>
			<td width="95%">
				Keluhan : <?php echo $model->keluhanutamamasuk; ?>
			</td>
		</tr>
		<tr>
			<td width="5%">
				b. 
			</td>
			<td width="95%">
				Keadaan Umum
			</td>
		</tr>
		<tr>
			<td width="5%">

			</td>
			<td width="95%">
				Kesadaran : <?php echo $model->keadaanumummasuk . ' GCS:E ' . $model->gcs_eye . ' M ' . $model->gcs_motorik . ' V ' . $model->gcs_verbal . ' = ' . $model->gcs_hasil; ?>
			</td>
		</tr>
		<tr>
			<td width="5%">

			</td>
			<td width="95%">
				Tanda Vital : TD <?php echo $model->tekanandarahmasuk . ' N ' . $model->detaknadimasuk . ' S ' . $model->suhutubuhmasuk . ' R ' . $model->pernapasanmasuk; ?>
			</td>
		</tr>
	</table>
	<br>
	<br>
	<?php echo '<b>2. Kondisi pasien saat dirawat</b>'; ?>
	<table width="100%" class="spasi1">
		<tr>
			<td width="5%">
				a. 
			</td>
			<td width="95%">
				Diagnosa Keperawatan
			</td>
		</tr>
		<tr>
			<td width="5%">

			</td>
			<td width="95%">
				<?php echo $model->diagnosakeperawatan; ?>
			</td>
		</tr>
		<tr>
			<td width="5%">
				b. 
			</td>
			<td width="95%">
				Tindakan Keperawatan
			</td>
		</tr>
		<tr>
			<td width="5%">

			</td>
			<td width="95%">
				<?php echo $model->tindakankeperawatan; ?>
			</td>
		</tr>
	</table>
	<br>
	<br>
	<?php echo '<b>3. Kondisi pasien saat keluar RS</b>'; ?>
	<table style="width: 100%; border: none;">
		<tr>
			<td width="5%">
				a. 
			</td>
			<td width="95%">
				Keluhan Pasien : <?php echo $model->keluhanakhir; ?>
			</td>
		</tr>
		<tr>
			<td width="5%">
				b. 
			</td>
			<td width="95%">
				Keadaan Umum : 
			</td>
		</tr>
		<tr>
			<td width="5%">

			</td>
			<td width="95%">
				<?php echo $model->keadaanumumakhir; ?>
			</td>
		</tr>
		<tr>
			<td width="5%">

			</td>
			<td width="95%">
				Tanda Vital : TD <?php echo $model->tekanandarahakhir . ' N ' . $model->detaknadiakhir . ' S ' . $model->suhutubuhakhir . ' R ' . $model->pernapasanakhir; ?>
			</td>
		</tr>
	</table>
	<table style="width: 100%; border: none;">
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;"></th>
			<th style="width:50%; text-align:center; padding-top: 50px;" colspan="2"><?php echo $modProfile->kabupaten->kabupaten_nama . ' , ' . MyFormatter::formatDateTimeForUser(date("Y-m-d")); ?></th>
		</tr>
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;">

			</th>
			<th style="width:50%; text-align:center; padding-bottom: 50px;">
				Perawatan / Bidan
				<br><br><br><br><br><br>
				( <?php echo $model->namaperawat; ?> )
			</th>
		</tr>
	</table>