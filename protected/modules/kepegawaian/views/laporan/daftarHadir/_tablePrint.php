
<?php 
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
	$j = JabatanM::model()->findByPk(Params::JABATAN_ID_KASI_PERSONALIA);

	$jabAkses = array(
		'jabatan_id' => Yii::app()->user->getState('jabatan_id'),
		'jabatan_nama' => (!empty($j))?$j->jabatan_nama:null,
	);
?>
<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
if (isset($caraPrint)){	
	$template = "{items}";
	$sort = false;
	if ($caraPrint == "EXCEL"){
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}

} else{
	
}
?>
<table class=" ">
	<tr>
		<td width="50%">
			<table>
				<tr>
					<td>No. Finger</td>
					<td>:</td>
					<td><?php echo $modPegawai->nofingerprint; ?></td>
				</tr>
				<tr>
					<td>Kelompok Pegawai</td>
					<td>:</td>
					<td><?php echo isset($modPegawai->kelompokpegawai_id)?$modPegawai->kelompokpegawai->kelompokpegawai_nama:''; ?></td>
				</tr>
				<tr>
					<td>Jabatan</td>
					<td>:</td>
					<td><?php echo  isset($modPegawai->jabatan_id)?$modPegawai->jabatan->jabatan_nama:""; ?></td>
				</tr>
				<tr>
					<td>NIP</td>
					<td>:</td>
					<td><?php echo $modPegawai->nomorindukpegawai; ?></td>
				</tr>                    
				<tr>
					<td>Nama Pegawai</td>
					<td>:</td>
					<td><?php echo $modPegawai->nama_pegawai; ?></td>
				</tr>  
				<?php /*
				<tr>
					<td>Shift</td>
					<td>:</td>
					<td><?php echo ($modPegawai->shift_id)?$modPegawai->shift->shift_nama:'-'; ?></td>
				</tr>*/ ?>
			</table>
		</td>
		<td>
			&nbsp;
		</td>
		<td>
			&nbsp;
		</td>
		<td>
			&nbsp;
		</td>
		<td>
			<table>
				<tr>
					<td style = "text-align:right;">Hadir</td>
					<td>:</td>
					<td><?php  echo $modPegawai->hadir; ?></td>
				</tr>
				<tr>
					<td style = "text-align:right;">Izin</td>
					<td>:</td>
					<td><?php echo $modPegawai->izin; ?></td>
				</tr>
				<tr>
					<td style = "text-align:right;">Sakit</td>
					<td>:</td>
					<td><?php echo $modPegawai->sakit; ?></td>
				</tr>
				<tr>
					<td style = "text-align:right;">Dinas</td>
					<td>:</td>
					<td><?php echo $modPegawai->dinas; ?></td>
				</tr>
				<tr>
					<td style = "text-align:right;">Alpha</td>
					<td>:</td>
					<td><?php echo $modPegawai->alpha; ?></td>
				</tr>
                                <tr>
					<td style = "text-align:right;">Cuti</td>
					<td>:</td>
					<td><?php echo $modPegawai->cuti; ?></td>
				</tr>
				<!--<tr>
					<td style = "text-align:right;">Rerata Jam Masuk</td>
					<td>:</td>
					<td><?php //echo $modPegawai->rerata_jam_masuk; ?></td>
				</tr>
				<tr>
					<td style = "text-align:right;">Rerata Jam Pulang</td>
					<td>:</td>
					<td><?php //echo $modPegawai->rerata_jam_keluar; ?></td>
				</tr>-->
				<?php /*<tr>
					<td >Jumlah Absensi</td>
					<td>:</td>
					<td>
					<?php
						$count = count((array)$model->printDetailPresensi()->getData());
						echo $count;
					?>
					</td>
				</tr>*/ ?>
			</table>            
		</td>
	</tr>
</table>

<?php $this->widget($table,array(
		'id'=>'laporanpresensi-t-grid',
		'dataProvider'=>$model->searchInfoTablePrint(),
		'template'=>"{items}",
		'itemsCssClass'=>'table border',
		 'mergeHeaders'=>array(
			 array(
				 'name'=>'<p style="margin: 0; text-align: center;">Jam</p>',
				 'start'=>'3',
				 'end'=>'6',
			 ),
		 ),
		'columns'=>array(
			 array(
				'header' => 'No.',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			 ),			
			 array(
				 'header' => 'Tgl. Presensi',
				 'value' => function($data){
					 return MyFormatter::formatDateTimeForUser($data['tglpresensi']);
				 }
			 ), 
			 array(
				'header' => 'Shift Kerja',
				'type' => 'raw',
				'value' => function($data){
					if (!empty($data['shift_id'])){
						return $data['shift_nama'].'/ '.$data['shift_jamawal'].'-'.$data['shift_jamakhir'];
					}
				}
			),
			 array(
				 'header' => 'Masuk',
				 'value' => '$data["jamscan_masuk"]'
			 ),
			 array(
				 'header' => 'Keluar',
				 'value' => '$data["jamscan_keluar"]'
			 ),
			 array(
				 'header' => 'Datang',
				 'value' => '$data["jamscan_datang"]'
			 ),
			 array(
				 'header' => 'Pulang',
				 'value' => '$data["jamscan_pulang"]'
			 ),
			 array(
				 'header' => 'Terlambat',
				 'value' => function($data){
					 if ($data['verifikasi'] != true){
						 if (!empty($data['shift_id']) && !empty($data['jamscan_masuk'])){
							 if ($data['shift_jamawal'] < $data['shift_jamakhir']){
								if ($data['verifikasi'] != true){
									$shiftawal = date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['shift_jamawal'];
									$shiftawal = strtotime(date('Y-m-d H:i:s', strtotime($shiftawal.' '.Params::PRESENSI_AWAL_TERLAMBAT)));

									$scantawal = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamscan_masuk']);
								}else{
									//$shiftawal = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamkerjamasuk']);
									$shiftawal = date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamkerjamasuk'];
									$shiftawal = strtotime(date('Y-m-d H:i:s', strtotime($shiftawal.' '.Params::PRESENSI_AWAL_TERLAMBAT)));

									$scantawal = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamscan_masuk']);
								}

								 $jam = round(round(abs($shiftawal - $scantawal ) / 60,2));

								 if ($data['jamscan_masuk'] > $data['shift_jamawal']){
									 if ($jam > 0){															
										 return $jam.'m';																
									 }
								 }
							 }
						 }
					 }else{
						 return $data['terlambat_mnt'].'m';
					 }
				 },
				 'htmlOptions' => array('style'=>'text-align:right;')
			 ),
			 array(
				 'header' => 'Pulang Awal',
				 'value' => function($data){
					 if ($data['verifikasi'] != true){
						 if (!empty($data['shift_id'] && !empty($data['jamscan_pulang']))){
							 if ($data['shift_jamawal'] < $data['shift_jamakhir']){
								 if ($data['verifikasi'] != true){
									 $shiftakhir = strtotime(date('Y-m-d').' '.$data['shift_jamakhir']);
									 $scantakhir = strtotime(date('Y-m-d').' '.$data['jamscan_pulang']);
								 }else{
									 $shiftakhir = strtotime(date('Y-m-d').' '.$data['jamkerjapulang']);
									 $scantakhir = strtotime(date('Y-m-d').' '.$data['jamscan_pulang']);
								 }

								 $jam = round(round(abs($scantakhir - $shiftakhir) / 60,2));

								 if ($data['jamscan_pulang'] < $data['shift_jamakhir']){
									 if ($jam > 0){															
										 return $jam.'m';																																														
									 }
								 }
							 }
						 }
					 }else{
						 return $data['pulangawal_mnt'].'m';
					 }
				 },
				 'htmlOptions' => array('style'=>'text-align:right;')
			 ),
			 array(
				 'header' => 'Status Kehadiran',
				 'type' => 'raw',
				 'value' => function($data) use ($jabAkses){		
					 $data['jabatanuser_id'] = $jabAkses['jabatan_id'];
					 $data['jabatanuser_nama'] = $jabAkses['jabatan_nama'];

					 if ($data['verifikasi'] != true){													
						 if (!empty($data['jamscan_masuk'])){
							if (!empty($data['shift_id'])){
								if ($data['verifikasi'] == true){
									$jamkerja = date("H:i:s",strtotime($data['jamkerjamasuk'].' +1 hours'));
								}else{
									$jamkerja = date("H:i:s",strtotime($data['shift_jamawal'].' +1 hours'));
								}

								if ($data['jamscan_masuk'] < $jamkerja){
									return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_HADIR, true,$data);
								}		

								//var_dump($data['jamscan_masuk']);
								//var_dump($jamkerja);

								if ($data['jamscan_masuk'] > $jamkerja){
									return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_ALPHA, true,$data);
								}
							}else{
								return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_HADIR,true,$data);
							}
						 }

						 if (!empty($data['jamscan_pulang'])){																											
							 return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_ALPHA,true,$data);														
						 }

						 return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_ALPHA, true,$data);																										
					 }else{
						 return  Params::getWarnaKehadiran($data['statuskehadiran_nama'], true,$data);														
					 }

				 },
			 ),	
			 array(
				 'header' => 'Keterangan',
				 'type' => 'raw',
				 'value' => function($data){
					 if ($data['keterangan'] != ''){
						 return $data['keterangan'];
					 }

					 if (!empty($data['shift_id'])){	
						 $pesan = 'Tidak ada';
						 if (empty($data['jamscan_masuk'])){
							 $pesan .= ' jam masuk ';
						 }

						 if (empty($data['jamscan_pulang'])){
							 if ($pesan == 'Tidak ada'){
								 $pesan .= ' jam pulang ';
							 }else{
								 $pesan .= ' dan jam pulang ';
							 }
						 }

						 if ($pesan != 'Tidak ada'){
							 return "<span style='color:#aa0808'>".$pesan."</span>";
						 }
					 }else{
						 return "<span style='color:#aa0808'>Shift belum di set</span>";
					 }
				 }
			 ),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	)); ?>