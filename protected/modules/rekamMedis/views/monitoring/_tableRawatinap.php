<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'monitoring-v-grid',
	'dataProvider'=>$model->searchTable(),
                'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
                        array(
                            'header'=>'No.',
                            'value'=>'$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                        ),
                         array(
                            'header'=>'Tanggal Pendaftaran',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
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
                                $p = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=> $data->pendaftaran_id));
                                return $p->pegawai->namaLengkap;
                            },
                        ),
                        array(
                            'header'=>'Kelas Pelayanan',
                            'value'=>'$data->kelaspelayanan_nama',
                        ),
                         array(
                            'header'=>'Ruangan / Kamar',
                            'value'=>'$data->ruangan_nama." / ".$data->nomasukkamar',
                        ),
                        array(
                            'header'=>'Cara Masuk',
                            'value'=>'$data->caramasuk_nama',
                        ),
                        array(
                            'header'=>'Cara bayar / Penjamin',
                            'value'=>'$data->carabayar_nama." / ".$data->penjamin_nama',
                        ),
                        array(
                            'header'=>'Status Periksa',
                            'value'=>'$data->statusperiksa',
                        ),
                        array(
                            'header'=>'Diagnosa',
                            'value'=>function($data){
                                $p = RinciantagihanpasienV::model()->findByAttributes(array('pendaftaran_id'=> $data->pendaftaran_id));
                                $modPasienMorbi = PasienmorbiditasT::model()->findByAttributes(array(
                                    'pendaftaran_id'=> $data->pendaftaran_id,
                                    'pegawai_id'=> $p->pegawai_id
                                ));
                                if(!empty($modPasienMorbi)){
                                    $modDiagnosa = DiagnosaM::model()->findByPk($modPasienMorbi->diagnosa_id);
                                    $ketDiagnosa = !empty($modDiagnosa->ket_diagnosa)?$modDiagnosa->ket_diagnosa:' ';
                                    return !empty($modDiagnosa) ? $modDiagnosa->diagnosa_nama.'('.$ketDiagnosa.')' :'-';
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header'=>'Tagihan Sementara',
                            'value'=>function($data){
                                $p = RinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id'=> $data->pendaftaran_id));
                                $total = 0;
                                // var_dump($p);
                                foreach ($p as $items){
                                    // echo "<pre>";
                                    // var_dump($items->tarif_hargajual);
                                    $total += $items->tarif_hargajual;
                                }
                                return number_format($total,0,"",".");
                            },
                        ),

                       /* array(
                            'header'=>'Tgl. Masuk Kamar',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tglmasukkamar)',
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
));
