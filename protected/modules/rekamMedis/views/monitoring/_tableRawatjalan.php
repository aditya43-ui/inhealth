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
                            'value'=>function($data) {
                                $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                return $p->pegawai->namaLengkap;
                            },
                        ),
                        array(
                            'header'=>'Poliklinik',
                            'value'=>'$data->ruangan_nama',
                        ),
                        array(
                            'header'=>'Jenis Penjamin / Penjamin',
                            'value'=>function($data){
                                $p = $data->carabayar_nama.' / '.$data->penjamin_nama;
                                return $p;
                            },
                        ),                                              
                        array(
                            'header'=>'Status Periksa',
                            'value'=>'$data->statusperiksa',
                        ),
                        array(
                            'header'=>'Status Bayar',
                            'value'=>'(($data->pembayaranpelayanan_id == "") ? "Belum bayar" : "Sudah bayar")',
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