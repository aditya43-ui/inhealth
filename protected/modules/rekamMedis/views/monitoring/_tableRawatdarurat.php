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
                            'value'=>'$data->tgl_pendaftaran',
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
                                $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                return $p->pegawai->namaLengkap;
                            },
                        ),
                        array(
                            'header' => 'Ruangan Asal',
                            'type' => 'raw',
                            'value' => function($data) {
                                $html = $data->ruangan_nama;
                                $modNotriage = NotriagePasienT::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id]);
                                if(!empty($modNotriage)) {
                                    $modWpst = AsesmentriagewpssT::model()->findByAttributes(['notriage_pasien_id' => $modNotriage->notriage_pasien_id, 'create_ruangan' => $data->ruangan_id], ['order' => 'create_time desc']);
    
                                    if(!empty($modWpst)) {
                                        $html .= '<br><b>';
                                        $html .= $modWpst->ruang;
                                        $html .= '</b>';
                                    }
                                }

                                echo $html;

                            }
                        ),
                        array(
                            'header' => 'Ruangan Tujuan',
                            'type' => 'raw',
                            'value' => function($data) {
                                $html = '';
                                $modPemindahan = PemindahanpasienT::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id]);
                                if(!empty($modPemindahan->ruangantujuan_id)) {
                                    $modRuangan = RuanganM::model()->findByPk($modPemindahan->ruangantujuan_id);
                                    if(!empty($modRuangan)) {
                                        echo $modRuangan->ruangan_nama;
                                    }
                                    $modNotriage = NotriagePasienT::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id]);
                                    if(!empty($modNotriage)) {
                                        $modWpst = AsesmentriagewpssT::model()->findByAttributes(['notriage_pasien_id' => $modNotriage->notriage_pasien_id, 'create_ruangan' => $modPemindahan->ruangantujuan_id], ['order' => 'create_time desc']);
        
                                        if(!empty($modWpst)) {
                                            $html .= '<br><b>';
                                            $html .= $modWpst->ruang;
                                            $html .= '</b>';
                                        }
                                    }
                                }
                                echo $html;
                            }
                        ),
                        array(
                            'header'=>'Jenis Penjamin / Penjamin',
                            'value'=>'$data->carabayar_nama." / ".$data->penjamin_nama',
                        ),
                         array(
                            'header'=>'Status Periksa',
                            'value'=>'$data->statusperiksa',
                        ),
                      /*  array(
                            'header'=>'Poliklinik',
                            'value'=>'$data->ruangan_nama',
                        ),                                               */
                       
                        array(
                            'header'=>'Cara Keluar',
                            'value'=>'$data->carakeluar',
                        ),
                        array(
                            'header'=>'Status Bayar',
                            'value'=>'$data->carabayar_nama',
                        ),
                        array(
                            'header'=>'Alih Status',
                            'value'=>'$data->alihstatus',
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