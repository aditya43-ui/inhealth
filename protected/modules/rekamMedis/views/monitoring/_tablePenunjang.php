
<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'monitoring-v-grid',
	'dataProvider'=>$model->searchTable(),
                'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
                       array(
                            'header' => 'No.',
                            'value'=>'$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                        ),
                        array(
                            'header'=>'Tanggal Pendaftaran',
                            'value'=>'MyFormatter::formatDatetimeForUser($data->tgl_pendaftaran)',
                        ),
                        array(
                            'header'=>'No. Pendaftaran',
                            'value'=>'$data->no_pendaftaran',
                        ),
                         array(
                            'header'=>'No. Rekam Medik',
                            'value'=>'$data->no_rekam_medik',
                        ),
                        array(
                            'header'=>'Nama Pasien',
                            'value'=>'$data->nama_pasien',
                        ),
                        array(
                            'header'=>'Jenis Kelamin',
                            'value'=>'$data->jeniskelamin',
                        ),
 			array(
                            'header'=>'Jenis Kasus Penyakit',
                            'value'=>'$data->jeniskasuspenyakit_nama',
                        ),
                        array(
                            'header'=>'Dokter',
                            'value'=>function($data){
                                $p = PasienmasukpenunjangT::model()->findByPk($data->pasienmasukpenunjang_id);
                                return $p->pegawai->namaLengkap ?? "-";
                            },
                        ),
                       /* array(
                            'header'=>'Kasus Penyakit',
                            'value'=>'$data->jeniskasuspenyakit_nama',
                        ),*/
                        array(
                            'header'=>'Jenis Penjamin / Penjamin',
                            'value'=>'$data->carabayar_nama." / ".$data->penjamin_nama',
                        ),
                        /* array(
                            'header'=>'Status Periksa',
                            'value'=>'$data->statusperiksa',
                        ),*/
                        array(
                            'header'=>'Status Periksa Hasil',
                            'type'=>'raw',
                            'value'=>function($data){
                                if ($data->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK){
                                    $lab = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$data->pasienmasukpenunjang_id));                                                                        
                                    if (!empty($lab)){
                                        if ($lab->statusperiksahasil == Params::STATUSPERIKSAHASIL_BELUM){
                                            return Params::getWrStatusHasil(Params::STATUSPERIKSAHASIL_BELUM);
                                        }elseif ($lab->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG){
                                            return Params::getWrStatusHasil(Params::STATUSPERIKSAHASIL_SEDANG);
                                        }else{
                                            return Params::getWrStatusHasil(Params::STATUSPERIKSAHASIL_SUDAH);
                                        }
                                        
                                    }
                                }elseif ($data->ruangan_id == Params::RUANGAN_ID_RAD){
                                    $criRad = new CDbCriteria();
                                    $criRad->addCondition(" pendaftaran_id = '".$data->pendaftaran_id."' AND pasienmasukpenunjang_id = '".$data->pasienmasukpenunjang_id."' ");
                                    $criRad->addCondition(" (statusperiksahasil = '".Params::STATUSPERIKSAHASIL_BELUM."') OR (statusperiksahasil IS NULL)  "); 													
                                    $rad = HasilpemeriksaanradT::model()->findAll($criRad);

                                    if (count((array)$rad)>0){
                                            return Params::getWrStatusHasil(Params::STATUSPERIKSAHASIL_BELUM);
                                    }else{
                                            return Params::getWrStatusHasil(Params::STATUSPERIKSAHASIL_SUDAH);
                                    }
                                }elseif ($data->ruangan_id == Params::RUANGAN_ID_BEDAH){
                                    $ren = RencanaoperasiT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$data->pasienmasukpenunjang_id));
                                    
                                    if (!empty($ren)){
                                        if ($ren->statusoperasi == Params::STATUSPERIKSABEDAH_MULAI){
                                            return Params::getWrStatusBedah(Params::STATUSPERIKSABEDAH_MULAI);
                                        }elseif ($ren->statusoperasi == Params::STATUSPERIKSABEDAH_SELESAI){
                                            return Params::getWrStatusBedah(Params::STATUSPERIKSABEDAH_SELESAI);
                                        }if ($ren->statusoperasi == Params::STATUSPERIKSABEDAH_RENCANA){
                                            return Params::getWrStatusBedah(Params::STATUSPERIKSABEDAH_RENCANA);
                                        }
                                    }
                                }
                            
                                
                                    //return Params::getWrStatusPeriksa($data->pendaftaran->statusperiksa);
                            },
                        ),
                        array(
                            'header'=>'Ruangan',
                            'value'=>'$data->ruangan_nama',
                        ),                       
                        array(
                            'header'=>'Perujuk',
                            'type'=>'raw',
                            'value'=>function($data) {
                                  $p = PasienkirimkeunitlainT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$data->pasienmasukpenunjang_id));
                                //$p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                //$r = RujukanT::model()->findByPk($p->rujukan_id);
                                return empty($p)?"-":$p->pegawai->namaLengkap;
                            }
                        ),
                        /*array(
                            'header'=>'Status Bayar',
                            'value'=>'(($data->pembayaranpelayanan_id == "") ? "Belum bayar" : "Sudah bayar")',
                        ),*/
//		'pasien_id',
//		'namadepan',
//		'nama_pasien',
//		'nama_bin',
//		'jeniskelamin',
//		'no_rekam_medik',
		/*
		'pendaftaran_id',
		'no_pendaftaran',
		'tgl_pendaftaran',
		'no_urutantri',
		'statusperiksa',
		'statuspasien',
		'kunjungan',
		'umur',
		'carabayar_id',
		'carabayar_nama',
		'penjamin_id',
		'penjamin_nama',
		'ruangan_id',
		'ruangan_nama',
		'instalasi_id',
		'instalasi_nama',
		'jeniskasuspenyakit_id',
		'jeniskasuspenyakit_nama',
		'kelaspelayanan_id',
		'kelaspelayanan_nama',
		'pembayaranpelayanan_id',
		'alihstatus',
		'pasienbatalperiksa_id',
		*/
//		array(
//			'class'=>'CButtonColumn',
//		),
	),
)); ?>