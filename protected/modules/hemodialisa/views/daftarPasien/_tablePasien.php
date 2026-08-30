<!--<div class="table-responsive" >-->
<?php
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarPasien-grid',
    'dataProvider' => $model->searchHD(),
    'template' => "{summary}\n{items}\n{pager}",
    'replaceUrl' => true,
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'No.Antrian',
            'type' => 'raw',
//				'value' => '$data->getNoAntrianPasien($data->ruangan_id)."".$data->no_urutantri',
//				'value' => '$data->getNoAntrianPasien($data->pendaftaran_id)', 
            'value' => function($data) use (&$admisi) {
                $onclick = "verifikasiAntrian('".$data->pendaftaran_id."');";
                if (!empty($data->waktupanggilpasien)){
                    $onclick = '';
                }

                $verifikasi = '';
//                var_dump($data->waktuverifikasipasien);die;
                if (empty($data->waktuverifikasipasien)){
                    $verifikasi = CHtml::htmlButton(Yii::t("mds","<i class='icon-ok icon-white'></i>",array()),array("class"=>"btn btn-success","onclick"=>$onclick));
                }
                
                    $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
                    return $data->ruangan_singkatan . "-" . $data->no_urutantri . "<br>" . ($data->status_hd != Params::STATUSPERIKSA_ANTRIAN ? "" : CHtml::htmlButton(Yii::t("mds", "{icon}", array("{icon}" => "<i class='icon-volume-up icon-white'></i>")), array("class" => "btn btn-primary", "onclick" => "panggilAntrian('" . $data->pendaftaran_id . "'); setSuaraPanggilanSingle('" . $data->ruangan_singkatan . "','" . $data->no_urutantri . "','" . $data->ruangan_id . "')", "rel" => "tooltip", "title" => "Klik untuk memanggil pasien ini")))
                            .$verifikasi;                
            },
        ),
        array(
            'header' => 'Tgl. Pendaftaran /<br>No. Pendaftaran',
            'type' => 'raw',
            'value' => '$data->tgl_pendaftaran."<br>".$data->no_pendaftaran'
        ),
        array(
            'name' => 'no_rekam_medik/<br>N I K',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik."<br>".$data->no_identitas_pasien',
        ),
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->namaNamaBin'
        ),
        array(
            'header' => 'Jenis Penjamin / Penjamin',
            'value' => '$data->caraBayarPenjamin',
        ),
        array(
            'header' => 'Kelas Pelayanan',
            'type' => 'raw',
            'value' => '$data->kelaspelayanan_nama',
            'htmlOptions' => array(
                'style' => 'text-align: center;',                
            )
        ),
        array(
            'header' => 'Jenis Tindakan',
            'type' => 'raw',
            'value' => 'CHtml::hiddenField("HDInfoKunjunganRDV[$data->pendaftaran_id][pendaftaran_id]", $data->pendaftaran_id, array("id"=>"pendaftaran_id","onkeypress"=>"return $(this).focusNextInputField(event)","class"=>"span3"))."".CHtml::link("".$data->jeniskasuspenyakit_nama,"javascript:void(0)",array("onclick"=>"ubahKasusPenyakit(this,$data->pendaftaran_id,$data->jeniskasuspenyakit_id);return false;","class"=>"kasus_penyakit","rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Kasus Penyakit"))',
            'htmlOptions' => array(
                'style' => 'text-align: center',
                'class' => 'list_kasus_penyakit'
            )
        ),
//			array(
//				'name' => 'Dokter',
//				'type' => 'raw',
//				'value' => '"<div style=\'width:100px;\'>" . CHtml::link("<i style=font-size:20px class=entypo-pencil></i>". $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama," ",array("onclick"=>"ubahDokterPeriksa(\'$data->pendaftaran_id\');$(\'#editDokterPeriksa\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Dokter Periksa")) . "</div>"',
//			),
        array(
            'name' => 'Dokter / PPDS',
            'type' => 'raw',
            'value' => function ($data) use (&$admisi) {

                    $dokter = $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama;

                    echo CHtml::link('<i class="icon-pencil-brown"></i>'. $dokter," ",array("onclick"=>"ubahDokterPeriksa(\'$data->pendaftaran_id\');$(\'#editDokterPeriksa\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Dokter Periksa"));
                    echo "<br>";
                    if(Yii::app()->user->getState('isppds')) {
                    echo CHtml::link(
                         '<i class="icon-pencil-brown"></i>Tambah PPDS',
                            Yii::app()->controller->createUrl(Yii::app()->controller->id . "/create", array("pendaftaran_id" => $data->pendaftaran_id)),
                            array("title" => "Klik untuk Tambah PPDS", "target" => "iframeDetailPPDS", "onclick" => '$("#dialogDetailPPDS").dialog("open");', "rel" => "tooltip")
                        );
                        $ppds = PasienPpdsT::model()->findAllByAttributes(array(
                            'pendaftaran_id' => $data->pendaftaran_id
                        ));

                        $itemz ='';      
                        $x =1;   
                        
                        foreach($ppds as $itemz){
                            echo '<br>';
                            echo '<i class="icon-pencil-brown"></i>PPDS &nbsp;',$x++.'-'.$itemz->ppds->ppds_nama;
                           }
                   
                    } 
                  },
            'htmlOptions' => array(
                'class' => 'rajal'
            )
        ),       
        
//                        array(
//                            'header'=> 'Shift',
//                            'type'=>'raw',
//                            'value'=>function($data){
//                                    $shift = ShiftHdM::model()->findByPk($data->shift_id);
//                                    return $shift->shift_hd_nama;
//                            }
//                        ),
        array(
            'header' => 'Shift',
            'type' => 'raw',
            'value' => '$data->shift_hd_nama'
        ),
        array(
            'name' => 'Riwayat Vaksinasi/Imunisasi',
            'type' => 'raw',
            // 'value' => '',
            'value' => function ($data) {
                return CHtml::link('<i class="icon-form-detail"></i>', Yii::app()->controller->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/updateRiwayatVaksinasi', array(
                    'pendaftaran_id'=>$data->pendaftaran_id,
                )), array(
                    'target'=>'frameRiwayatVaksinasi',
                    'onclick'=>"$('#dialogRiwayatVaksinasi').dialog('open');",
                ));
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Lantai/Bed',
            'type' => 'raw',
            'value' => '($data->statusperiksa !== "' . Params::STATUSPERIKSA_SEDANG_DIRAWATINAP . '" && $data->statusperiksa !== "' . Params::STATUSPERIKSA_BATAL_PERIKSA . '" && $data->statusperiksa !== "' . Params::STATUSPERIKSA_SUDAH_PULANG . '") ?
							$data->kamarruangan_nokamar."<br>Bed : ".$data->kamarruangan_nobed.
							CHtml::link("<i style=\'font-size:20px\' class=\'entypo-home\'></i><br>", Yii::app()->controller->createUrl("ubahKamarRuangan",array("pendaftaran_id"=>$data->pendaftaran_id)),
							array("id"=>"$data->no_pendaftaran",
								"rel"=>"tooltip",
								"title"=>"Klik untuk pindah kamar pasien",
								"target"=>"frameKamarRuangan",
								"onclick"=>"$(\'#dialogKamarRuangan\').dialog(\'open\');"
							))
							:
							$data->kamarruangan_nokamar."<br>Bed : ".$data->kamarruangan_nobed.
                                                        CHtml::link("<i style=\'font-size:20px\' class=\'entypo-home\'></i><br>", Yii::app()->controller->createUrl("ubahKamarRuangan",array("pendaftaran_id"=>$data->pendaftaran_id)),
							array("id"=>"$data->no_pendaftaran",
								"rel"=>"tooltip",
								"title"=>"Klik untuk pindah kamar pasien",
								"target"=>"frameKamarRuangan",
								"onclick"=>"$(\'#dialogKamarRuangan\').dialog(\'open\');"
							))
							',
            'htmlOptions' => array(
                'style' => 'text-align: center',
            )
        ),
        array(
            'header'=>'Status Tindakan',
            'type'=>'raw',
            //'value'=>'$data->getStatus($data->status_hd,$data->pendaftaran_id,$data)',
            // 'value' => function($data){
            //      return Params::getWrStatusTindakan($data->status_hd);
            // },
            'value' => function($data){
                $status = trim($data->status_hd);
                if ($status == "SEDANG TINDAKAN") {
                    $status = '<span id="red" class="btn btn-gold nohover" name="yt1" style="width:150px;">' . $status . '</span>';
                } elseif ($status == "ANTRIAN") {
                    $status = '<span id="green" class="btn btn-black nohover" style="color:#fff;width:150px;">' . $status . '</span>';
                } elseif ($status == "SELESAI TINDAKAN") {
                    $status = '<span id="blue" class="btn btn-green nohover"  style="color:#fff;width:150px;">' . $status . '</span>';
                } else {
                    $status = '<span id="orange" class="btn btn-danger nohover" style="width:150px;">' . $status . '</span>';
                }

                return CHtml::link($status, Yii::app()->controller->createUrl('StatusHemodialisa', array(
                        'pendaftaran_id'=>$data->pendaftaran_id, 'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id
                    )), array(
                        'target'=>'frameStatusHemodialisa',
                        'onclick'=>"$('#dialogStatusHemodialisa').dialog('open');",
                    ));
            },
            'headerHtmlOptions' => array('style'=>'width:170px !important')
        ),
        array(
            'name' => 'Asesmen Perawat',
            'type' => 'raw',
            'value' => function($data) {

//                                    if($data->alihstatus==FALSE) {
                $st = CHtml::link("<i style='font-size:30px' class='" . MyIcon::getIcons('periksa') . "'></i> ", Yii::app()->controller->createUrl("/hemodialisa/pemeriksaanAsesmenPerawat", array("pendaftaran_id" => $data->pendaftaran_id, 'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Pemeriksaan Pasien"));
        
                return $st;

//                                    }else{
//                                        return CHtml::link("<i style='font-size:30px' class='".MyIcon::getIcons('periksa')."></i>", "javascript:cektindaklanjut()",array("rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"));
//                                        
//                                    }
            },
            'htmlOptions' => array('style' => 'text-align: center; width:40px')
        ),
        array(
            'name' => 'Asesmen Medis',
            'type' => 'raw',
            'value' => function($data) {
//                                        if($data->alihstatus==FALSE) {
                $st = CHtml::link("<i style='font-size:30px' class='" . MyIcon::getIcons('periksa') . "'></i> ", Yii::app()->controller->createUrl("/hemodialisa/pemeriksaanPasienTHD", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Pemeriksaan Pasien"));
                return $st;
//                                        }else{ 
//                                            return CHtml::link("<i style='font-size:30px' class='".MyIcon::getIcons('periksa')."></i>", "javascript:cektindaklanjut()",array("rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"));
//                                            
//                                        }
            },
            'htmlOptions' => array('style' => 'text-align: center; width:40px')
        ),
        array(
            'name' => 'Persetujuan',
            'type' => 'raw',
            'value' => function ($data) {
                $link = CHtml::link('<i class="icon-form-ubah"></i><br>Tindakan', Yii::app()->controller->createUrl("PersetujuanTindakanTHD/index", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat persetujuan tindakan"));
                $link .= CHtml::link('<i class="icon-form-ubah"></i><br>Inform Consent', Yii::app()->controller->createUrl("PersetujuanTindakanUmumHD/index", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan Inform Consent (Persetujuan)"));
                $link .= CHtml::link('<br><i class="icon-form-ubah"></i><br>Anastesi', Yii::app()->controller->createUrl("PersetujuanTindakanAnastesiHD/index", array("pendaftaran_id" => $data->pendaftaran_id, "noframe" => 1)), array("id" => $data->no_pendaftaran . "_antrian", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat persetujuan tindakan anastesi"));
                return $link;
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'name' => 'Penolakan',
            'type' => 'raw',
            'value' => function ($data) {
                $link = CHtml::link('<i class="icon-form-silang"></i><br>Tindakan ', Yii::app()->controller->createUrl("PersetujuanTindakanTHD/penolakan", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat penolakan tindakan"));
                $link .= CHtml::link('<i class="icon-form-silang"></i><br>Inform Refusal', Yii::app()->controller->createUrl("PersetujuanTindakanUmumHD/penolakan", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan Inform Consent (Penolakan)"));
                $link .= CHtml::link('<i class="icon-form-silang"></i><br>Anastesi', Yii::app()->controller->createUrl("PersetujuanTindakanAnastesiHD/penolakan", array("pendaftaran_id" => $data->pendaftaran_id, "noframe" => 1)), array("id" => $data->no_pendaftaran . "_antrian", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat penolakan tindakan anastesi"));
                return $link;
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        /* array(
          'name' => 'Alergi Obat',
          'type' => 'raw',
          'value' => function($data){return CHtml::link("<i  class='".MyIcon::getIcons('alergi')."'></i> ", Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/alergiObat",array("pendaftaran_id"=>$data->pendaftaran_id)),
          array("id"=>"$data->no_pendaftaran",
          "rel"=>"tooltip",
          "title"=>"Klik untuk melihat riwayat alergi obat pasien",
          "target"=>"frameAlergiObat",
          "onclick"=>"$('#dialogAlergiObat').dialog('open');"
          ));},
          'htmlOptions' => array('style' => 'text-align: center; width:60px')
          ), */
        array(
            'header' => 'Tindak Lanjut<br/>ke Rawat Inap',
            'type' => 'raw',
            'value' => function($data){
                if($data->statusperiksa ==Params::STATUSPERIKSA_SEDANG_DIRAWATINAP){
                    echo 'Pasien di Rawat Inap'.CHtml::link('<i class="icon-form-sampah"></i>', 
                    Yii::app()->controller->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/BatalRawatInap',array("pendaftaran_id"=>$data->pendaftaran_id)) , 
                    array(
                        "title"=>"Klik Untuk Batal Proses Tindak Lanjut Pasien",
                        "target"=>"frameTindakLanjut",
                        "onclick"=>"$('#dialogBatalRawatInap').dialog('open');",
                         "rel"=>"tooltip"
                         )
                    );
                }else{
                    return $data->getTindakLanjutRINew($data->instalasi_id, $data->pendaftaran_id);
                    // CHtml::link(
                    //     '<i class="icon-form-ri"></i>', 
                    //     Yii::app()->createUrl(Yii::app()->controller->module->id . '/TindakLanjutDariHD/tindakLanjutRI', 
                    //     array(
                    //         "instalasi_id"=>$data->instalasi_id,
                    //         "pendaftaran_id"=>$data->pendaftaran_id
                    //     )),
                    // array("class"=>"",
                    // "target"=>"frameTindakLanjut",
                    // "rel"=>"tooltip",
                    // "title"=>"Klik untuk Proses Tindak Lanjut Pasien",
                    // "onclick"=>"$('#dialogTindakLanjut').dialog('open');")
                    // );
                }
            },
            // 'value' => '($data->statusperiksa == "' . Params::STATUSPERIKSA_SEDANG_DIRAWATINAP . '") ?
            // ("Pasien di Rawat Inap".
            // CHtml::link("<i class=\'icon-form-sampah\'></i>", 
            // Yii::app()->controller->createUrl("/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/BatalRawatInap",array("pendaftaran_id"=>$data->pendaftaran_id)) , array("title"=>"Klik Untuk Batal Proses Tindak Lanjut Pasien","target"=>"iframeBatalRawatInap", 
            // "onclick"=>"$(\"#dialogBatalRawatInap\").dialog(\"open\");", "rel"=>"tooltip")))
            // : $data->getTindakLanjutRINew($data->instalasi_id, $data->pendaftaran_id)',
            // CHtml::link(
            //     "<i class=\'icon-form-ri\'></i>", 
            //     Yii::app()->createUrl("/' . Yii::app()->controller->module->id . '/TindakLanjutDariHD/tindakLanjutRI", 
            //     array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id)),
            // array("class"=>"",
            // "target"=>"frameTindakLanjut",
            // "rel"=>"tooltip",
            // "title"=>"Klik untuk Proses Tindak Lanjut Pasien",
            // "onclick"=>"$(\'#dialogTindakLanjut\').dialog(\'open\');")
            // ),
            'htmlOptions' => array('style' => 'text-align: center; width:60px')
            ),
        array(
            'header' => 'Status Dokumen',
            'type' => 'raw',
            'value' => '($data->statusdokrm == "SUDAH DITERIMA") ? CHtml::link("<i></i> $data->statusdokrm", Yii::app()->createUrl("/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/statusDokumenKirim", array("pengirimanrm_id"=>$data->pengirimanrm_id,"pendaftaran_id"=>$data->pendaftaran_id)),
								array("class"=>"btn btn-primary",
								"target"=>"frameStatusDokumen",
								"rel"=>"tooltip",
								"title"=>"Klik untuk mengirim dokumen ke ruangan lain",
								"onclick"=>"$(\'#dialogStatusDokumen\').dialog(\'open\');"))
					: $data->getStatusDokumen($data->pengirimanrm_id,$data->statusdokrm,$data->pendaftaran_id)',
            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
        ),
        /* array(
          'header' => 'Tindak Lanjut<br/>ke Rawat Inap',
          'type' => 'raw',
          'value' => '($data->statusperiksa == "' . Params::STATUSPERIKSA_SEDANG_DIRAWATINAP . '") ?
          ("Pasien di Rawat Inap<br>".$data->getNamaKamar()."<br>".$data->getNoBed().
          CHtml::link("<i class=\'icon-form-sampah\'></i>", Yii::app()->controller->createUrl("/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/BatalRawatInap",array("pendaftaran_id"=>$data->pendaftaran_id)) , array("title"=>"Klik Untuk Batal Proses Tindak Lanjut Pasien","target"=>"iframeBatalRawatInap", "onclick"=>"$(\"#dialogBatalRawatInap\").dialog(\"open\");", "rel"=>"tooltip")))
          : $data->getTindakLanjutRI($data->instalasi_id, $data->pendaftaran_id)',
          CHtml::link("<i class=\'icon-form-ri\'></i>", Yii::app()->createUrl("/' . Yii::app()->controller->module->id . '/TindakLanjutDariHD/tindakLanjutRI", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id)),
          array("class"=>"",
          "target"=>"frameTindakLanjut",
          "rel"=>"tooltip",
          "title"=>"Klik untuk Proses Tindak Lanjut Pasien",
          "onclick"=>"$(\'#dialogTindakLanjut\').dialog(\'open\');"))',
          'htmlOptions' => array('style' => 'text-align: center; width:60px')
          ), */
//        array(
//            'header' => 'Tindak Lanjut',
//            'type' => 'raw',
//            'value' => function($data){
//                    $st = (($data->pasienpulang_id != 0) OR ($data->carakeluar != "")) ? $data->carakeluar : CHtml::link("<icon style='font-size:20px' class='entypo-pencil'></icon>", Yii::app()->createUrl("/hemodialisa/daftarPasien/PasienPulang", array("pendaftaran_id"=>$data->pendaftaran_id,"dialog"=>true)), array("target"=>"iframePasienPulang", "onclick"=>"$('#dialogPasienPulang').dialog('open');","rel"=>"tooltip", "title"=>"Klik untuk menambahkan tindak lanjut"));
//                    if (empty($data->waktuverifikasipasien))
//                        $st =  CHtml::link("<i style='font-size:20px' class='entypo-pencil'></i> ", 'javascript:;', array('onclick'=>'toastr.error("Lakukan varifikasi kedatangan terlebih dahulu.","Perhatian!")',"id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Pemeriksaan Pasien"));
//                
//                    if (!empty($data->konsulpoli_id))
//                        $st = Params::STATUSPERIKSA_DIRAWATINAP;
//                    
//                    return $st;
//            },
//            'htmlOptions' => array('style' => 'text-align: center; width:40px')
//        ),
        /* array(
          'header' => 'Rincian Detail dan Tagihan',
          'type' => 'raw',
          //                        'value'=>'CHtml::link("<icon class=\'icon-list-brown\'></icon>", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/RinciantagihanpasienExtendsV/rincianBelumBayarHD", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');","rel"=>"tooltip", "title"=>"Klik untuk melihat rincian tagihan"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
          'value' => 'CHtml::link("<icon class=\'icon-form-detailtagihan\'></icon>", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/RincianTagihanPasienDetail", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');","rel"=>"tooltip", "title"=>"Klik untuk melihat detail rincian tagihan"))."<br>".CHtml::link("<icon class=\'icon-form-detail\'></icon>", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/RincianTagihanPasien", array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');","rel"=>"tooltip", "title"=>"Klik untuk melihat rincian tagihan"))',
          'htmlOptions' => array('style' => 'text-align: center; width:40px')
          ),
          dicommetn karena RND-11988
          array(
          'header' => 'Tagihan',
          'type' => 'raw',
          //                        'value'=>'CHtml::link("<icon class=\'icon-list-brown\'></icon>", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/RinciantagihanpasienExtendsV/rincianBelumBayarHD", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');","rel"=>"tooltip", "title"=>"Klik untuk melihat rincian tagihan"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
          //				'value' => 'CHtml::link("<icon class=\'icon-form-detail\'></icon>", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayar", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');","rel"=>"tooltip", "title"=>"Klik untuk melihat rincian tagihan"))', 'htmlOptions' => array('style' => 'text-align: center; width:40px')
          'value' => 'CHtml::link("<icon class=\'icon-form-detail\'></icon>", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/RincianTagihanPasien", array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');","rel"=>"tooltip", "title"=>"Klik untuk melihat rincian tagihan"))', 'htmlOptions' => array('style' => 'text-align: center; width:40px')
          ), */
          array(
            'header' => 'Catatan Edukasi',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::link('<i class="icon-form-detail"></i>', $this->createUrl('/hemodialisa/catatanEdukasiHD/create', array('pendaftaran_id'=>$data->pendaftaran_id)), array(
                    'rel'=>'tooltip',
                    'title'=>'Catatan Edukasi Pasien',
                ));
            },
            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
        ),
        array(
            'name'=>'Catatan Perkembangan Pasien Terintegrasi (CPPT)',
            'type'=>'raw',
            'value'=>function($data) {
                return CHtml::link('<i class="icon-form-detail"></i> ', Yii::app()->createUrl("/rehabMedis/CPPT/index",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Catatan Perkembangan Pasien Terintegrasi (CPPT)"));
            },
            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
        ),
          array(
            'header' => 'Pemindahan Pasien',
            'type' => 'raw',
            'value' => function($data) {
              $htmlLink = CHtml::link('<i class="icon-form-detail"></i>', Yii::app()->createUrl('/hemodialisa/pemindahanPasienHD/index', array('pendaftaran_id'=>$data->pendaftaran_id)), array(
                  'rel'=>'tooltip',
                  'title'=>'Pemindahan Pasien',
              ));

              $modFormTransfer = PemindahanpasienT::model()->findAllByAttributes(array('ruangantujuan_id'=>Yii::app()->user->getState("ruangan_id"),'pendaftaran_id'=>$data->pendaftaran_id),array('condition'=>'(ispasienditerima IS NULL OR ispasienditerima = false)'));
              $linkPenerima = "";
              if(isset($modFormTransfer) && count($modFormTransfer) > 0){
                  $linkPenerima = CHtml::link('<i class="icon-form-check"></i> ', Yii::app()->createUrl("/hemodialisa/pemindahanPasienHD/index",array("pendaftaran_id"=>$data->pendaftaran_id,'pasienditerima'=>'diterima')),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Penerimaan Pemindahaan Pasien"));
              }

              return $htmlLink .'<br/>'.$linkPenerima;
            },
            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
        ),
        array(
            'header' => 'Catatan Pemindahan Pasien',
            'type' => 'raw',
            'value' => function ($data) {
                $modPemindahanPasien = PemindahanpasienT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id));
                if (!empty($modPemindahanPasien)) {
                    return CHtml::link(
                        '<icon class="icon-form-detail"></icon>',
                        $this->createUrl("/hemodialisa/pemindahanPasienHD/detail", array("pemindahanpasien_id" => $modPemindahanPasien->pemindahanpasien_id)),
                        array(
                            "target" => "frameDetail",
                            "onclick" => "$('#dialogDetail').dialog('open');",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Melihat Detail Riwayat Pemindahaan Pasien",

                        )
                    );
                } else {
                    return "";
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
        ),
        array(
            'header' => 'Batal Tindakan',
            'type' => 'raw',
            'value' => 'CHtml::link("<icon style=\'font-size:20px\' class=\'glyphicon glyphicon-remove\'></icon>", "javascript:dialogBatalPeriksa(\'$data->pendaftaran_id\',\'$data->statusperiksa\',\'$data->nama_pasien\')",array("data-placement"=>"left","id"=>"$data->pendaftaran_id","rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan"))',
            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>
<!--</div>-->

<?php echo $this->renderPartial("_dialogPersetujuan", array(), true); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogDetail',
        'options' => array(
            'title' => 'Detail Riwayat Peminahaan Pasien',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1000,
            'height' => 550,
            'resizable' => false
        ),
    ));
    ?>
	<iframe name='frameDetail' width="100%" height="98%"></iframe>
	<?php $this->endWidget(); ?>

    
<?php
//=============================== Dialog Riwayat Vaksinasi =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogRiwayatVaksinasi',
        'options' => array(
            'title' => 'Riwayat Vaksinasi/Imunisasi',
            'autoOpen' => false,
            'zIndex' => 1002,
            'width' => 1000,
            'height' => 450,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                        data: $('#formCari').serialize()
                    }); }",
        ),
    )
);

echo '<iframe name="frameRiwayatVaksinasi" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
//=============================== Dialog Status =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogStatusHemodialisa',
        'options' => array(
            'title' => 'Ubah Status Hemodialisa',
            'autoOpen' => false,
            'zIndex' => 300,
            'width' => 340,
            'height' => 240,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                data: $('#daftarPasien-form').serialize()
            }); }",
        ),
    )
);

echo '<iframe name="frameStatusHemodialisa" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailPPDS',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">PPDS</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 650,
        'height' => 570,
        'resizable' => true
    ),
));
?>
<iframe name='iframeDetailPPDS' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>


<script type="text/javascript">
    {
        function dialogBatalPeriksa(pendaftaran_id, statusperiksa, nama_pasien)
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('cekTagihan'); ?>',
                data: {pendaftaran_id: pendaftaran_id, statusperiksa: statusperiksa}, //
                dataType: "json",
                success: function (data) {
                    if (data.status_batal == true) {
                        $('#titleNamaPasienBatal').html(nama_pasien);
                        $('#DialogBatalperiksa #pendaftaran_id').val(pendaftaran_id);
                        $('#DialogBatalperiksa #statusperiksa').val(statusperiksa);
                        $('#DialogBatalperiksa').dialog('open');
                        return false;
                    } else {
                        myAlert(data.pesan);
                    }
                    $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $(this).serialize()
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        }

        function batalperiksa()
        {
            var statusperiksa = $('#DialogBatalperiksa #statusperiksa').val();
            var pendaftaran_id = $('#DialogBatalperiksa #pendaftaran_id').val();
            var tglbatal = $('#DialogBatalperiksa #tglbatal').val();
            var keterangan_batal = $('#DialogBatalperiksa #keterangan_batal').val();

            if (tglbatal == '') {
                myAlert('Tanggal Batal harus diisi!');
                return false;
            }
            if (keterangan_batal == '') {
                myAlert('Alasan Batal harus diisi!');
                return false;
            }
//		 
                   $.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('batalPeriksa'); ?>',
			data: {pendaftaran_id: pendaftaran_id,tglbatal:tglbatal,keterangan_batal:keterangan_batal},//
			dataType: "json",
			success:function(data){
				if(data.status == true){
					myAlert(data.pesan);
					$('#DialogBatalperiksa').dialog('close');
					$.fn.yiiGridView.update('daftarPasien-grid', {
						data: $(this).serialize() });
					$('#DialogBatalperiksa #keterangan_batal').val("");
					// Notifikasi Pasien
					if(data.smspasien==0){
						var params = [];
						params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
						insert_notifikasi(params);
					} 
					// Notifikasi Dokter
					if(data.smsdokter==0){
						var params = [];
						params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS DOKTER', isinotifikasi:'dr. '+data.nama_pegawai+' tidak memiliki nomor mobile'}; // 16 
						insert_notifikasi(params);
					}
				}else if(data.pesan == 'exist'){
					myAlert('Pasien telah melakukan pemeriksaan');
					$('#DialogBatalperiksa').dialog('close');
				}else{
					myAlert(data.pesan);
					$('#DialogBatalperiksa').dialog('close');
				}
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
               
        }




        function ubahPeriksaKarenaBatal() {
            var pendaftaran_id = $('#DialogBatalperiksa #pendaftaran_id').val();
            var tglbatal = $('#DialogBatalperiksa #tglbatal').val();
            var keterangan_batal = $('#DialogBatalperiksa #keterangan_batal').val();

            $('#DialogBatalperiksa #keterangan_batal').attr('class', '');
            if (keterangan_batal == '') {
                myAlert("Alasan Pembatalan Pasien Ini, wajib diisi");
                $('#DialogBatalperiksa #keterangan_batal').attr('class', 'error');
                return false;
            }

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('batalPeriksa'); ?>',
                data: {pendaftaran_id: pendaftaran_id, statusperiksa: statusperiksa, tglbatal: tglbatal, keterangan_batal: keterangan_batal, nama_pemakai: nama_pemakai, kata_kunci: kata_kunci}, //
                dataType: "json",
                success: function (data) {
                    if (data.status == true) {
                        myAlert(data.pesan);
                        $('#DialogBatalperiksa').dialog('close');
                        $.fn.yiiGridView.update('daftarpasien-grid', {
                            data: $(this).serialize()});

                        // Notifikasi Pasien
                        if (data.smspasien == 0) {
                            var params = [];
                            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi: 'GAGAL KIRIM SMS PASIEN', isinotifikasi: 'Pasien ' + data.nama_pasien + ' tidak memiliki nomor mobile'}; // 16 
                            insert_notifikasi(params);
                        }
                        // Notifikasi Dokter
                        if (data.smsdokter == 0) {
                            var params = [];
                            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi: 'GAGAL KIRIM SMS DOKTER', isinotifikasi: 'dr. ' + data.nama_pegawai + ' tidak memiliki nomor mobile'}; // 16 
                            insert_notifikasi(params);
                        }
                    } else if (data.pesan == 'exist') {
                        myAlert('Pasien telah melakukan pemeriksaan');
                        $('#DialogBatalperiksa').dialog('close');
                    } else {
                        myAlert(data.pesan);
                        $('#DialogBatalperiksa').dialog('close');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        }








        //validasi pemeriksaan
        function cektindaklanjut()
        {
            myAlert("Pasien sudah ditindak lanjut ke Rawat Inap !");
        }

    }
    /**
     * untuk ubah kasus penyakit
     * @param {type} obj
     * @param {type} pendaftaran_id
     * @param {type} jeniskasuspenyakit_id
     * @returns {Boolean} */

    function ubahKasusPenyakit(obj, pendaftaran_id, jeniskasuspenyakit_id) {
        var pendaftaran_id = pendaftaran_id;
        var jeniskasuspenyakit_id = jeniskasuspenyakit_id;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownKasusPenyakit'); ?>',
            data: {pendaftaran_id: pendaftaran_id, jeniskasuspenyakit_id: jeniskasuspenyakit_id},
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.list_kasus_penyakit').append(data.kasusPenyakit);
                $(obj).parents('td').find('.kasus_penyakit').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        return false;
    }

    function saveKasusPenyakit(obj, pendaftaran_id) {
        var jeniskasuspenyakit_id = $(obj).val();
        var pendaftaran_id = pendaftaran_id;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('saveKasusPenyakit'); ?>',
            data: {pendaftaran_id: pendaftaran_id, jeniskasuspenyakit_id: jeniskasuspenyakit_id},
            dataType: "json",
            success: function (data) {
                if (data.pesan == 'berhasil') {
                    myAlert('Data Kasus Penyakit berhasil di ubah');
                    $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $(this).serialize()});
                } else {
                    myAlert('Data Kasus Penyakit gagal di ubah');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>
