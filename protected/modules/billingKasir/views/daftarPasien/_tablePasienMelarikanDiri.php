<?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'pencarianpasien-grid',
	'dataProvider'=>$modRI->searchPasienMelarikanDiri(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
                    array(
                        'header'=>'Tgl. Admisi/<br>Tgl. Rencana Pulang',
                        'name'=>'tgl_pulang',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $str = MyFormatter::formatDateTimeForUser($data->tgladmisi)."/<br>";
                            
                            $res = '<span style="color: red;">BELUM DI SET</span>';
                            
                            if (!empty($data->rencanapulang)) {
                                $res = '<span style="color: green;">'.MyFormatter::formatDateTimeForUser($data->rencanapulang).'</span>';
                            }
                            
                            return $str.$res;
                        }, // '$data->combineTglPendaftaran'
                    ),
                    array(
                        'header'=>'Tgl. Pendaftaran/<br>No. Pendaftaran',
                        'name'=>'no_pendaftaran',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."<br>".$data->no_pendaftaran',
                    ),
                    array(
                        'name'=>'no_rekam_medik',
                        'type'=>'raw',
                        'value'=>'$data->no_rekam_medik',
                    ),
                    array(
                        'name'=>'nama_pasien',
                        'type'=>'raw',
                        'value'=>'$data->namadepan.$data->nama_pasien',
                    ),
                    array(
                        'header'=>'Jenis Kelamin/<br>Umur',
                        'name'=>'umur',
                        'type'=>'raw',
                        'value'=>'$data->jeniskelamin."<br>".$data->umur',
                    ),
                    array(
                        'header'=>'Alamat',
                        'name'=>'alamat_pasien',
                        'type'=>'raw',
                        'value'=>'$data->alamat_pasien',
                    ),
                    array(
                        'header'=>'Ruangan<br>Kelas Pelayanan',
                        'name'=>'ruangan_nama',
                        'type'=>'raw',
                        'value'=>'$data->ruangan_nama."<br>".$data->kelaspelayanan_nama',
                    ),
                    array(
                        'header'=>'Kamar<br>No. Bed',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $adm = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);
                            $km = KamarruanganM::model()->findByPk($adm->kamarruangan_id);
                            if (empty($km)) return "-";
                            return $km->kamarruangan_nokamar."<br>:".$km->kamarruangan_nobed;
                        },
                    ),
                    array(
                        'header'=>'Dokter Penerima',
                        'type'=>'raw',
                        'value'=>function($data) {
                            if (!empty($data->dokterpenerima_id)) {
                                $pegawai = PegawaiM::model()->findByPk($data->dokterpenerima_id);
                                return $pegawai->namaLengkap;
                            }
                            
                            return "-";
                        },
                    ),
                    array(
                        'header'=>'Dokter PJP',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $nama = "<ul>";
                            if (!empty($data->pegawai_id)) {
                                $pegawai = PegawaiM::model()->findByPk($data->pegawai_id);
                                $nama .= "<li>".$pegawai->namaLengkap."</li>";
                            }

                            if (!empty($data->dpjp2_id)) {
                                $pegawai = PegawaiM::model()->findByPk($data->dpjp2_id);
                                $nama .= "<li>".$pegawai->namaLengkap."</li>";
                            }

                            if (!empty($data->dpjp3_id)) {
                                $pegawai = PegawaiM::model()->findByPk($data->dpjp3_id);
                                $nama .= "<li>".$pegawai->namaLengkap."</li>";
                            }
                            $nama .= "</lu>";
                            
                            return $nama;
                            //'$data->gelardepan." ".$data->nama_pegawai.", ".$data->gelarbelakang_nama',
                        },
                    ),
                    array(
                        'header'=>'Jenis Penjamin /<br>Penjamin',
                        'name'=>'carabayar_nama',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama."/<br>".$data->penjamin_nama',
                    ),
                    array(
                        'header'=>'Kelas Tanggungan',
                        'name'=>'kelastanggungan_nama',
                        'type'=>'raw',
                        'value'=>'$data->kelastanggungan_nama',
                    ),
                    /*
                    array(
                        'header'=>'Alias',
                        'name'=>'nama_bin',
                        'type'=>'raw',
                        'value'=>'$data->nama_bin',
                    ), */ /*
                    array(
                        'header'=>'Nama Penjamin',
                        'name'=>'penjamin_nama',
                        'type'=>'raw',
                        'value'=>'$data->penjamin_nama',
                    ), */
                    /*
                    array(
                        'header'=>'Rencana Pulang',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $admisi = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);
                            
                            $str = '<span style="color: red;">BELUM DI SET</span>';
                            
                            if (!empty($data->rencanapulang)) {
                                $str = '<span style="color: green;">'.MyFormatter::formatDateTimeForUser($data->rencanapulang).'</span>';
                            }
                            return $str;
                        }, //'$data->statusperiksa',
                        'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    ),
                     * 
                     */
                    array(
                            'header'=>'Total Biaya Pelayanan (Rp)',
                            'type'=>'raw',
                            'value'=>function($data) {
                                $total = 0;
                                $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
                                        'pendaftaran_id'=>$data->pendaftaran_id,
                                ), array('condition'=>'tindakansudahbayar_id is null'));
                                $oa = ObatalkespasienT::model()->findAllByAttributes(array(
                                    'pendaftaran_id'=>$data->pendaftaran_id,
                                ), array('condition'=>'oasudahbayar_id is null'));
                                
                                foreach ($tindakan as $item) {
                                    $total += $item->tarif_satuan * $item->qty_tindakan;
                                }
                                foreach ($oa as $item) {
                                    $total += $item->qty_oa * $item->hargasatuan_oa;
                                }
                                return MyFormatter::formatNumberForPrint($total);
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: right',
                            )
                        ),
//                    array(
//                        'header'=>'Rincian Tagihan',
//                        'type'=>'raw',
//                        'value'=>'CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->controller->createUrl("RinciantagihanpasienV/rincianBelumBayarRI",array("id"=>$data->pendaftaran_id,"frame"=>true)),
//                                    array("class"=>"", 
//                                          "target"=>"iframeRincianTagihan",
//                                          "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
//                                          "rel"=>"tooltip",
//                                          "title"=>"Klik untuk melihat Rincian Tagihan",
//                                    ))',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
//                    ),
                                /*
					array(
						'header'=>'Status Pembayaran',
						'type'=>'raw',
						'value'=>function($data) use (&$sb) {
                                                    $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                                                        'pendaftaran_id'=>$data->pendaftaran_id,
                                                    ), array('condition'=>'tindakansudahbayar_id is null'));
                                                    $oa = ObatalkespasienT::model()->findByAttributes(array(
                                                        'pendaftaran_id'=>$data->pendaftaran_id,
                                                    ), array('condition'=>'oasudahbayar_id is null'));

                                                    $sb = !empty($oa) || !empty($tindakan);

                                                    return $sb?"Belum Lunas":"Sudah Lunas";
                                                },//'(empty($data->pembayaranpelayanan_id) ? "Belum Lunas" : "Sudah Lunas")'
					),	
                                 * 
                                 */	
                    array(
                        'header'=>'Rincian Tagihan',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-detailtagihan\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayar",array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id,"frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframeRincianTagihan",
                                          "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk melihat Rincian Tagihan",
                                    ))',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),
                    array(
                        'header'=>'Rincian Farmasi',
                        'type'=>'raw',
                        'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                        'value'=>'CHtml::Link("<i class=\"icon-form-rtfarmasi\"></i>",Yii::app()->controller->createUrl("RincianTagihanFarmasi/RincianBiayaFarmasi",array("id"=>$data->pendaftaran_id,"frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframeRincianTagihan",
                                          "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk melihat Rincian Farmasi",
                                    ))',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),
                    array(
                        'header'=>'Grup Rincian',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-detailtagihan\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayarGrup",array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id,"frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframeRincianTagihan",
                                          "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk melihat Grup Rincian",
                                    ))',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),
                    array(
                        'header'=>'Pembayaran Kasir',
                        'type'=>'raw',
                        'value'=>function($data) use (&$sb) {
                                    // return $data->total_belum." : ".$data->total_oa_belum;
                                    $td = TindakanpelayananT::model()->findByAttributes(array(
                                        'pendaftaran_id'=>$data->pendaftaran_id,
                                    ));
                                    $oa = ObatalkespasienT::model()->findByAttributes(array(
                                        'pendaftaran_id'=>$data->pendaftaran_id,
                                    ));
                                    if (empty($td) && empty($oa)) return "BELUM ADA TRANSAKSI";
                                    
                                    $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                                        'pendaftaran_id'=>$data->pendaftaran_id,
                                    ), array('condition'=>'tindakansudahbayar_id is null'));
                                    $oa = ObatalkespasienT::model()->findByAttributes(array(
                                        'pendaftaran_id'=>$data->pendaftaran_id,
                                    ), array('condition'=>'oasudahbayar_id is null'));

                                    $sb = !empty($oa) || !empty($tindakan);

                                    return $sb?CHtml::Link("<i class=\"icon-form-bayar\"></i>",
                                        //Yii::app()->controller->createUrl("PembayaranTagihanPasien/index",array("instalasi_id"=>Params::INSTALASI_ID_RI,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id,"frame"=>true)),
                                        'javascript:void(0)',
                                        array("class"=>"", 
                                          //"target"=>"iframePembayaran",
                                          "onclick"=>"cekStatusPasien(".$data->pendaftaran_id.", ".$data->pasienadmisi_id.", ".$data->instalasi_id.");",//"$(\"#dialogPembayaranKasir\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk membayar ke kasir",
                                    )):"SUDAH<br>LUNAS";
                                },
                                'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),
                    array(
                        'header'=>'Verifikasi<br>Tagihan',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $verifikasi = VerifikasitagihanT::model()->findByAttributes(array(
                                'pendaftaran_id'=>$data->pendaftaran_id,
                            ), array(
                                'order'=>'verifikasitagihan_id desc',
                            ));
                            
                            if (empty($verifikasi)) {
                                return CHtml::link('<button class="btn btn-gold">BELUM<br>VERIFIKASI</button>', 
                                    $this->createUrl('verifikasiTagihan/index', array('pendaftaran_id'=>$data->pendaftaran_id)), array(
                                        'data-toggle'=>'tooltip',
                                        'title'=>'Klik untuk melakukan Verifikasi Tagihan Pasien.',
                                        "onclick"=>"gotoVerifikasi(".$data->pendaftaran_id."); return false;",
                                    ));
                            }
                            
                            return CHtml::link('<button class="btn btn-info">SUDAH<br>VERIFIKASI</button>',
                                $this->createUrl('verifikasiTagihan/detail', array('id'=>$verifikasi->verifikasitagihan_id)), array(
                                    'data-toggle'=>'tooltip',
                                    'title'=>'Klik untuk melihat detail Verifikasi Tagihan Pasien',
                                    'target'=>'iframeDetailVerifikasi',
                                    'onclick'=>'$("#dialogDetailVerifikasi").dialog("open");'
                                ));
                        }
                    ),
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
