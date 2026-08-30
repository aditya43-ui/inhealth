<?php 
$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'PPInfoKunjungan-v',
        'dataProvider' => $modPPInfoKunjunganRJV->searchRJ(),
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-condensed',
        'rowCssClassExpression' => '($data->is_verifikasidiagnosa)?"tr_isadmin":""',
        'replaceUrl' => true,
        'columns' => array(
            array(
                'header' => 'No.',
                'value' => '($this->grid->dataProvider->pagination) ? 
                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                    : ($row+1)',
            ),
            array(
                'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                'type' => 'raw',
                'value' => function ($data) {
                    $html = "";
                    if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                        $html .= MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . $data->no_pendaftaran;
                    } else {
                        $html .= CHtml::link("<i class=icon-form-print></i>" . MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . "</Br>", "javascript:print(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk mencetak Status Pasien")) . "&nbsp;&nbsp;/<br>" . $data->no_pendaftaran;
                    }
                    $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                    if (!empty($pendaftaran) && $pendaftaran->isbacahakpasien == true) {
                        $html .= "<br/>";
                        $html .= CHtml::Link(
                            "<i class=icon-form-detail></i> <br/> Hak & Kewajiban",
                            Yii::app()->createUrl("pendaftaranPenjadwalan/infoKunjunganRJ/hakKewajiban", array("pendaftaran_id" => $data->pendaftaran_id)),
                            array(
                                "class" => "",
                                "target" => "iframeHakKewajiban",
                                "onclick" => "$(\"#dialogHakKewajiban\").dialog(\"open\");",
                                "rel" => "tooltip",
                                "title" => "Klik Lihat Hak & Kewajiban",
                            )
                        );
                    }
                    $html .= "</br>";
                    $html .= CHtml::link("<i class=icon-form-print></i> Kartu", "javascript:printKartu(" . $data->pasien_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print kartu pasien"));
                    $html .= "</br>";
                    $html .= CHtml::link("<i class=icon-form-print></i> Struk", "javascript:printStruk(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print struk"));
                    // $html .= "</br>";
                    // $html .= CHtml::link("<i class=icon-form-print></i> Status", "javascript:printStatus(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print status pasien"));
                    $html .= "</br>";
                    $html .= CHtml::link("<i class=icon-form-print></i> Label", "javascript:printLabel(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print label pasien"));
                    $html .= "</br>";
                    $html .= CHtml::link("<i class=icon-form-print></i> Stiker", "javascript:printStiker(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print stiker"));
                    $html .= "</br>";
                    

                    return $html;
                },
                'htmlOptions' => array(
                    'style' => 'text-align: center;',
                )
            ),
            /*
                array(
                    'header'=>'No. Pendaftaran',
                    'name'=>'no_pendaftaran',
                    'type'=>'raw',
                    'value'=>'(!empty($data->no_pendaftaran) ? CHtml::link("<i class=icon-form-print></i> ".$data->no_pendaftaran, "javascript:print(\'$data->pendaftaran_id\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk mencetak Status Pasien")) : "-")',
                    'htmlOptions'=>array('style'=>'text-align: center;')
                ), */
            array(
                'header' => 'No. Rekam Medik',
                'name' => 'no_rm',
                'type' => 'raw',
                'value' => function ($data) {
                    if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                        return $data->no_rekam_medik;
                    } else {
                        return CHtml::link(
                            "<i class='icon-form-ubah'></i><br>" . $data->no_rekam_medik,
                            Yii::app()->createUrl("/pendaftaranPenjadwalan/InfoKunjunganRJ/ubahPasienAjax", array("pendaftaran_id" => $data->pendaftaran_id)),
                            array(
                                "class" => "",
                                "target" => "frameEditPasien",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Mengubah Data Pasien",
                                "onclick" => "$('#editPasien').dialog('open');"
                            )
                        )

                            . "<br>" .
                            CHtml::link("<i class=icon-form-print></i> Klaim Rawat Jalan", "javascript:printKlaim(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print Form Klaim pasien"))
                            . "<br>" .
                            CHtml::link("<i class=icon-form-print></i> General Consent", "javascript:printGC(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print DPJP"))
                            . "<br>" .
                            CHtml::link("<i class=icon-form-print></i> Casemix Penuh", "javascript:printCasemix(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print Casemix"))
                            . "<br>" .
                            CHtml::link("<i class=icon-form-print></i> Casemix Identitas", "javascript:printCasemixIden(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print Casemix"))
                            . "<br>" .
                            CHtml::link("<i class=icon-form-print></i> Kepala Les", "javascript:printKepalaLes(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print Casemix"));
                    }
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;')
            ),/*
                array(
                    'header'=>'Nama Depan',
                    'type'=>'raw',
                    'value'=>'$data->namadepan'
                ), */
            array(
                'header' => 'Nama Pasien/Tanggal Lahir/Jenis Kelamin/Alamat',
                'type' => 'raw',
                'value' => function ($data) {
                    echo  CHtml::link(
                        $data->namadepan . $data->nama_pasien . '<i class="icon-form-lihat"></i>',
                        Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/getRiwayatPasien", array("id" => $data->pasien_id)),
                        array(
                            "rel" => "tooltip",
                            "title" => "Klik untuk melihat riwayat pemeriksaan pasien",
                            "target" => "frameRiwayatPasien",
                            "onclick" => "$('#dialogRiwayatPasien').dialog('open');"
                        )
                    );
                    echo "<br>";
                    echo MyFormatter::formatDateTimeForUser($data->tanggal_lahir);
                    echo "<hr>";
                    if (!empty($data->jeniskelamin) && ($data->statusperiksa != Params::STATUSPERIKSA_SUDAH_PULANG)) {
                        echo CHtml::link("<i class=icon-form-ubah></i> " . $data->jeniskelamin, " ", array("onclick" => "ubahJenisKelamin('$data->no_rekam_medik');$('#editJenisKelamin').dialog('open');return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Mengubah Data Jenis Kelamin Pasien"));
                    } else {
                        echo $data->jeniskelamin;
                    }
                    echo "<hr>";
                    $criteria = new CDbCriteria;
                    if (!empty($data->pendaftaran_id)) {
                        $criteria->addCondition("pendaftaran_id = " . $data->pendaftaran_id);
                    }
                    $criteria->addCondition('diagnosaicdix_id IS NULL');
                    $model = PPPasienMorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
                    echo $data->alamat_pasien;
                    echo "<hr>";
                    // echo  CHtml::link(
                    //     '<i class="icon-form-lihat"></i> Lihat Berkas',
                    //     Yii::app()->controller->createUrl("/rawatJalan/pemeriksaanPasien", array("pendaftaran_id" => $data->pendaftaran_id, 'lihat' => 1)),
                    //     array(
                    //         "rel" => "tooltip",
                    //         "title" => "Klik untuk melihat berkas pasien",
                    //         "target" => "blank",
                    //     )
                    // );
                    // var_dump($model);
                }
            ),
            // array(
            //     'header' => 'Verifikasi Diagnosa',
            //     'type' => 'raw',
            //     'value' => function ($data) {
            //         $pasienMorbi = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
            //         $namadiagnosa = '-';
            //         if (!empty($pasienMorbi->diagnosa_id)) {
            //             $diagnosa = DiagnosaM::model()->findByPk($pasienMorbi->diagnosa_id);
            //             $namadiagnosa = $diagnosa->diagnosa_nama;
            //         }
            //         return CHtml::Link(
            //             "<i class=icon-form-verifikasi></i>",
            //             Yii::app()->createUrl(Yii::app()->controller->module->id . "/verifikasiDiagnosa/index", array("id" => $data->pendaftaran_id, "menu" => "RJ", "frame" => true)),
            //             array(
            //                 "class" => "",
            //                 "target" => "iframeVerifikasiDiagnosa",
            //                 "onclick" => "$(\"#dialogVerifikasiDiagnosa\").dialog(\"open\");",
            //                 "rel" => "tooltip",
            //                 "title" => "Klik untuk Proses Verifikasi Diagnosa",
            //             )
            //         ) . "<hr>" . $namadiagnosa;
            //     },
            //     // '
            //     //     (isset($data->Morbiditas->pasienmorbiditas_id) ? "<div>" : "<div>")'
            //     //     . '.CHtml::Link("<i class=icon-form-verifikasi></i>",Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/verifikasiDiagnosa/index",array("id"=>$data->pendaftaran_id,"menu"=>"RJ","frame"=>true)),
            //     //     array("class"=>"", 
            //     //         "target"=>"iframeVerifikasiDiagnosa",
            //     //         "onclick"=>"$(\"#dialogVerifikasiDiagnosa\").dialog(\"open\");",
            //     //         "rel"=>"tooltip",
            //     //         "title"=>"Klik untuk Proses Verifikasi Diagnosa",
            //     //     ))',
            //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            // ),
            // array(
            //     'header' => 'Resume Medis',
            //     'type' => 'raw',
            //     'value' => function ($data) {

            //         $resume = (($data->status_resume == false) && empty($data->status_resume)) ?  
            //                 CHtml::Link("<i class=\"icon-resumemedis\" style=\"margin: 6px;\"></i>",Yii::app()->createUrl("rekamMedis/resumeMedis/index",array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
            //                 array("class"=>"", 
            //                     "target"=>"iframeResume",
            //                     "onclick"=>"$(\"#dialogResume\").dialog(\"open\");",
            //                     "rel"=>"tooltip",
            //                     "title"=>"Klik untuk penginputan Resume Medis",
            //                 )) . "<br>Resume Medis" :  CHtml::Link("<i class=\"icon-resumekeperawatan\" style=\"margin: 6px;\"></i>",Yii::app()->createUrl("rekamMedis/resumeMedis/index",array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
            //                 array("class"=>"", 
            //                     "target"=>"iframeResume",
            //                     "onclick"=>"$(\"#dialogResume\").dialog(\"open\");",
            //                     "rel"=>"tooltip",
            //                     "title"=>"Klik untuk penginputan Resume Medis",
            //                 )) . "<br>Resume Medis";

            //         $checklist = CHtml::Link(
            //             "<i class=icon-form-verifikasi></i>",
            //             Yii::app()->createUrl(Yii::app()->controller->module->id . "/resumeMedis/checklistBerkas", array("pendaftaran_id" => $data->pendaftaran_id, "frame" => true)),
            //             array(
            //                 "class" => "",
            //                 "target" => "iframeChecklistBerkas",
            //                 "onclick" => "$(\"#dialogChecklistBerkas\").dialog(\"open\");",
            //                 "rel" => "tooltip",
            //                 "title" => "Klik untuk Checklist Kelengkapan Berkas",
            //             )
            //         ) . "Checklist Berkas";



            //         return $resume . "<hr>";

            //     } ,
            //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            // ),
            array(
                'name' => 'Jenis Kasus Penyakit',
                'type' => 'raw',
                'value' => '((!empty($data->jeniskasuspenyakit_nama)&& ($data->statusperiksa!=Params::STATUSPERIKSA_SUDAH_PULANG)) ? CHtml::link("<i class=icon-form-ubah></i> ".$data->jeniskasuspenyakit_nama," ",array("onclick"=>"ubahKelompokPenyakit(\'$data->pendaftaran_id\');$(\'#editKelPenyakit\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Data Kelompok Penyakit")): $data->jeniskasuspenyakit_nama)',
                'htmlOptions' => array(
                    'style' => 'text-align: left'
                    // 'class'=>'rajal'
                )
            ),
            array(
                'header' => 'Cara Masuk',
                'type' => 'raw',
                'value' => '$data->statusmasuk',
            ),
            array(
                'header' => 'Perujuk',
                'type' => 'raw',
                'value' => function ($data) {
                    $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                    $r = RujukanT::model()->findByPk($p->rujukan_id);
                    // return CHtml::Link(
                    //     $data->asalrujukan_nama . "/<br>" . ((empty($r) || empty($r->rujukandari)) ? ($r->nama_perujuk ?? '-') : $r->rujukandari->namaperujuk) . "<i class=icon-form-ubah></i>",
                    //     Yii::app()->createUrl("pendaftaranPenjadwalan/infoKunjunganRJ/ubahDataPerujuk", array("id" => $data->pendaftaran_id, "menu" => "RJ", "frame" => true)),
                    //     array(
                    //         "class" => "",
                    //         "onclick" => "$('#DialogPerujuk').dialog('open');loadFormPerujuk(this);return false;",
                    //         "rel" => "tooltip",
                    //         "title" => "Klik untuk Mengubah Perujuk",
                    //     )
                    // );
                },
            ),
            array(
                'name' => 'Jenis Penjamin/Penjamin',
                'type' => 'raw',
                // 'value'=>'((!empty($data->CaraBayarPenjamin)&&($data->statusperiksa!=Params::STATUSPERIKSA_SUDAH_PULANG)) ? 
                // CHtml::link("<i class=icon-pencil-brown></i> ".$data->CaraBayarPenjamin," ",
                // array("onclick"=>"ubahCaraBayar(\'$data->nama_pasien\');
                // listCaraBayar(\'$data->carabayar_id\');
                // setIdPendaftaran(\'$data->pendaftaran_id\',\'$data->no_pendaftaran\');
                // $(\'#carabayardialog\').dialog(\'open\');return false;",
                // "rel"=>"tooltip", "title"=>"Klik untuk Mengubah Jenis Penjamin & Penjamin pasien")) : $data->CaraBayarPenjamin) ',
                'value' => function ($data) {
                    if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                        return $data->CaraBayarPenjamin;
                    } else {
                        return ((!empty($data->CaraBayarPenjamin) && ($data->statusperiksa != Params::STATUSPERIKSA_BATAL_PERIKSA)) ?
                            CHtml::Link(
                                "<i class=icon-form-ubah></i>" . $data->CaraBayarPenjamin,
                                Yii::app()->createUrl("pendaftaranPenjadwalan/infoKunjunganRJ/ubahCaraBayar", array("id" => $data->pendaftaran_id, "menu" => "RJ", "frame" => true)),
                                array(
                                    "class" => "",
                                    "onclick" => "validasiDiagnosa(" . $data->pendaftaran_id . ", 2); loadFormCaraBayar(this);return false;",
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk Mengubah Jenis Penjamin & Penjamin pasien",
                                )
                            ) : $data->CaraBayarPenjamin);
                        // return $data->CaraBayarPenjamin;
                    }
                },
                'htmlOptions' => array(
                    'style' => 'text-align: left;',
                    'class' => 'inap'
                )
            ),
            array(
                'header' => 'Status Konfirmasi',
                'type' => 'raw',
                'value' => '($data->status_konfirmasi == "" ) ? "-" : $data->status_konfirmasi',
            ),
            //  array(
            //    'header'=>'P3 / Asuransi',
            //    'type'=>'raw',
            //    'value'=>'$data->namapemilik_asuransi',
            // ),
            // array(
            // 'name'=>'CaraBayar/Penjamin',
            // 'type'=>'raw',
            // 'value'=>'((!empty($data->CaraBayarPenjamin)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? 
            // CHtml::Link("<i class=icon-pencil></i>$data->CaraBayarPenjamin",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/infoKunjunganRJ/ubahCaraBayar",array("id"=>$data->pendaftaran_id)),
            // array("class"=>"", 
            // "target"=>"iframeUbahCaraBayar",
            // "onclick"=>"$(\'#carabayardialog\').dialog(\'open\');",
            // "rel"=>"tooltip",
            // "title"=>"Klik untuk Mengubah Jenis Penjamin & Penjamin pasien",
            // )): $data->CaraBayarPenjamin)',
            // 'htmlOptions'=>array(
            // 'style'=>'text-align: left'
            // //'class'=>'rajal'
            //
            // )
            //),
            array(
                'name' => 'Poliklinik/<br>Nama Dokter',
                'type' => 'raw',
                'value' => '((!empty($data->ruangan_nama)&&($data->statusperiksa==Params::STATUSPERIKSA_ANTRIAN)) ? CHtml::link("<i class=icon-form-ubah></i> ".$data->ruangan_nama,"javascript:gantiPoli(\'$data->pendaftaran_id\',\'$data->ruangan_id\',\'$data->instalasi_id\',\'$data->pasien_id\',\'$data->nama_pasien\',\'$data->jeniskasuspenyakit_id\',\'$data->pegawai_id\',\'$data->kelaspelayanan_id\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Poliklinik")) : $data->ruangan_nama)."<br>".((!empty($data->nama_pegawai)&& ($data->statusperiksa!=Params::STATUSPERIKSA_SUDAH_PULANG)) ? CHtml::link("<i class=icon-form-ubah></i> ". $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama," ",array("onclick"=>"ubahDokterPeriksa(\'$data->pendaftaran_id\');$(\'#editDokterPeriksa\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Data Dokter Periksa")) : $data->nama_pegawai)',
                'htmlOptions' => array(
                    'style' => ''
                    // 'class'=>'rajal'
                )
            ), /*
                array(
                'name'=>'Kelas Pelayanan ',
                'type'=>'raw',
                'value'=>'"<div style=\'width:50px;\'>" . ((!empty($data->kelaspelayanan_nama)&& ($data->statusperiksa!=Params::STATUSPERIKSA_SUDAH_PULANG)) ? CHtml::link("<i class=icon-form-ubah></i>". $data->kelaspelayanan_nama," ",array("onclick"=>"ubahKelasPelayanan(\'$data->pendaftaran_id\');$(\'#editKelasPelayanan\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Data Kelas Pelayanan")) : $data->kelaspelayanan_nama) . "</div>"',
                'htmlOptions'=>array(
                    'style'=>'text-align:center;'
                    // 'class'=>'rajal'
                )
                ),
                *
                array(
                'header'=>'Poliklinik',
                'name'=>'ruangan_nama',
                'type'=>'raw',
                'value'=>'',
                'htmlOptions'=>array('style'=>'text-align: left')
                ),
                * 
                */
            array(
                'header' => 'Status Periksa/<br/>Pembuatan SRK/<br/>Check Pemeriksaan',
                'name' => 'statusperiksa',
                'type' => 'raw',
                // 'value'=>'$data->statusperiksa.CHtml::link("<i class=icon-pencil></i>","",array("href"=>"","rel"=>"tooltip","title"=>"Klik untuk Mengubah Status Periksa","onclick"=>"{buatSessionUbahStatus($data->pendaftaran_id);}return false;"))',
                'value' => function ($data) {
                    $t = TindakanpelayananT::model()->findByAttributes(array(
                        'pendaftaran_id' => $data->pendaftaran_id,
                    ), array(
                        'condition' => 'tindakansudahbayar_id is not null',
                    ));
                    $o = ObatalkespasienT::model()->findByAttributes(array(
                        'pendaftaran_id' => $data->pendaftaran_id,
                    ), array(
                        'condition' => 'oasudahbayar_id is not null',
                    ));

                    $str = "";

                    // if (!empty($t) || !empty($o)) $str .= Params::getWrStatusPeriksa($data->statusperiksa);
                    $str .= ((!empty($data->statusperiksa) && ($data->statusperiksa == Params::STATUSPERIKSA_ANTRIAN)) ? CHtml::link("<i class=entypo-cancel style='color:white'></i> " . $data->statusperiksa, "javascript:dialogBatalPeriksa(" . $data->pendaftaran_id . ",'" . $data->statusperiksa . "','" . $data->nama_pasien . "');", array('class' => 'btn btn-primary btn-icon', "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik Membatalkan Pemeriksaan")) : Params::getWrStatusPeriksa($data->statusperiksa));
                    $str .= '<br>';
                    $str .= CHtml::link(
                        '<i class="icon-form-rkontrol"></i> ',
                        Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/RencanaKontrolPasienRJ", array("pendaftaran_id" => $data->pendaftaran_id)),
                        array("title" => "Klik untuk Rencana Kontrol Pasien", "target" => "iframeRencanaKontrol", "onclick" => '$("#dialogRencanaKontrol").dialog("open");', "rel" => "tooltip")
                    );

                    $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));

                    if (($data->pasienpulang_id != 0)) {
                        $str .= "</br>";
                        $str .= "<hr>";
                        $str .= "DIRAWAT INAP";
                        $str .= "</br>";
                        // $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$data->pendaftaran_id));
                        if (!empty($admisi)) {
                            $kamar = empty($admisi->kamarruangan_id) ? "" : ($admisi->kamarruangan->kamarruangan_nokamar . "<br>" . $admisi->kamarruangan->kamarruangan_nobed);
                            $ruangan = empty($admisi->ruangan_id) ? "" : $admisi->ruangan->ruangan_nama;

                            $str .= $ruangan . "</br>" . $kamar;
                        } else {
                            $str .= CHtml::link("<i class='icon-form-sampah'></i>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/BatalRawatInap', array("pendaftaran_id" => $data->pendaftaran_id)), array("title" => "Klik untuk Batal Proses Rawat Inap", "target" => "iframeBatalRawatInap", "onclick" => "$('#dialogBatalRawatInap').dialog('open');", "rel" => "tooltip"));

                            // $pemPel = PembayaranpelayananT::model()->find("pendaftaran_id = '" . $data->pendaftaran_id . "' ");
                            // if (empty($pemPel)) {
                            //     $str .= CHtml::link("<i class='icon-form-sampah'></i>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/BatalRawatInap', array("pendaftaran_id" => $data->pendaftaran_id)), array("title" => "Klik untuk Batal Proses Rawat Inap", "target" => "iframeBatalRawatInap", "onclick" => "$('#dialogBatalRawatInap').dialog('open');", "rel" => "tooltip"));
                            // } else {
                            //     $str .= CHtml::link("<i class='icon-form-sampah'></i>", 'javascript:;', array("title" => "Klik untuk Batal Proses Tindak Lanjut Pasien", "onclick" => "alert('Maaf, Pembayaran Pada Pasien ini Belum Dibatalkan')", "rel" => "tooltip"));
                            // }
                        }
                    }
                    if ($data->is_anamnesa) {
                        $str .=  "</br>" . "<i class='icon-form-check'></i>Anamnesa";
                    }
                    if ($data->is_periksafisik) {
                        $str .=  "</br>" . "<i class='icon-form-check'></i>Periksa Fisik";
                    }
                    if ($data->is_diagnosa) {
                        $str .=  "</br>" . "<i class='icon-form-check'></i>Diagnosa";
                    }
                    if ($data->is_tindakan) {
                        $str .=  "</br>" . "<i class='icon-form-check'></i>Tindakan";
                    }

                    return $str;
                },
                'htmlOptions' => array(
                    'style' => 'text-align: center;',
                    'class' => 'status'
                )
            ),
            array(
                'name' => 'keterangan_pendaftaran',
                'type' => 'raw',
                'value' => function ($data) {
                    $str = "";
                    if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                        $str = $data->keterangan_pendaftaran;
                    } else {
                        $str = "<div style='width:100px;'>" . CHtml::link("<i class=icon-form-ubah></i>" . $data->keterangan_pendaftaran, " ", array("onclick" => "ubahKeterangan(" . $data->pendaftaran_id . ");$('#editKeterangan').dialog('open');return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Mengubah Keterangan Pendaftaran")) . "</div>";
                    }
                    $str .= "<br/>" . CHtml::link('<i class="icon-form-detail"></i><br/>Riwayat Vaksinasi/<br/>Imunisasi', Yii::app()->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/updateRiwayatVaksinasi', array(
                        'pendaftaran_id' => $data->pendaftaran_id,
                    )), array(
                        'target' => 'frameRiwayatVaksinasi',
                        'onclick' => "$('#dialogRiwayatVaksinasi').dialog('open');",
                    ));
                    return $str;
                },
                'htmlOptions' => array(
                    'style' => 'text-align: center',
                )
            ),
            //                array(
            //                   'header'=>'Verifikasi Diagnosa',
            //                   'type'=>'raw',
            //                   'value'=>'CHtml::Link("<i class=icon-pencil></i> Verifikasi Diagnosa",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/verifikasiDiagnosa/index",array("id"=>$data->pendaftaran_id,"menu"=>"RJ","frame"=>true)),
            //                            array("class"=>"", 
            //                                  "target"=>"iframeVerifikasiDiagnosa",
            //                                  "onclick"=>"$(\"#dialogVerifikasiDiagnosa\").dialog(\"open\");",
            //                                  "rel"=>"tooltip",
            //                                  "title"=>"Klik Verifikasi Diagnosa",
            //                    ))',
            //                    
            //                       'htmlOptions'=>array(
            //                       'style'=>'text-align: left',
            ////                       'class'=>'merah',
            //                     
            //                   )
            //                ),
            /*
                array(
                   'header'=>'Verifikasi Diagnosa',
                   'type'=>'raw',
                   'value'=>''
                    . '(isset($data->Morbiditas->pasienmorbiditas_id) ? "<div style=\"background-color:#33FF00;\">" : "<div style=\"background-color:#FF0000;\">")'
                    . '.CHtml::Link("<i class=icon-form-verifikasi></i> Verifikasi Diagnosa",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/verifikasiDiagnosa/index",array("id"=>$data->pendaftaran_id,"menu"=>"RJ","frame"=>true)),
                            array("class"=>"", 
                                  "target"=>"iframeVerifikasiDiagnosa",
                                  "onclick"=>"$(\"#dialogVerifikasiDiagnosa\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik Verifikasi Diagnosa",
                    ))."</div>"',
                       'htmlOptions'=>array(
                       'style'=>'text-align: left', 
                   )
                ),
                array(
                   'header'=>'Pemeriksaan Fisik <br> & Anamnesa',
                   'type'=>'raw',
                   'value'=>'CHtml::Link("<i class=\"icon-form-periksa\"></i>",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.$anamnesa_link.'/index",array("pendaftaran_id"=>$data->pendaftaran_id)),
                                array("class"=>"", 
                                      "rel"=>"tooltip",
                                      "title"=>"Klik Pemeriksaan Fisik & Anamnesa",
                                ))',          
                   'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
                ),  
                 * */
            //                array(
            //                   'name'=>'statusperiksa',
            //                   'type'=>'raw',
            //                     'value'=>'$data->statusperiksa.CHtml::link("<i class=icon-pencil></i>","",array("href"=>"","rel"=>"tooltip","title"=>"Klik untuk Mengubah Status Periksa","onclick"=>"{buatSessionUbahStatus($data->pendaftaran_id);}return false;"))',
            ////                   'value'=>'((!empty($data->statusperiksa)&& ($data->statusperiksa==Params::STATUSPERIKSA_ANTRIAN)) ? CHtml::link("<i class=icon-remove-sign></i> ".$data->statusperiksa, "javascript:dialogBatalPeriksa(\'$data->pendaftaran_id\',\'$data->statusperiksa\',\'$data->nama_pasien\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Membatalkan Pemeriksaan")) : $data->statusperiksa) ',
            //                   'htmlOptions'=>array(
            //                       'style'=>'text-align: left',
            //                       'class'=>'status'
            //                   )
            //                ),
            //                array(
            //					'name'=>'statusperiksa',
            //					'type'=>'raw',
            //					'value'=>'$data->statusperiksa',
            //					'htmlOptions'=>array(
            //						'style'=>'text-align: left',
            //						'class'=>'status'
            //					)
            //				),
            array(
                'header' => 'Petugas Loket',
                'type' => 'raw',
                'value' => function ($data) {
                    $lp = LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id);
                    return empty($lp->pegawai_id) ? $lp->nama_pemakai : $lp->pegawai->nama_pegawai;
                }
            ),
            array(
                'header' => 'Case Manager',
                'type' => 'raw',
                'value' => function ($data) {
                    $link = CHtml::link('<i class="icon-form-periksa"></i> ', Yii::app()->createUrl('rekamMedis/ManagerPelayananPasien/index', array("pendaftaran_id" => $data->pendaftaran_id, 'typeinstalasi' => 'RJ')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Case Manager"));
                    return $link;
                },
                'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                'visible' => ((Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_REKAM_MEDIS) ? true : false)
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                disableLink();
            }',
    )
);
?>