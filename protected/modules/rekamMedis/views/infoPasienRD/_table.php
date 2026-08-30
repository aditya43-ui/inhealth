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
                    
                }
            ),
            array(
                'header' => 'Nama Pasien/ Tanggal Lahir/Alamat/Lihat Berkas',
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
                    echo  CHtml::link(
                        '<i class="icon-form-lihat"></i> Lihat Berkas',
                        Yii::app()->controller->createUrl("/rawatDarurat/pemeriksaanPasienTRD", array("pendaftaran_id" => $data->pendaftaran_id, 'lihat' => 1)),
                        array(
                            "rel" => "tooltip",
                            "title" => "Klik untuk melihat berkas pasien",
                            "target" => "blank",
                        )
                    );
                },
            ),
            array(
                'header' => 'Verifikasi Diagnosa',
                'type' => 'raw',
                'value' => function ($data) {
                    $pasienMorbi = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id), 'pasienadmisi_id is null');
                    $namadiagnosa = '-';
                    if (!empty($pasienMorbi->diagnosa_id)) {
                        $diagnosa = DiagnosaM::model()->findByPk($pasienMorbi->diagnosa_id);
                        $namadiagnosa = $diagnosa->diagnosa_nama;
                    }

                    $iconVerif = CHtml::Link(
                        "<i class=icon-form-verifikasi></i>",
                        'javascript:cekValidasiVerifikasi(' .  $data->pendaftaran_id . ', "RD")',
                        array(
                            "class" => "",
                            // "target" => "iframeVerifikasiDiagnosa",
                            // "onclick" => "$(\"#dialogVerifikasiDiagnosa\").dialog(\"open\");",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Proses Verifikasi Diagnosa",
                        )
                    ) . "<hr>" . $namadiagnosa;

                    // mengambil data verifikasi diagnosa terbaru
                    $getDataVerifikasi = VerifikasidiagnosaT::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id], ['order' => 'tgl_verifikasi Desc', 'condition' => 'pasienadmisi_id is null']);
                    $infoVerif= '';
                    if(!empty($getDataVerifikasi)) {
                        $infoVerif = '<i class="icon-form-check"></i><br>' . $getDataVerifikasi->petugasverifikasi->namaLengkap . '<br><b>' . MyFormatter::formatDateTimeForUser($getDataVerifikasi->tgl_verifikasi) . '</b>';
                    }

                    return $iconVerif . '<br>' . $infoVerif;
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            array(
                'header' => 'Resume Medis',
                'type' => 'raw',
                'value' => '(($data->status_resume == false) && empty($data->status_resume)) ?  
                            CHtml::Link("<i class=\"icon-resumemedis\"></i>",Yii::app()->createUrl("rekamMedis/resumeMedis/index",array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
                            array("class"=>"", 
                                "target"=>"iframeResume",
                                "onclick"=>"$(\"#dialogResume\").dialog(\"open\");",
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk penginputan Resume Medis",
                            )) :  CHtml::Link("<i class=\"icon-resumekeperawatan\"></i>",Yii::app()->createUrl("rekamMedis/resumeMedis/index",array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
                            array("class"=>"", 
                                "target"=>"iframeResume",
                                "onclick"=>"$(\"#dialogResume\").dialog(\"open\");",
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk penginputan Resume Medis",
                            ))',
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
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
                        $data->asalrujukan_nama . "/<br>" . ((empty($r) || empty($r->rujukandari)) ? ($r->nama_perujuk ?? '-') : $r->rujukandari->namaperujuk)
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
                        return $data->CaraBayarPenjamin;
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
                            
            array(
                'header' => 'Dokter / Ruangan',
                'type' => 'raw',
                'value' => function ($data) {
                    echo  "<div style='width:120px;'>" . $data->gelardepan . " " . $data->nama_pegawai . " " . $data->gelarbelakang_nama . "</div>";
                    echo "<br>";
                    if (!empty($data->ruangan_nama) && ($data->statusperiksa == Params::STATUSPERIKSA_ANTRIAN)) {
                        echo $data->ruangan_nama;
                    } else {
                        echo $data->ruangan_nama;
                    }
                    echo "<br>";
                    
                },
            ), 
            array(
                'name' => 'keterangan_pendaftaran',
                'type' => 'raw',
                'value' => function ($data) {
                    $str = "";
                    if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                        $str = $data->keterangan_pendaftaran;
                    } else {
                        
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
            array(
                'header' => 'Status Periksa / <br> Check Pemeriksaan',
                'type' => 'raw',
            
                'value' => function ($data) {
                 
                    $str = Params::getWrStatusPeriksa($data->statusperiksa);

                    
                    if ($data->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
                        $str .= "<hr>";
                       
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
            [
                'header' => 'Cara Keluar / <br> Kondisi Keluar',
                'value' => function ($data) {
                    echo $data->carakeluar;
                    echo ' / <br>';
                    echo $data->kondisipulang;
                }
            ],
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