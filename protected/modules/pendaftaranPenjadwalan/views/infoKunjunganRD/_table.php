<?php 
$this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'PPInfoKunjungan-v',
        'dataProvider' => $modInfoKunjunganRDV->searchRD(),
        //        'filter'=>$modInfoKunjunganRDV,
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
                'header' => 'Tanggal Pendaftaran',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
            ),
            //                array(
            //                    'header'=>'No. Rekam Medis/<br>No. Pendaftaran',
            //                    'name'=>'no_pendaftaran',
            //                    'type'=>'raw',
            //                    'value'=>'(!empty($data->no_pendaftaran) ? CHtml::link("<i class=entypo-print></i> ".$data->no_pendaftaran, "javascript:print(\'$data->pendaftaran_id\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Print Lembar Poli")) : "-") . "<br>" . CHtml::link("<i class=icon-pencil-brown></i> ".$data->no_rekam_medik, Yii::app()->createUrl("pendaftaranPenjadwalan/InfoKunjunganRJ/ubahPasien",array("id"=>"$data->pasien_id", "menu"=>"RD")),array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Edit Data Pasien"))',
            //                    'htmlOptions'=>array('style'=>'text-align: left; width:120px')
            //                ),
            array(
                'header' => 'No. Pendaftaran',
                'name' => 'no_pendaftaran',
                'type' => 'raw',
                'value' => function ($data) {
                    $html = "";
                    if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                        $html .= $data->no_pendaftaran;
                    } else {
                        $html .= (!empty($data->no_pendaftaran) ?
                            CHtml::link("<i class=icon-form-print></i><br>" . $data->no_pendaftaran, "javascript:print(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Print Lembar Poli")) : "-");
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
                    $html .= CHtml::link("<i class=icon-form-print></i> General Consent", "javascript:printGC(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print DPJP"));
                    $html .= "</br>";
                    $html .= CHtml::link("<i class=icon-form-print></i> Stiker", "javascript:printStiker(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print Stiker"));
                    $html .= "<br>";
                    $html .= CHtml::link("<i class=icon-form-print></i> Casemix Penuh", "javascript:printCasemix(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print Casemix Penuh"));
                    $html .= "<br>";
                    $html .= CHtml::link("<i class=icon-form-print></i> Casemix Identitas", "javascript:printCasemixIden(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print Casemix"));
                    $html .= "<br>";
                    $html .= CHtml::link("<i class=icon-form-print></i> Kepala Les", "javascript:printKepalaLes(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print Kepala Les"));

                    return $html;
                },
                'htmlOptions' => array('style' => 'text-align: center;')
            ),
            array(
                'header' => 'No. Rekam Medik',
                'name' => 'no_rekam_medik',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align: center;'),
                'value' => function ($data) {
                    // if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                    // return $data->no_rekam_medik;
                    // } else {
                    return CHtml::link(
                        "<i class='icon-form-ubah'></i><br>" . $data->no_rekam_medik,
                        Yii::app()->createUrl("/pendaftaranPenjadwalan/InfoKunjunganRJ/ubahPasienAjax", array("pendaftaran_id" => $data->pendaftaran_id)),
                        array(
                            "class" => "",
                            "target" => "frameEditPasien",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Mengubah Data Pasien",
                            "onclick" => "$('#editPasien').dialog('open');return true;"
                        )
                    )
                        . "<br>" .
                        CHtml::link("<i class=icon-form-print></i> Gelang Dewasa", "javascript:printLabelGelang(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print gelang pasien Dewasa"))
                        . "<br>" .
                        CHtml::link("<i class=icon-form-print></i> Gelang Anak", "javascript:printLabelGelangAnak(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print gelang pasien Anak"))
                        . "<br>" .
                        CHtml::link("<i class=icon-form-print></i> Status", "javascript:printStatus(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print status pasien"))
                        . "<br>" .
                        CHtml::link("<i class=icon-form-print></i> Label", "javascript:printLabel(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print label pasien"))
                        . "</br>" .
                        CHtml::link("<i class=icon-form-print></i> Daftar DPJP", "javascript:printDPJP(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print daftar DPJP"));
                    // }
                }
            ), /*
        array(
            'header'=>'Nama Depan',
            'type'=>'raw',
            'value'=>'$data->namadepan',
        ), */
            array(
                'header' => 'Nama Pasien/ Tanggal Lahir/Alamat',
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
                    echo "<br>";
                    echo $data->alamat_pasien;
                    echo "<br>";
                    echo "<hr>";
                    // echo  CHtml::link(
                    //     '<i class="icon-form-lihat"></i> Lihat Berkas',
                    //     Yii::app()->controller->createUrl("/rawatDarurat/pemeriksaanPasienTRD", array("pendaftaran_id" => $data->pendaftaran_id, 'lihat' => 1)),
                    //     array(
                    //         "rel" => "tooltip",
                    //         "title" => "Klik untuk melihat berkas pasien",
                    //         "target" => "blank",
                    //     )
                    // );
                },
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

            //         $iconVerif = CHtml::Link(
            //             "<i class=icon-form-verifikasi></i>",
            //             Yii::app()->createUrl(Yii::app()->controller->module->id . "/verifikasiDiagnosa/index", array("id" => $data->pendaftaran_id, "menu" => "RD", "frame" => true)),
            //             array(
            //                 "class" => "",
            //                 "target" => "iframeVerifikasiDiagnosa",
            //                 "onclick" => "$(\"#dialogVerifikasiDiagnosa\").dialog(\"open\");",
            //                 "rel" => "tooltip",
            //                 "title" => "Klik untuk Proses Verifikasi Diagnosa",
            //             )
            //         ) . "<hr>" . $namadiagnosa;

            //         // mengambil data verifikasi diagnosa terbaru
            //         $getDataVerifikasi = VerifikasidiagnosaT::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id], ['order' => 'tgl_verifikasi Desc']);
            //         $infoVerif= '';
            //         if(!empty($getDataVerifikasi)) {
            //             $infoVerif = '<i class="icon-form-check"></i><br>' . $getDataVerifikasi->petugasverifikasi->namaLengkap . '<br><b>' . MyFormatter::formatDateTimeForUser($getDataVerifikasi->tgl_verifikasi) . '</b>';
            //         }

            //         return $iconVerif . '<br>' . $infoVerif;
            //     },
            //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            // ),
            // array(
            //     'header' => 'Resume Medis',
            //     'type' => 'raw',
            //     'value' => '(($data->status_resume == false) && empty($data->status_resume)) ?  
            //                 CHtml::Link("<i class=\"icon-resumemedis\"></i>",Yii::app()->createUrl("rekamMedis/resumeMedis/index",array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
            //                 array("class"=>"", 
            //                     "target"=>"iframeResume",
            //                     "onclick"=>"$(\"#dialogResume\").dialog(\"open\");",
            //                     "rel"=>"tooltip",
            //                     "title"=>"Klik untuk penginputan Resume Medis",
            //                 )) :  CHtml::Link("<i class=\"icon-resumekeperawatan\"></i>",Yii::app()->createUrl("rekamMedis/resumeMedis/index",array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
            //                 array("class"=>"", 
            //                     "target"=>"iframeResume",
            //                     "onclick"=>"$(\"#dialogResume\").dialog(\"open\");",
            //                     "rel"=>"tooltip",
            //                     "title"=>"Klik untuk penginputan Resume Medis",
            //                 ))',
            //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            // ),
            //'alamat_pasien',
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
                    return CHtml::Link(
                        $data->asalrujukan_nama . "/<br>" . ((empty($r) || empty($r->rujukandari)) ? ($r->nama_perujuk ?? '-') : $r->rujukandari->namaperujuk) . "<i class=icon-form-ubah></i>",
                        Yii::app()->createUrl("pendaftaranPenjadwalan/infoKunjunganRJ/ubahDataPerujuk", array("id" => $data->pendaftaran_id, "menu" => "RJ", "frame" => true)),
                        array(
                            "class" => "",
                            "onclick" => "$('#DialogPerujuk').dialog('open');loadFormPerujuk(this);return false;",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Mengubah Perujuk",
                        )
                    );
                },
            ),
            // array(
            //     'header'=>'P3 / Asuransi',
            //     'type'=>'raw',
            //     'value'=>'$data->namapemilik_asuransi',
            // ),
            array(
                'header' => 'Jenis Penjamin/<br>Penjamin',
                'type' => 'raw',
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
                                    "onclick" => "$('#carabayardialog').dialog('open');loadFormCaraBayar(this);return false;",
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk Mengubah Jenis Penjamin & Penjamin pasien",
                                )
                            ) : $data->CaraBayarPenjamin);
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
            // array(
            //     'name'=>'CaraBayar/Penjamin',
            //     'type'=>'raw',
            //     'value'=>'((!empty($data->CaraBayarPenjamin)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? CHtml::link("<i class=icon-pencil-brown></i> ".$data->CaraBayarPenjamin," ",array("onclick"=>"ubahCaraBayar(\'$data->nama_pasien\');listCaraBayar(\'$data->carabayar_id\');setIdPendaftaran(\'$data->pendaftaran_id\',\'$data->no_pendaftaran\');$(\'#carabayardialog\').dialog(\'open\');return false;",
            //                                                                                                                      "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Jenis Penjamin & Penjamin pasien")) : Params::STATUSPERIKSA_BATAL_PERIKSA) ',
            //     'htmlOptions'=>array(
            //         'style'=>'text-align: left',
            //         'class'=>'gawat'
            //     )
            // ),                         
            array(
                'header' => 'Dokter / Ruangan',
                'type' => 'raw',
                'value' => function ($data) {
                    echo  "<div style='width:120px;'>" . CHtml::link("<i class=icon-form-ubah></i> " . $data->gelardepan . " " . $data->nama_pegawai . " " . $data->gelarbelakang_nama, " ", array("onclick" => "ubahDokterPeriksa('$data->pendaftaran_id');$('#editDokterPeriksa').dialog('open');return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Mengubah Data Dokter Periksa")) . "</div>";
                    echo "<br>";
                    if (!empty($data->ruangan_nama) && ($data->statusperiksa == Params::STATUSPERIKSA_ANTRIAN)) {
                        echo $data->ruangan_nama;
                    } else {
                        echo $data->ruangan_nama;
                    }
                    echo "<br>";
                    CHtml::link("<i class=icon-form-ubah></i> " . $data->jeniskasuspenyakit_nama, " ", array("onclick" => "ubahKelompokPenyakit('$data->pendaftaran_id');$('#editKelPenyakit').dialog('open');return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Mengubah Data Kelompok Penyakit"));
                },
            ), /*
            array(
                'name'=>'Kelas Pelayanan',
                'type'=>'raw',
                'value'=>'"<div style=\'width:50px;\'>" . CHtml::link("<i class=icon-form-ubah></i>". $data->kelaspelayanan_nama," ",array("onclick"=>"ubahKelasPelayanan(\'$data->pendaftaran_id\');$(\'#editKelasPelayanan\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Data Kelas Pelayanan")) . "</div>"',
                'htmlOptions'=>array(
                    'style'=>'text-align:center;',
                    'class'=>'gawat'
                )
            ), */
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
            ), /*
            array(
        'header'=>'Verifikasi Diagnosa',
        'type'=>'raw',
        'value'=>''
            .'(isset($data->Morbiditas->pasienmorbiditas_id) ? "<div class=\"inap\" style=\"background-color:#33FF00; text-align: left\">" : "<div style=\"background-color:#FF0000; text-align: left\">")'
            .'.(CHtml::Link("<i class=icon-form-verifikasi></i> Verifikasi Diagnosa",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/verifikasiDiagnosa/index",array("id"=>$data->pendaftaran_id,"menu"=>"RD","frame"=>true)),
                        array("class"=>"", 
                            "target"=>"iframeVerifikasiDiagnosa",
                            "onclick"=>"$(\"#dialogVerifikasiDiagnosa\").dialog(\"open\");",
                            "rel"=>"tooltip",
                            "title"=>"Klik Verifikasi Diagnosa",
                )))."</div>"',  
            ),
            array(
            'header'=>'Pemeriksaan Fisik <br> & Anamnesa',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-periksa\"></i>",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.$anamnesa_link.'/indexAnamnesa",array("pendaftaran_id"=>$data->pendaftaran_id)),
                        array("class"=>"", 
                            "rel"=>"tooltip",
                            "title"=>"Klik Pemeriksaan Fisik & Anamnesa",
                ))',       
            'htmlOptions'=>array(
                    'style'=>'text-align: left',
            ),
            ), */
            //  array(
            //    'header'=>'Pemeriksaan Fisik <br> & Anamnesa',
            //    'type'=>'raw',
            //    'value'=>'CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.$anamnesa_link.'/indexAnamnesa",array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
            //                 array("class"=>"", 
            //                       "target"=>"iframePemeriksaanFisik",
            //                       "onclick"=>"$(\"#dialogFisikAnamnesa\").dialog(\"open\");",
            //                       "rel"=>"tooltip",
            //                       "title"=>"Klik Pemeriksaan Fisik & Anamnesa",
            //                 ))',          
            //    'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
            // ),  
            array(
                'header' => 'Status Periksa / <br> Check Pemeriksaan',
                'type' => 'raw',
                //                     'value'=>'$data->statusperiksa.CHtml::link("<i class=icon-pencil></i>","",array("href"=>"","rel"=>"tooltip","title"=>"Klik untuk Mengubah Status Periksa","onclick"=>"{buatSessionUbahStatus($data->pendaftaran_id);}return false;"))',
                'value' => function ($data) {
                    $t = TindakanpelayananT::model()->findByAttributes(array(
                        'pendaftaran_id' => $data->pendaftaran_id,
                    ), array(
                        'condition' => 'tindakansudahbayar_id is not null',
                    ));
                    $str = "";
                    // if (!empty($t)) $str .= Params::getWrStatusPeriksa($data->statusperiksa);
                    $str .= ((!empty($data->statusperiksa) && ($data->statusperiksa == Params::STATUSPERIKSA_ANTRIAN)) ? CHtml::link("<i class=entypo-cancel style='color:white'></i> " . $data->statusperiksa, "javascript:dialogBatalPeriksa('$data->pendaftaran_id','$data->statusperiksa','$data->nama_pasien');", array('class' => 'btn btn-primary btn-icon', "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik Membatalkan Pemeriksaan")) : Params::getWrStatusPeriksa($data->statusperiksa));

                    // $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
                    // if (($data->pasienpulang_id != 0) or ($data->carakeluar != "")) {
                    if ($data->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
                        $str .= "<hr>";
                        // $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$data->pendaftaran_id));
                        $str .= $data->carakeluar . "<br>" . CHtml::link("<i class='icon-form-sampah'></i>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/BatalRawatInap', array("pendaftaran_id" => $data->pendaftaran_id)), array("title" => "Klik untuk Batal Proses Tindak Lanjut Pasien", "target" => "iframeBatalRawatInap", "onclick" => "$('#dialogBatalRawatInap').dialog('open');", "rel" => "tooltip"));
                    }

                    if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_DIPERIKSA) {
                        $str .= "<hr>";
                        $str .= '<div class="small-container">' . CHtml::link(
                            '<icon class="icon-form-ri"></icon><br>Tindak Lanjut',
                            Yii::app()->createUrl("PasienPulang", array("pendaftaran_id" => $data->pendaftaran_id, "dialog" => true)),
                            array(
                                "target" => "iframePasienPulang",
                                //"onclick"=>"$('#dialogPasienPulang').dialog('open');",
                                "onclick" => "cekVerifikasiTindakLanjut(this,'" . $data->pendaftaran_id . "'); return false;",
                                "rel" => "tooltip",
                                "title" => "Klik untuk menambahkan tindak lanjut",
                            )
                        ) . '</div>';
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
                }, //'',
                'htmlOptions' => array(
                    'style' => 'text-align: center;',
                    'class' => 'status'
                )
            ),
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
                'name' => 'create_loginpemakai_id',
                'value' => function ($data) {
                    $lp = LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id);
                    return isset($lp->pegawai_id) ? $lp->pegawai->namaLengkap : '-';
                }
            ),
            array(
                'header' => 'Case Manager',
                'type' => 'raw',
                'value' => function ($data) {
                    $link = CHtml::link('<i class="icon-form-periksa"></i> ', Yii::app()->createUrl('rekamMedis/ManagerPelayananPasien/index', array("pendaftaran_id" => $data->pendaftaran_id, 'typeinstalasi' => 'RD')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Case Manager"));
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
    )); ?>