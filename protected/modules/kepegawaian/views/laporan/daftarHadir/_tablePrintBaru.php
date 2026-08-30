<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
		}
		
		
    } else{
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }

	$generate = new KPPresensiT();
	$generate->tglpresensi = MyFormatter::formatDateTimeForDb($model->tglpresensi);
	$generate->tglpresensi_akhir = MyFormatter::formatDateTimeForDb($model->tglpresensi_akhir);

	$get = $generate->generateTotalKehadiran();

	$totKehadiran = $get['totalkehadiran'];
	$minute = $get['menit'];
    
    $prov = $model->searchByNofinger();
	$prov->pagination = false;
            
$this->widget($table,array(
			'id'=>'lapegawai-m-grid',
			'dataProvider'=>$prov,
			'template'=>$template,
			'enableSorting'=>false,
			'itemsCssClass'=>'table border',
			 'mergeHeaders'=>array(
				array(
					'name'=>'<p style="margin: 0; text-align: center;">Status Kehadiran</p>',
					'start'=>'5',
					'end'=>'10',
				),
				  array(
					'name'=>'<p style="margin: 0; text-align: center;">Jam Kerja</p>',
					'start'=>'11',
					'end'=>'12',
				),
			),
			'columns'=>array(
				 array(
					 'header' => 'No. FP',
					 'value' => '$data->nofingerprint',
				 ),                    
				'kelompokpegawai.kelompokpegawai_nama',
				'jabatan.jabatan_nama',				
				'nomorindukpegawai',
				'nama_pegawai',  
				//'ruanganpegawai.ruangan.ruangan_nama',
			   // array(
				  //  'header' => 'Shift',
				  //  'name' => 'shift.shift_nama',
			   // ),                    
				 /*array(
					 'header' => 'Rerata Jam Masuk',                        
					 'value' => function ($data) use ($model){                            
						//return $this->renderPartial("daftarHadir/_rerataJamMasuk",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_MASUK,'tgl_awal'=>$model->tglpresensi,'tgl_akhir'=>$model->tglpresensi_akhir),true);
						return '-';
					 }
				 ),                  
				array(
					 'header' => 'Rerata Jam Pulang',
					 'value' => function ($data) use ($model){                            
						//return $this->renderPartial("daftarHadir/_rerataJamKeluar",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_PULANG,'tgl_awal'=>$model->tglpresensi,'tgl_akhir'=>$model->tglpresensi_akhir),true);
						return '-';
					 }

				 ),     */                                
				array(
					 'header' => 'Hadir',
					// 'value' => '$data->getTotalStatusKehadiran(1, $data->pegawai_id)',
					 'value' => function ($data) use ($totKehadiran){
						if (isset($totKehadiran[$data->pegawai_id])){													
							return $totKehadiran[$data->pegawai_id][Params::STATUSKEHADIRAN_HADIR];
						}else{
							return 0;
						}
						//return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_HADIR, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
						//return $data->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_HADIR, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
						//return '-';
					 }   
				 ),
				array(
					 'header' => 'Izin',
					// 'value' => '$data->getTotalStatusKehadiran(2, $data->pegawai_id)'
					 'value' => function ($data) use ($totKehadiran){                            
						if (isset($totKehadiran[$data->pegawai_id])){													
							return $totKehadiran[$data->pegawai_id][Params::STATUSKEHADIRAN_IZIN];
						}else{
							return 0;
						}
						//return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_IZIN, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
						//return $data->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_IZIN, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir); 
						//return '-';
					 } 
				 ),
				array(
					 'header' => 'Sakit',
					 //'value' => '$data->getTotalStatusKehadiran(3, $data->pegawai_id)'
					 'value' => function ($data) use ($totKehadiran){        
						if (isset($totKehadiran[$data->pegawai_id])){													
							return $totKehadiran[$data->pegawai_id][Params::STATUSKEHADIRAN_SAKIT];
						}else{
							return 0;
						}
						//return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_SAKIT, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
						//return $data->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_SAKIT, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
						//return '-';
					 } 
				 ),
				array(
					 'header' => 'Dinas',
					 //'value' => '$data->getTotalStatusKehadiran(4, $data->pegawai_id)'
					 'value' => function ($data) use ($totKehadiran){                            
						if (isset($totKehadiran[$data->pegawai_id])){													
							return $totKehadiran[$data->pegawai_id][Params::STATUSKEHADIRAN_DINAS];
						}else{
							return 0;
						}
						//return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_DINAS, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
						//return $data->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_DINAS, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
						//return '-';
					 } 
				 ),
				array(
					 'header' => 'Alpha',
					 //'value' => '$data->getTotalStatusKehadiran(5, $data->pegawai_id)'
					 'value' => function ($data) use ($totKehadiran){                            
						if (isset($totKehadiran[$data->pegawai_id])){

							return $totKehadiran[$data->pegawai_id][Params::STATUSKEHADIRAN_ALPHA];
						}else{
							return 0;
						}
						//return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_ALPHA, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
						//return $data->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_ALPHA, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
						//return '-';
					 } 
				 ),
                                         array(
					 'header' => 'Cuti',
					 'value' => function ($data) use ($totKehadiran){                            
						if (isset($totKehadiran[$data->pegawai_id])){

							return $totKehadiran[$data->pegawai_id][Params::STATUSKEHADIRAN_CUTI];
						}else{
							return 0;
						}
					 } 
				 ),
				array(
					 'header' => 'Total Terlambat',
					// 'value'=>'$this->grid->owner->renderPartial("daftarHadir/_terlambat",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>1),true)',
					 'value' => function ($data) use ($minute){     
						if (isset($minute[$data->pegawai_id])){													
							$j =  floor(abs($minute[$data->pegawai_id]['totalterlambat']) / 60);                       
							$m =  floor(abs(($minute[$data->pegawai_id]['totalterlambat'] / 60) - $j) * 60);

							if ($j == 0){
								return $m.' m';
							}else{
								if ($m == 0){
									return $j.'j';
								}else{
									return $j.'j '.$m.'m';
								}
							}
						}else{
							return 0;
						}

						//return $this->renderPartial("daftarHadir/_terlambat",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_MASUK,'tgl_awal'=>$model->tglpresensi,'tgl_akhir'=>$model->tglpresensi_akhir),true);
						//return $data->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_HADIR, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
						//return '-';
					 }   
				 ),
				array(
					 'header' => 'Total Pulang Awal',
					 //'value'=>'$this->grid->owner->renderPartial("daftarHadir/_pulangAwal",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2),true)',
					'value' => function ($data) use ($minute){     

						if (isset($minute[$data->pegawai_id])){													
							$j =  floor(abs($minute[$data->pegawai_id]['totalpulangawal']) / 60);                       
							$m =  floor(abs(($minute[$data->pegawai_id]['totalpulangawal'] / 60) - $j) * 60);

							if ($j == 0){
								return $m.' m';
							}else{
								if ($m == 0){
									return $j.'j';
								}else{
									return $j.'j '.$m.'m';
								}
							}
						}else{
							return 0;
						}
						//return $this->renderPartial("daftarHadir/_pulangAwal",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_PULANG,'tgl_awal'=>$model->tglpresensi,'tgl_akhir'=>$model->tglpresensi_akhir),true);
						//return '-';
					 } 
				 ),                    				
			),
			'afterAjaxUpdate'=>'
				function(id, data){
					jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
			}',
		)
	);
?>