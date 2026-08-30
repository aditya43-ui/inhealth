<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
$total_col = 14;
echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judulLaporan, 'periode'=>$periode, 'colspan'=>$total_col));  

$prov = $model->searchInfoTable();
$prov->pagination = false;

$j = JabatanM::model()->findByPk(Params::JABATAN_ID_KASI_PERSONALIA);

$jabAkses = array(
    'jabatan_id' => Yii::app()->user->getState('jabatan_id'),
    'jabatan_nama' => (!empty($j))?$j->jabatan_nama:null,
);

?>                                        
                               <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                                   'id'=>'kppresensi-t-grid',
                                   'dataProvider'=>$prov,
                                   'template'=>"{items}",
                                   'itemsCssClass'=>'table table-bordered table-striped table-condensed',
                                   'columns'=>array(
										array(
										   'header' => 'No.',
										   'value' => '$row+1'
										),
										array(
											'header' => 'No. FP',    
											'name' => 'no_fingerprint'
										),
									   array(
										   'header' => 'Kelompok Pegawai/<br> Jabatan',
										   'type' => 'raw',
										   'value' => function($data){
												return $data["kelompokpegawai_nama"].'/<br>'.$data["jabatan_nama"];
										   }
									   ),
										array(
											'header' => 'NIP',    
											'name' => 'nomorindukpegawai'
										),
										array(
											'header' => 'Nama Pegawai',    
											'name' => 'nama_pegawai'
										),
										array(
											'header' => 'Shift Kerja',
											'type' => 'raw',
											'value' => function($data){
												if (!empty($data['shift_id'])){
													return $data['shift_nama'].'/<br>'.$data['shift_jamawal'].'-'.$data['shift_jamakhir'];
												}
											}
										),
										array(
											'header' => 'Tgl. Presensi',
											'value' => function($data){
												return MyFormatter::formatDateTimeForUser($data['tglpresensi']);
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
													if (!empty($data['terlambat_mnt']) || $data['terlambat_mnt'] > 0){
														return $data['terlambat_mnt'].'m';
													}
											},
											'htmlOptions' => array('style'=>'text-align:right;')
										),
										array(
											'header' => 'Pulang Awal',
											'value' => function($data){
												if (!empty($data['pulangawal_mnt']) || $data['pulangawal_mnt'] > 0){
													return $data['pulangawal_mnt'].'m';
												}
												/*if ($data['verifikasi'] != true){
													if (!empty($data['shift_id'] && !empty($data['jamscan_pulang']))){
														if ($data['shift_jamawal'] < $data['shift_jamakhir']){
															if ($data['verifikasi'] != true){
																$shiftakhir = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['shift_jamakhir']);
																$scantakhir = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamscan_pulang']);
															}else{
																$shiftakhir = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamkerjapulang']);
																$scantakhir = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamscan_pulang']);
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
												}*/
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
                                                    
													if (empty($data['jamscan_masuk']) || empty($data['jamscan_pulang'])){
                                                        return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_ALPHA, true, $data);
													}
													
                                                    return Params::getWarnaKehadiran($data['statuskehadiran_nama'], true, $data);		
													// return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_ALPHA, $data['verifikasi'],$data);																										
												}else{
													return  Params::getWarnaKehadiran($data['statuskehadiran_nama'], true, $data);														
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
															if ($data['tglpresensi'].' '.$data['shift_jamakhir'] <= date('Y-m-d H:i:s')){
																$pesan .= ' jam pulang ';
															}
														}else{
															if ($data['tglpresensi'].' '.$data['shift_jamakhir'] <= date('Y-m-d H:i:s')){
																$pesan .= ' dan jam pulang ';
															}
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
                           