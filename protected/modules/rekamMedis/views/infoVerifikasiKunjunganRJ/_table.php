
<?php
Yii::import('pendaftaranPenjadwalan.models.*');
    $this->widget(
        'ext.bootstrap.widgets.BootGridView',
        array(
            'id' => 'PPInfoKunjungan-v',
            'dataProvider' => $modInfoVerifikasiKunjuganRJ->searchRJ(),
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
                                CHtml::link("<i class=icon-form-print></i> Casemix Identitas", "javascript:printCasemixIden(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print Casemix"));
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
                    'header' => 'Nama Pasien/Tanggal Lahir/Jenis Kelamin/Alamat/Lihat Berkas',
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
                        echo  CHtml::link(
                            '<i class="icon-form-lihat"></i> Lihat Berkas',
                            Yii::app()->controller->createUrl("/rawatJalan/pemeriksaanPasien", array("pendaftaran_id" => $data->pendaftaran_id, 'lihat' => 1)),
                            array(
                                "rel" => "tooltip",
                                "title" => "Klik untuk melihat berkas pasien",
                                "target" => "blank",
                            )
                        );
                        // var_dump($model);
                    }
                ),
                array(
                    'header' => 'Verifikasi Diagnosa',
                    'type' => 'raw',
                    'value' => function ($data) {
                        $pasienMorbi = PPPasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id), 'pasienadmisi_id is null');
                        $namadiagnosa = '-';
                        if (!empty($pasienMorbi->diagnosa_id)) {
                            $diagnosa = DiagnosaM::model()->findByPk($pasienMorbi->diagnosa_id);
                            $namadiagnosa = $diagnosa->diagnosa_nama;
                        }

                        $iconVerif = CHtml::Link(
                            "<i class=icon-form-verifikasi></i>",
                            'javascript:cekValidasiVerifikasi(' .  $data->pendaftaran_id . ', "RJ")',
                            array(
                                "class" => "",
                                // "target" => "iframeVerifikasiDiagnosa",
                                // "onclick" => "$(\"#dialogVerifikasiDiagnosa\").dialog(\"open\");",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Proses Verifikasi Diagnosa",
                            )
                        ) . "<hr>" . $namadiagnosa;
                        
                        // mengambil data verifikasi diagnosa terbaru
                        $getDataVerifikasi = VerifikasidiagnosaT::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id], ['condition' => 'pasienadmisi_id is null', 'order' => 'tgl_verifikasi Desc',]);
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
                    'value' => function ($data) {

                        $resume = (($data->status_resume == false) && empty($data->status_resume)) ?  
                                CHtml::Link("<i class=\"icon-resumemedis\" style=\"margin: 6px;\"></i>",Yii::app()->createUrl("rekamMedis/resumeMedis/index",array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
                                array("class"=>"", 
                                    "target"=>"iframeResume",
                                    "onclick"=>"$(\"#dialogResume\").dialog(\"open\");",
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk penginputan Resume Medis",
                                )) . "<br>Resume Medis" :  CHtml::Link("<i class=\"icon-resumekeperawatan\" style=\"margin: 6px;\"></i>",Yii::app()->createUrl("rekamMedis/resumeMedis/index",array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
                                array("class"=>"", 
                                    "target"=>"iframeResume",
                                    "onclick"=>"$(\"#dialogResume\").dialog(\"open\");",
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk penginputan Resume Medis",
                                )) . "<br>Resume Medis";

                        // fitur checklis berkas ini di hide, dan di pindah di menu verifikasi rawat inap
                        $checklist = CHtml::Link(
                            "<i class=icon-form-verifikasi></i>",
                            Yii::app()->createUrl(Yii::app()->controller->module->id . "/resumeMedis/checklistBerkas", array("pendaftaran_id" => $data->pendaftaran_id, "frame" => true)),
                            array(
                                "class" => "",
                                "target" => "iframeChecklistBerkas",
                                "onclick" => "$(\"#dialogChecklistBerkas\").dialog(\"open\");",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Checklist Kelengkapan Berkas",
                            )
                        ) . "Checklist Berkas";



                        return $resume . "<hr>";

                    } ,
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                ),
                array(
                    'name' => 'Jenis Kasus Penyakit',
                    'type' => 'raw',
                    'value' => '$data->jeniskasuspenyakit_nama',
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
                        
                    },
                ),
                array(
                    'name' => 'Jenis Penjamin/Penjamin',
                    'type' => 'raw',
                    
                    'value' => function ($data) {
                        if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                            return $data->CaraBayarPenjamin;
                        } else {
                            return ((!empty($data->CaraBayarPenjamin) && ($data->statusperiksa != Params::STATUSPERIKSA_BATAL_PERIKSA)) ?
                            $data->CaraBayarPenjamin : $data->CaraBayarPenjamin);
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
                
                array(
                    'name' => 'Poliklinik/<br>Nama Dokter/<br>Tracer Konsultasi',
                    'type' => 'raw',
                    'value' => '((!empty($data->ruangan_nama)&&($data->statusperiksa==Params::STATUSPERIKSA_ANTRIAN)) ? CHtml::link("<i class=icon-form-ubah></i> ".$data->ruangan_nama,"javascript:gantiPoli(\'$data->pendaftaran_id\',\'$data->ruangan_id\',\'$data->instalasi_id\',\'$data->pasien_id\',\'$data->nama_pasien\',\'$data->jeniskasuspenyakit_id\',\'$data->pegawai_id\',\'$data->kelaspelayanan_id\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Poliklinik")) : $data->ruangan_nama)."<br><hr>".((!empty($data->nama_pegawai)&& ($data->statusperiksa!=Params::STATUSPERIKSA_SUDAH_PULANG)) ? $data->nama_pegawai : $data->nama_pegawai)."<br>"."<hr><br>". $data->tracer_konsul',
                    'htmlOptions' => array(
                        'style' => ''
                        // 'class'=>'rajal'
                    )
                ), 
                array(
                    'header' => 'Status Periksa/<br/>Pembuatan SRK/<br/>Check Pemeriksaan',
                    'name' => 'statusperiksa',
                    'type' => 'raw',
                    
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

                        $str = Params::getWrStatusPeriksa($data->statusperiksa);


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
                [
                    'header' => 'Cara Keluar / <br> Kondisi Keluar',
                    'value' => function ($data) {
                        echo $data->carakeluar_nama;
                        echo ' / <br>';
                        echo $data->kondisikeluar_nama;
                    }
                ],
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