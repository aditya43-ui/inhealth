<?php 
$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'PPInfoKunjungan-v',
        'dataProvider' => $modPPInfoKunjunganRIV->searchRI(),
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
                'name' => 'tgl_pendaftaran',
                'type' => 'raw',
                'value' => function ($data) {
                    $html = "";
                    if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                        $html .= $data->no_pendaftaran;
                    } else {
                        $html .= (!empty($data->no_pendaftaran) ? CHtml::link("<i class=icon-form-print></i><br>" . MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran), "javascript:print(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Print Lembar Poli")) . "/<br>" . $data->no_pendaftaran : "-");
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
                    $html .= CHtml::link("<i class=icon-form-print></i> Akad Ijarah", "javascript:setAkad(" . $data->pasienadmisi_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print akad ijarah"));
                    // $html .= "</br>";
                    // $html .= CHtml::link("<i class=icon-form-print></i> Formulir Penetapan DPJP", "javascript:setFormulirPenetapan(" . $data->pasienadmisi_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print akad ijarah"));
                    $html .= "</br>";
                    $html .= CHtml::link("<i class=icon-form-print></i><br>Formulir Penetapan DPJP", "javascript:printAllDPJP(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print akad ijarah"));
                    $html .= "</br>";
                    $html .= CHtml::link("<i class=icon-form-print></i> RM1", "javascript:printRM1(" . $data->pasienadmisi_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print RM1"));
                    // $html .= "</br>";
                    // $html .= CHtml::link("<i class=icon-form-print></i> DPJP", "javascript:setSuratPeryataan(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print DPJP"));
                    $html .= "</br>";
                    $html .= CHtml::link("<i class=icon-form-print></i> General Consent", "javascript:printGC(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print DPJP"));
                    $html .= "</br>";
                    $html .= CHtml::link("<i class=icon-form-print></i> Stiker", "javascript:printStiker(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print Stiker"));
                    $html .= "<br>";
                    $html .= CHtml::link("<i class=icon-form-print></i> Casemix Penuh", "javascript:printCasemix(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print Casemix Penuh"));
                    $html .= "<br>";
                    $html .= CHtml::link("<i class=icon-form-print></i> Casemix Identitas", "javascript:printCasemixIden(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print Casemix Identitas"))
                        . "<br>" .
                        CHtml::link("<i class=icon-form-print></i> Kepala Les", "javascript:printKepalaLes(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print Casemix"));


                    return $html;
                },
            ),
            //            array(
            //                'header'=>'No. RM <br> No. Pendaftaran',
            //                'name'=>'no_pendaftaran',
            //                'type'=>'raw',
            //                'value'=>'(!empty($data->no_pendaftaran) ? CHtml::link("<i class=entypo-print></i> ".$data->no_pendaftaran, "javascript:print(\'$data->pasienadmisi_id\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Print Lembar Poli")) : "-") . "<br>" . CHtml::link("<i class=icon-pencil-brown></i> ".$data->no_rekam_medik, Yii::app()->createUrl("pendaftaranPenjadwalan/InfoKunjunganRJ/ubahPasien",array("id"=>"$data->pasien_id", "menu"=>"RI")),array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Edit Data Pasien"))',
            //                'htmlOptions'=>array('style'=>'text-align: left; width:120px')
            //            ),
            array(
                'header' => 'No. Rekam Medik',
                'name' => 'no_rekam_medik',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align: center;'),
                'value' => function ($data) {
                    if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                        return $data->no_rekam_medik;
                    } else {
                        echo CHtml::link(
                            "<i class='icon-form-ubah'></i><br>" . $data->no_rekam_medik,
                            Yii::app()->createUrl("/pendaftaranPenjadwalan/InfoKunjunganRJ/ubahPasienAjax", array("pendaftaran_id" => $data->pendaftaran_id)),
                            array(
                                "class" => "",
                                "target" => "frameEditPasien",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Mengubah Data Pasien",
                                "onclick" => "$('#editPasien').dialog('open');return true;"
                            )
                        );
                        echo " <br> ";
                        echo CHtml::link("<i class=icon-form-print></i> Gelang Dewasa", "javascript:printLabelGelang(" . $data->pasien_id . ", " . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print gelang pasien Dewasa"));
                        echo " <br> ";
                        echo CHtml::link("<i class=icon-form-print></i> Gelang Anak", "javascript:printLabelGelangAnak(" . $data->pasien_id . ", " . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print gelang pasien Anak"));
                        echo " <br> ";
                        echo CHtml::link("<i class=icon-form-print></i> Status Pasien", "javascript:printStatus(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print gelang pasien Anak"));
                        echo " <br> ";
                        echo CHtml::link("<i class=icon-form-print></i> Label", "javascript:printLabel(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print label pasien"));
                        echo "</br>";
                        echo CHtml::link("<i class=icon-form-print></i> Daftar DPJP", "javascript:printDPJP(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print daftar DPJP"));
                    }
                }
            ), /*
                array(
                        'header'=>'No. Pendaftaran',
                        'name'=>'no_pendaftaran',
                        'type'=>'raw',
                        'value'=>'',
                        'htmlOptions'=>array('style'=>'text-align: center;')
                ), /*
    array(
        'header'=>'Nama Depan',
        'type'=>'raw',
        'value'=>'$data->namadepan'
    ), */
            array(
                'header' => 'Nama Pasien/Tanggal lahir/Jenis Kelamin',
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
                    echo "<hr>";
                    echo MyFormatter::formatDateTimeForUser($data->tanggal_lahir);
                    echo "<br>";
                    echo "<hr>";
                    if (!empty($data->jeniskelamin) && ($data->statusperiksa != Params::STATUSPERIKSA_SUDAH_PULANG)) {
                        echo CHtml::link("<i class=icon-form-ubah></i> " . $data->jeniskelamin, " ", array("onclick" => "ubahJenisKelamin('" . $data->no_rekam_medik . "');$('#editJenisKelamin').dialog('open');return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Mengubah Data Jenis Kelamin Pasien"));
                    } else {
                        echo $data->jeniskelamin;
                    }
                    echo "<br>";
                    echo "<hr>";
                    // echo  CHtml::link(
                    //     '<i class="icon-form-lihat"></i> Lihat Berkas',
                    //     Yii::app()->controller->createUrl("/rawatInap/pemeriksaanPasien", array("pendaftaran_id" => $data->pendaftaran_id, 'pasienadmisi_id' => $data->pasienadmisi_id,'lihat' => 1)),
                    //     array(
                    //         "rel" => "tooltip",
                    //         "title" => "Klik untuk melihat berkas pasien",
                    //         "target" => "blank",
                    //     )
                    // );
                }
            ),
            array(
                'header' => 'Status Masuk/<br>Cara Masuk',
                'type' => 'raw',
                'value' => '$data->statusmasuk."/<br>".$data->caramasuk_nama',
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
            array(
                'name' => 'CaraBayar/Penjamin',
                'type' => 'raw',
                //							'value'=>'((!empty($data->CaraBayarPenjamin)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? 
                //							 CHtml::Link("<i class=icon-pencil></i>$data->CaraBayarPenjamin",Yii::app()->createUrl("pendaftaranPenjadwalan/infoKunjunganRI/ubahCaraBayarRI",array("id"=>$data->pendaftaran_id,"frame"=>true)),
                //									 array("class"=>"", 
                //										   "target"=>"iframeUbahCaraBayar",
                //										   "onclick"=>"$(\'#carabayardialog\').dialog(\'open\');",
                //										   "rel"=>"tooltip",
                //										   "title"=>"Klik untuk Mengubah Jenis Penjamin & Penjamin pasien",
                //							 )): $data->CaraBayarPenjamin)',
                //							'htmlOptions'=>array(
                //								'style'=>'text-align: left',
                //								'class'=>'inap'
                'value' => '((!empty($data->CaraBayarPenjamin)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? 
                     CHtml::Link("<i class=icon-form-ubah></i>$data->CaraBayarPenjamin",Yii::app()->createUrl("pendaftaranPenjadwalan/infoKunjunganRI/ubahCaraBayarRI",array("id"=>$data->pendaftaran_id,"frame"=>true)),
                    array("class"=>"", 
                              "onclick"=>"$(\'#carabayardialog\').dialog(\'open\');loadFormCaraBayar(this);return false;",
                              "rel"=>"tooltip",
                              "title"=>"Klik untuk Mengubah Jenis Penjamin & Penjamin pasien",
                    )): $data->CaraBayarPenjamin)',
                'htmlOptions' => array(
                    'style' => 'text-align: left;',
                    'class' => 'inap'
                )
            ),
            //'alamat_pasien',
            /*
    array(
       'header'=>'Cara Masuk',
       'type'=>'raw',
       'value'=>'$data->caramasuk_nama',
    ), */
            // [
            //     'header' => 'Checklist Berkas',
            //     'type' => 'raw',
            //     'value' => function ($data) {
                
            //         // icon resume atau ringakasan keluar dan masuk
            //         $ringkasan = CHtml::Link(
            //             "<i class=icon-form-verifikasi></i>",
            //             Yii::app()->createUrl("rawatInap/RingkasanMasukKeluar/index", array("pendaftaran_id" => $data->pendaftaran_id, 'frame' => 1)),
            //             array(
            //                 "class" => "",
            //                 "target" => "iframeRingkasan",
            //                 "onclick" => "$(\"#dialogRingkasan\").dialog(\"open\");",
            //                 "rel" => "tooltip",
            //                 "title" => "Klik untuk Proses ringkasan keluar dan masuk",
            //             )
            //         ) . '(Resume)';
                    

            //         // icon cecklis berkas
            //         $checklist = CHtml::Link(
            //             "<i class=icon-form-verifikasi></i>",
            //             Yii::app()->createUrl(Yii::app()->controller->module->id . "/resumeMedis/checklistBerkasRI", array("pendaftaran_id" => $data->pendaftaran_id, 'pasienadmisi_id' => $data->pasienadmisi_id, "frame" => true)),
            //             array(
            //                 "class" => "",
            //                 "target" => "iframeChecklistBerkas",
            //                 "onclick" => "$(\"#dialogChecklistBerkas\").dialog(\"open\");",
            //                 "rel" => "tooltip",
            //                 "title" => "Klik untuk Checklist Kelengkapan Berkas",
            //             )
            //         ) . "Checklist Berkas";

            //         $checklistAda = KelengkapandokumenT::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id, 'pasienadmisi_id' => $data->pasienadmisi_id]);

            //         $infoChecklist = '';
            //         if(!empty($checklistAda)) {
            //             $infoChecklist = '<i class="icon-form-check"></i><br>' . $checklistAda->loginpemakai->pegawai->namaLengkap . '<br><b>' . MyFormatter::formatDateTimeForUser($checklistAda->create_time) . '</b>';
            //         }

            //         return $checklist . '<br>' . $infoChecklist;
            //     }
            // ],
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
            //             Yii::app()->createUrl(Yii::app()->controller->module->id . "/verifikasiDiagnosa/index", array("id" => $data->pendaftaran_id, "menu" => "RI", "frame" => true)),
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
            array(
                'header' => 'Status Konfirmasi',
                'type' => 'raw',
                'value' => '($data->status_konfirmasi == "" ) ? "-" : $data->status_konfirmasi',
            ),
            array(
                'header' => 'Ruangan/<br>Kelas Pelayanan/<br>Kamar/<br>Pindah Kamar',
                'name' => 'ruangan_nama',
                'type' => 'raw',
                'value' => function ($data) {
                    echo $data->ruangan_nama . "/<br>" . $data->kelaspelayanan_nama;
                    echo "/<br>";
                    echo "Kamar: " . $data->kamarruangan_nokamar . "<br>" . "Bed: " . $data->kamarruangan_nobed;
                    echo "<hr>";
                    $cekPembayaran = (PasienpulangT::model()->cekSisaPembayaran($data->pendaftaran_id) == false) ? 'ada' : 'tidak';
                    if ($cekPembayaran == 'ada') {
                        $alert = 'Pasien sudah membuat rencana pulang';
                    } else {
                        $alert = 'Tagihan Pasien Sudah Lunas. Anda tidak dapat melakukan transaksi ini.';
                    }
                    if (empty($data->renPulang)) {
                        if (!empty($data->pasienpulang_id)) {
                            echo $data->carakeluar;
                        } else {
                            if (!empty($data->kamarruangan_nokamar)) {
                                $time_masukkamar = strtotime($data->tglmasukkamar);
                                echo CHtml::link("<i class='icon-form-pindahkamar'></i> ", Yii::app()->controller->createUrl(Yii::app()->controller->id . '/PindahKamarPasienRI', array("pendaftaran_id" => $data->pendaftaran_id)), array("title" => "Klik untuk Pindah Kamar", "target" => "iframePindahKamar", "onclick" => "validasiDialogPindahKamar(" . $data->pendaftaran_id . ", " . $time_masukkamar . "); return false;", "rel" => "tooltip"));
                            } else {
                                echo CHtml::link("<i class='icon-form-pindahkamar'></i> ", "#", array("title" => "Klik untuk Pindah Kamar", "target" => "iframePindahKamar", "onclick" => "myAlert('Pasien belum masuk kamar.'); return false;", "rel" => "tooltip"));
                            }
                        }
                    } else {
                        echo CHtml::link("<i class='icon-form-pindahkamar'></i> ", "#", array("title" => "Klik untuk Pindah Kamar", "target" => "iframePindahKamar", "onclick" => "myAlert('" . $alert . "','Perhatian'); return false;", "rel" => "tooltip"));
                    }
                },
                /*
        'value'=>'(
            (!empty($data->ruangan_nama)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? 
                CHtml::link(
                    "<i class=icon-form-ubah></i> ".$data->ruangan_nama,
                    " ",
                    array(
                        "onCLick"=>"gantiPoli(\'$data->pendaftaran_id\',\'$data->ruangan_id\',\'$data->instalasi_id\',\'$data->pasien_id\',\'$data->nama_pasien\',\'$data->pasienadmisi_id\');return false;",
                        "rel"=>"tooltip",
                        "title"=>"Klik untuk Mengubah Ruangan Pasien"
                    )
                ) : 
                $data->ruangan_nama
            )',
         * 
         */
                'htmlOptions' => array(
                    'style' => 'text-align: left;',
                    //'class'=>'inap'
                )
            ),
            // array(
            //     'header'=>'P3 / Asuransi',
            //     'type'=>'raw',
            //     'value'=>'$data->namapemilik_asuransi',
            // ),
            array(
                'header' => 'Dokter Penerima/<br>DPJP',
                'type' => 'raw',
                'value' => function ($data) {
                    $admisi = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);
                    if (empty($admisi->dokterpenerima_id)) return null;
                    $penerima = PegawaiM::model()->findByPk($admisi->dokterpenerima_id);
                    echo $penerima->namaLengkap;
                    echo "/<br>";
                    if (!empty($data->nama_pegawai) && ($data->statusperiksa != Params::STATUSPERIKSA_BATAL_PERIKSA)) {
                        echo     CHtml::Link(
                            "<i class=icon-form-ubah></i>$data->gelardepan $data->nama_pegawai $data->gelarbelakang_nama",
                            Yii::app()->createUrl("pendaftaranPenjadwalan/infoKunjunganRI/ubahDokterPeriksaRI", array("id" => $data->pendaftaran_id, "frame" => true)),
                            array(
                                "class" => "",
                                "onclick" => "$('#editDokterPeriksa').dialog('open');loadFormDokterPeriksa(this);return false;",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Mengubah Data DPJP",
                            )
                        );
                    } else {
                        echo $data->gelardepan;
                    }
                },
            ),
            //                        array(
            //                           'name'=>'Nama Dokter',
            //                           'type'=>'raw',
            //                           'value'=>'"<div style=\'width:120px;\'>" . CHtml::link("<i class=icon-form-ubah></i> ". $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama," ",array("onclick"=>"ubahDokterPeriksa(\'$data->pendaftaran_id\');$(\'#editDokterPeriksa\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Data Dokter Periksa")) . "</div>"',
            //                           'htmlOptions'=>array(
            //                                'style'=>'text-align:center;',
            //                                'class'=>'inap'
            //                           )
            //                        ),
            /*
    array(
       'name'=>'Kelas Pelayanan',
       'type'=>'raw',
       //'value'=>'"<div style=\'width:50px;\'>" . CHtml::link("<i class=icon-form-ubah></i>". $data->kelaspelayanan_nama," ",array("onclick"=>"ubahKelasPelayanan(\'$data->pendaftaran_id\');$(\'#editKelasPelayanan\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Data Kelas Pelayanan")) . "</div>"',
       'value'=>'$data->kelaspelayanan_nama',
       'htmlOptions'=>array(
            'style'=>'text-align:center;',
            'class'=>'inap'
       )
    ), */
            /*
    array(
            'header'=>'Pemeriksaan Fisik & Anamnesa',
            'type'=>'raw',
            'value'=>'(CHtml::link("<i class=\'icon-form-periksa\'></i> ", Yii::app()->controller->createUrl("/pendaftaranPenjadwalan/pemeriksaanFisikAnamnesaRI",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Fisik & Anamnesa Pasien")))',
            'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
        ),
    array(
       'header'=>'Verifikasi Diagnosa',
       'type'=>'raw',
       'value'=>''
        .'(isset($data->Morbiditas->pasienmorbiditas_id) ? "<div class=\"inap\" style=\"background-color:#33FF00; text-align: left\">" : "<div style=\"background-color:#FF0000; text-align: center\">")'
        .'.(CHtml::Link("<i class=icon-form-verifikasi></i> Verifikasi Diagnosa",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/verifikasiDiagnosa/index",array("id"=>$data->pendaftaran_id,"menu"=>"RI","frame"=>true)),
                    array("class"=>"", 
                          "target"=>"iframeVerifikasiDiagnosa",
                          "onclick"=>"$(\"#dialogVerifikasiDiagnosa\").dialog(\"open\");",
                          "rel"=>"tooltip",
                          "title"=>"Klik Verifikasi Diagnosa",
            )))."</div>"',  
    ), */
            array(
                'header' => 'Tindak Lanjut',
                'type' => 'raw',
                'value' => function ($data) {
                    $url = !empty($data->kamarruangan_nokamar) ? Yii::app()->controller->createUrl("/rawatInap/verifikasiTindakan", array("pendaftaran_id" => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id)) : "#";
                    $click = !empty($data->kamarruangan_nokamar) ? "return true" : "myAlert('Pasien belum masuk kamar.'); return false;";
                    // echo (CHtml::link("<i class='icon-form-detailtagihan'></i><br>Verifikasi Tindakan", $url, array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Verifikasi Tindakan Pasien", "onclick" => $click)));
                    $cekPembayaran = (PasienpulangT::model()->cekSisaPembayaran($data->pendaftaran_id) == false) ? 'ada' : 'tidak';
                    $tindakan = TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')), array(
                        'condition' => 'karcis_id is null'
                    ));
                    // echo "<hr>";
                    if (empty($data->kamarruangan_nokamar)) {
                        echo "Belum Masuk Kamar";
                    } else {
                        if (!empty($data->pasienpulang_id)) {
                            echo $data->carakeluar;
                        } else {
                            if ($cekPembayaran == 'ada') {
                                // echo CHtml::link("<i class='icon-form-pulang'></i><br>Pemulangan", "javascript:;", array(
                                //     "title" => "Klik untuk Pemulangan Pasien",
                                //     "onclick" => "myAlert('Tagihan pasien belum diselesaikan di Kasir','Perhatian')"
                                // ));
                                // echo CHtml::link("<i class='icon-form-ambiljenazah'></i><br>Meninggal", Yii::app()->controller->createUrl(Yii::app()->controller->id . '/TindakLanjutDariPasienRI', array("pendaftaran_id" => $data->pendaftaran_id, "meninggal" => 1)), array(
                                //     "title" => "Klik untuk Menyatakan Pasien Meninggal", "target" => "iframeTindakLanjut",
                                //     "onclick" => "verifikasiPasienMeninggal(" . $data->pendaftaran_id . ")", "rel" => "tooltip"
                                // ));
                            } else {
                                // echo CHtml::link("<i class='icon-form-pulang'></i>", Yii::app()->controller->createUrl(Yii::app()->controller->id . '/TindakLanjutDariPasienRI', array("pendaftaran_id" => $data->pendaftaran_id)), array(
                                //     "title" => "Klik untuk Pemulangan Pasien", "target" => "iframeTindakLanjut",
                                //     "onclick" => "verifikasiPulangPasien(" . $data->pendaftaran_id . ")", "rel" => "tooltip"
                                // ));
                            }
                        }
                    }
                    echo "<hr>";
                    $pen = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                    $cekPembayaran = (PasienpulangT::model()->cekSisaPembayaran($data->pendaftaran_id) == false) ? 'ada' : 'tidak';
                    $cekDok = false;
                    if (!empty($pen->pengirimanrm_id)) {
                        if (Yii::app()->user->getState('ruangan_id') == $pen->pengirimanrm->ruanganpenerima_id) {
                            if (empty($pen->pengirimanrm->tglterimadokrm)) {
                                return CHtml::link('<i class="icon-form-silang"></i>', "javascript:;", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left', 'onclick' => 'myAlert("Harap terima dan kembalikan dokumen RM sebelum Anda membatalkan pemeriksaan pasien ' . $data->nama_pasien . ' ","Perhatian")'));
                            } else {
                                return CHtml::link('<i class="icon-form-silang"></i>', "javascript:;", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left', 'onclick' => 'myAlert("Harap kembalikan dokumen RM sebelum Anda membatalkan pemeriksaan pasien ' . $data->nama_pasien . ' ","Perhatian")'));
                            }
                        } else {
                            $cekDok = true;
                        }
                    } else {
                        $cekDok = true;
                    }
                    if ($cekDok == true) {
                        $is_alert = false;
                        if ($cekPembayaran == 'ada') {
                            $alert = 'Pasien sudah membuat rencana pulang';
                        } else {
                            $alert = 'Tagihan Pasien Sudah Lunas. Anda tidak dapat melakukan transaksi ini.';
                        }
                        if ($data->is_anamnesa || $data->is_periksafisik || $data->is_diagnosa || $data->is_tindakan)  {
                           $alert = 'Pasien tidak bisa dibatalkan karena sudah dilakukan pemeriksaan.';
                           $is_alert = true;
                        }
                       
                        if (empty($data->renPulang) && !$is_alert) {
                            echo CHtml::link("<i class='icon-form-silang'></i>", Yii::app()->controller->createUrl(Yii::app()->controller->id . '/batalRawatInap', array("pendaftaran_id" => $data->pendaftaran_id)), array(
                                "title" => "Klik untuk Batal Rawat Inap", "target" => "iframeBatalRawatInap",
                                "onclick" => "validasiSep($data->pendaftaran_id)",
                                //"onclick" => "$('#dialogBatalRawatInap').dialog('open');", 
                                "rel" => "tooltip"
                            ));
                        } else {
                            echo CHtml::link("<i class='icon-form-silang'></i>", "javascript:;", array(
                                "title" => "Klik untuk Batal Rawat Inap",
                                "onclick" => "myAlert('" . $alert . "','Perhatian')", "rel" => "tooltip"
                            ));
                        }
                    }
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
            ),
            array(
                'header' => 'Status Periksa / <br> Check Pemeriksaan',
                'name' => 'statusperiksa',
                'type' => 'raw',
                'value' => function ($data) {
                    $str = Params::getWrStatusPeriksa($data->statusperiksa);
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
                    'style' => 'text-align: left;',
                    'class' => 'status'
                )
            ),
            array(
                'name' => 'keterangan_pendaftaran',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
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
            array(
                'header' => 'Petugas Loket',
                'type' => 'raw',
                'value' => function ($data) {
                    $lp = LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id);
                    return empty($lp->pegawai_id) ? $lp->nama_pemakai : $lp->pegawai->namaLengkap;
                }
            ),
            array(
                'header' => 'Case Manager',
                'type' => 'raw',
                'value' => function ($data) {
                    $link = CHtml::link('<i class="icon-form-periksa"></i> ', Yii::app()->createUrl('rekamMedis/ManagerPelayananPasien/index', array("pendaftaran_id" => $data->pendaftaran_id, 'typeinstalasi' => 'RI')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Case Manager"));
                    return $link;
                },
                'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                'visible' => ((Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_REKAM_MEDIS) ? true : false)
            )
        ),
        'afterAjaxUpdate' => 'function(id, data){
    jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
    disableLink();
}',
    )
);

?>