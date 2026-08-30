<?php 

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pencarianpasien-grid',
    'dataProvider' => $model->searchInformasiPasienResep(),
    //        'filter'=>$model,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'No. Antrian',
            'type' => 'raw',
            'value' => function ($data) {
                $modAntrian = AntrianfarmasiT::model()->findByAttributes(array('reseptur_id' => $data->reseptur_id), array(
                    'order' => 'antrianfarmasi_id desc'
                ));
                if (!empty($modAntrian->antrianfarmasi_id)) {
                    $modelLoket = ModelantrianM::model()->findByPk(array(
                        $modAntrian->modelantrian_id
                    ));
                    $str = $modAntrian->racikan->racikan_singkatan . "-" . $modAntrian->noantrian . '<br>';
                    if (!empty($modelLoket)) {
                        $str = $modelLoket->modelantrian_kode . $str;
                    }
                    if ($modAntrian->panggilantrian && $modAntrian->jumlah_panggil == 30) {
                        return $str . "Sudah Dipanggil";
                    }
                    return $str . "<br>" . CHtml::htmlButton(Yii::t("mds", "{icon}", array("{icon}" => '<i class="icon-volume-up icon-white"></i>')), array(
                        "class" => "btn btn-primary",
                        "onclick" => 'panggilAntrian("' . $modAntrian->antrianfarmasi_id . '")', "rel" => "tooltip", "title" => "Klik untuk memanggil pasien ini"
                    ));
                } else {
                    return CHtml::link('<i class="entypo-megaphone"></i><i class="icon-plus icon-white"></i>', $this->createUrl('ambilKarcisFarmasiApotek/index', array(
                        'reseptur_id' => $data->reseptur_id,
                    )), array(
                        'class' => 'btn btn-success',
                        'rel' => 'tooltip',
                        'title' => 'Klik untuk Tiket Antrian Farmasi'
                    ));
                }
            },
            'htmlOptions' => array('style' => 'text-align: center;'),
        ),
        array(
            'header' => 'Tgl. Resep/<br>No. Resep',
            'name' => 'tglreseptur."/<br>".$data->noreseptur',
            'type' => 'raw',
            'value' => function ($data) {
                $resep_emergency = $resep_cito = "";
                if ($data->is_resepemergency == true) {
                    $resep_emergency = "<br> <span style='color: red;'> Resep Emergency </span>";
                }

                if ($data->is_cito == true) {
                    $resep_cito = "<br> <span style='color: red;'> Resep CITO </span>";
                }

                echo MyFormatter::formatDateTimeForUser($data->tglreseptur)."<br>".$data->noreseptur .$resep_emergency . $resep_cito ;
            },
        ),
        array(
            'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
            'type' => 'raw',
            'name' => 'tgl_pendaftaran',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br>".$data->no_pendaftaran',
        ),
        //'no_pendaftaran',
        array(
            'header' => 'Nama Pasien/ No. Rekam Medik /NIK/Jenis Kelamin/<br>Umur ',
            'name' => 'nama_pasien',
            'value' => function ($data) {
                echo  CHtml::link(
                    "<b>".$data->namadepan . $data->nama_pasien."</b>",
                    Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/getRiwayatPasien", array("id" => $data->pasien_id)),
                    array(
                        "rel" => "tooltip",
                        "title" => "Klik untuk melihat riwayat pemeriksaan pasien",
                        "target" => "frameRiwayatPasien",
                        "onclick" => "$('#dialogRiwayatPasien').dialog('open');"
                    )
                );
                echo "<br>";
                echo "<b>".$data->no_rekam_medik."</b>";
                echo "<br>";
                echo "<b>".$data->pasien_noidentitas."</b>";
                echo "<br>";
                echo $data->jeniskelamin . "/<br>" . $data->umur;
                echo "<br>";
                echo CHtml::link('<i class="icon-form-print"></i>&nbsp;Cetak Identitas', '#', array('onclick'=>'printIdentitas('.$data->pasien_id.'); return false;'));

                
            },
        ),
        array(
            'header' => 'Tempat Lahir/ Tanggal Lahir Pasien ',
            'name' => 'nama_pasien',
            'value' => function ($data) {
                return $data->tempat_lahir .' / '. (!empty($data->tanggal_lahir)? MyFormatter::formatDateTimeForUser($data->tanggal_lahir): "");
            },
        ),
        'jeniskasuspenyakit_nama',
        //'nama_bin',
        array(
            'header' => 'Jenis Penjamin/<br>Penjamin / <br> No. SEP',
            'type' => 'raw',
            'value' => function($data){
                $str = $data->carabayar_nama . "<br/>" . $data->penjamin_nama;

                if ($data->carabayar_id == Params::CARABAYAR_ID_BPJS) {
                    // var_dump($data->pendaftaran_id);
                    $cr = new CDbCriteria;
                    $cr->join = "join pendaftaran_t p on p.sep_id = t.sep_id";
                    $cr->compare("p.pendaftaran_id", $data->pendaftaran_id);
                    $as = SepT::model()->find($cr);
                    if (!empty($as->nosep)) {
                        $str .= "<br/>" . CHtml::link('<b>' . $as->nosep . '</b>', Yii::app()->controller->createUrl('/rawatJalan/daftarPasien/printSEP', array('sep_id' => $as->sep_id, 'pendaftaran_id' => $data->pendaftaran_id, 'preview' => 1)), array(
                            'target' => 'frame_sep',
                            'onclick' => "$('#dialog_sep').dialog('open')",
                        ));
                    }
                }
                $modPendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                $modSep = SepT::model()->findByAttributes(array('sep_id' => $modPendaftaran->sep_id));
                if (!empty($modSep)) {
                    $str .= "<br>";
                    $str .= CHtml::Link(
                        "<i class=icon-form-detail></i> Riwayat Pelayanan BPJS",
                        "",
                        array(
                            "class" => "",
                            "onclick" => "riwayatPelayanan('" . $modSep->nokartuasuransi . "', " . $modPendaftaran->pegawai->kodedokter_bpjs . ")",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Melihat Riwayat Pelayanan",
                            "style" => "cursor: pointer !important;"
                        )
                    );
                }

                return $str;
            },
        ),
        array(
            'header' => 'Dokter/<br> PPDS /<br>Ruangan',
            'name' => 'pegawai_nama',
            'type' => 'raw',
            'value' => function($data) {
                $ppds = PasienPpdsT::model()->findByPk(['ppds_id'=>$data->ppds_id]);
                $ppds = !empty($ppds->ppds->ppds_nama) ? $ppds->ppds->ppds_nama : " &nbsp; - ";
                return $data->gelardepan." ".$data->nama_pegawai.".".$data->gelarbelakang_nama."/<br>".
                $ppds."/<br>".$data->ruanganreseptur_nama
                ;
            }
             ),
        array(
            'header' => 'Kamar/<br>Bed/<br>Kelas Pelayanan',
            'type' => 'raw',
            'value' => function($data) {
                $kelas = KelaspelayananM::model()->findByPk(['kelaspelayanan_id'=>$data->kelaspelayanan_id]);
                $kelas = !empty($kelas->kelaspelayanan_nama) ? $kelas->kelaspelayanan_nama : "-";
                return $data->kamarruangan_nokamar." / ".$data->kamarruangan_nobed." / ".$kelas;
            }
            // 'value' => '$data->kamarruangan_nokamar."/<br>".$data->kamarruangan_nobed',
        ),
        array(
            'header' => 'Status Periksa',
            'type' => 'raw',
            'value' => function ($data) {
                $pd = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                return Params::getWrStatusPeriksa($pd->statusperiksa);
            },
        ),
        //'car,abayar_nama',
        //'penjamin_nama',
        //'umur',
        //'instalasi_nama',
        //'ruangan_nama',
        array(
            'header' => 'Riwayat Pasien',
            'type' => 'raw',
            'value' => function ($data) {
              //  return Yii::app()->controller->renderPartial('_diagnosa', array('pendaftaran_id' => $data->pendaftaran_id), true);
               return CHtml::link("<i class='icon-form-periksa'></i><br>Riwayat Pasien", Yii::app()->controller->createUrl("/rawatJalan/pemeriksaanPasien/index2",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>$data->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien",  
                'target'=>'frameRiwayatPasien',
               'onclick'=>"$('#dialogRiwayatPasien').dialog('open');"));

              
            }
        ),
        array(
            'header' => 'Catatan Pemberian Obat',
            'value' => function ($data) {
                if($data->instalasireseptur_id==4){
                    if(!empty($data->penjualanresep_id)){
                        // echo CHtml::link('<a rel="tooltip" title="Tidak dapat diubah karena sudah diketahui oleh Manager Keuangan"><icon class="icon-form-ubah" style="opacity: 0.3"></icon></a> ');
                        echo CHtml::link('<icon class=\'icon-form-ubah\'></icon> ',  Yii::app()->createUrl("rawatInap/pemberianObatRutin/Create",array("pendaftaran_id"=>$data->pendaftaran_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Catatan", "return false;"));
                    }else{
                        echo CHtml::link('<icon class=\'icon-form-ubah\'></icon> ',  Yii::app()->createUrl("rawatInap/pemberianObatRutin/Create",array("pendaftaran_id"=>$data->pendaftaran_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Catatan", "return false;"));
                    }
                }else{
                    echo 'Bukan Pasien Rawat Inap';
                }
        }),
        array(
            'header' => 'Alergi Obat',
            'type' => 'raw',
            'value' => '$data->AlergiObat',
            //'htmlOptions'=>array('style'=>'text-align: left; width:120px'),
            'headerHtmlOptions' => array('style' => 'width:120px'),
        ),
        array(
            'header' => 'Riwayat Obat',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::link('<i class="icon-form-reseptur"></i>', Yii::app()->controller->createUrl('informasiResepPasien/riwayatObat', array('id'=>$data->pendaftaran_id)), array(
                    'target'=>'frameRiwayatObat',
                    'onclick'=>"$('#dialogRiwayatObat').dialog('open');",
                ));
            },
            'htmlOptions' => array(
                "nowrap" => "",
                'style' => 'text-align: center;',
            )
        ),
        array(
            'header' => 'Reseptur Dokter',
            'type' => 'raw',
            'value' => function ($data) use (&$ada_racikan, &$ada_nonracikan) {
                $link = array();
                $ada_racikan = false;
                $ada_nonracikan = false;
                $racikan = ResepturdetailT::model()->findByAttributes(array(
                    'reseptur_id' => $data->reseptur_id,
                    'racikan_id' => Params::RACIKAN_ID_RACIKAN,
                ));
                $nonRacikan = ResepturdetailT::model()->findByAttributes(array(
                    'reseptur_id' => $data->reseptur_id,
                    'racikan_id' => Params::RACIKAN_ID_NONRACIKAN,
                ));
                if (!empty($racikan)) {
                    $ada_racikan = true;
                    $link[] = CHtml::Link(
                        '<i class="icon-form-reseptur"></i><br>Racikan',
                        Yii::app()->createUrl("farmasiApotek/InformasiPasienResep/printResepDokter", array("id" => $data->reseptur_id, "racikan_id" => Params::RACIKAN_ID_RACIKAN, "frame" => 1)),
                        array(
                            "class" => "",
                            "target" => "iframeReseptur",
                            "onclick" => "$(\"#dialogReseptur\").dialog(\"open\");",
                            "rel" => "tooltip",
                            "title" => "Klik untuk print reseptur dokter (Racikan)",
                        )
                    );
                }
                if (!empty($nonRacikan)) {
                    $ada_nonracikan = true;
                    $link[] = CHtml::Link(
                        '<i class="icon-form-reseptur"></i><br>Non Racikan',
                        Yii::app()->createUrl("farmasiApotek/InformasiPasienResep/printResepDokter", array("id" => $data->reseptur_id, "racikan_id" => Params::RACIKAN_ID_NONRACIKAN, "frame" => 1)),
                        array(
                            "class" => "",
                            "target" => "iframeReseptur",
                            "onclick" => "$(\"#dialogReseptur\").dialog(\"open\");",
                            "rel" => "tooltip",
                            "title" => "Klik untuk print reseptur dokter (Non Racikan)",
                        )
                    );
                }
                if(!$data->penjualanresep_id){
                    $link[] =  "<p style=\"margin: 0; text-align: center;\">-</p>";
                }else{
                    $link[] =  CHtml::Link("<i class=\"icon-form-copy\"></i><br>Copy Resep",Yii::app()->controller->createUrl("PenjualanDariReseptur/CopyResep",array("penjualanresep_id"=>$data->penjualanresep_id,"pasien_id"=>$data->pasien_id)),
                    array("class"=>"",
                        "target"=>"iframeCopyResep",
                        "onclick"=>"$(\"#dialogCopyResep\").dialog(\"open\");",
                        "rel"=>"tooltip",
                        "title"=>"Klik untuk Copy Resep ",
                    ));
                }
                           
                return implode("<br>", $link);
            },
            'htmlOptions' => array(
                "nowrap" => "",
                'style' => 'text-align: center;',
            )
        ),
        array(
            'header' => 'CPPT',
            'type' => 'raw',
            'value' => function ($data){

                return CHtml::Link(
                    '<i class="icon-bayarklaim"></i><br>',
                    Yii::app()->createUrl("rekamMedis/CPPTRK/indexFA", array("pendaftaran_id" => $data->pendaftaran_id, "frame" => 1)));
                }
                ),
        array(
            'header' => 'Reseptur Penjualan',
            'type' => 'raw',
            'value' => function ($data){
                // $ada_racikan = false;
                // $ada_nonracikan = false;
                // $racikan = ObatalkespasienT::model()->findByAttributes(array(
                //     'penjualanresep_id' => $data->penjualanresep_id,
                //     // 'racikan_id' => Params::RACIKAN_ID_RACIKAN,
                // ));
                // $nonRacikan = ObatalkespasienT::model()->findByAttributes(array(
                //     'penjualanresep_id' => $data->penjualanresep_id,
                //     // 'racikan_id' => Params::RACIKAN_ID_NONRACIKAN,
                // ));
                if(!empty($data->penjualanresep_id)){
                    // if (!empty($racikan)) {
                        // $ada_racikan = true;
                    return CHtml::Link(
                        '<i class="icon-form-reseptur"></i><br>',
                        Yii::app()->createUrl("farmasiApotek/InformasiPasienResep/PrintResepPenjualan", array("penjualanresep_id" => $data->penjualanresep_id, "frame" => 1)),
                        array(
                            "class" => "",
                            "target" => "iframeResepturPenjualan",
                            "onclick" => "$(\"#dialogResepturPenjualan\").dialog(\"open\");",
                            "rel" => "tooltip",
                            "title" => "Klik untuk print reseptur penjualan (Racikan)",
                        )
                    );
                }else{
                    return "-";
                }
            }
        ),
        [
            'header' => 'Rincian Tagihan Sementara',
            'type' => 'raw',
            'value' => function($data) {
                $htmlLink2 = '<div class="small-container">' . CHtml::link('<i class="icon-form-detail"></i><br>Rincian Tagihan Sementara', Yii::app()->controller->createUrl('/billingKasir/pembayaranTagihanPasien/printRincianBelumBayarRD', array(
                    "instalasi_id" => $data->instalasi_id, "pendaftaran_id" => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id, "frame" => true)),
                     array('target' => 'iframeRincianTagihanSementara',  "rel" => "tooltip", "title" => "Klik untuk Melihat Detail Riwayat Pemindahaan Pasien",
                    'onclick' => "$('#dialogRincianTagihanSementara').dialog('open');",
                )) . '</div>';

                echo $htmlLink2;
            }
        ],
        array(
            'header' => 'Pelayanan Resep',
            'type' => 'raw',
            'value' => function ($data) use (&$is_dijual) {

                if ($data->isbatal) {
                    return "-";
                }

                $statusperiksa = $data->statusperiksa;
                $tindbayar = false;
                $oabayar = false;
                if (!empty($data->pendaftaran_id)) {
                    $cek = ObatalkespasienT::model()->find(" pendaftaran_id = '" . $data->pendaftaran_id . "' AND oasudahbayar_id IS NOT NULL ");
                    if (!empty($cek)) {
                        $oabayar = true;
                    }
                    $cekTin = TindakanpelayananT::model()->find(" pendaftaran_id = '" . $data->pendaftaran_id . "' AND tindakansudahbayar_id IS NOT NULL ");
                    if (!empty($cekTin)) {
                        $tindbayar = true;
                    }
                }
                $lanjut_transaksi = false;
                if (!empty($data->pembayaranpelayanan_id)) {                                    
                    if ($data->instalasireseptur_id == Params::INSTALASI_ID_RD) { // || $data->instalasireseptur_id == Params::INSTALASI_ID_RJ) {
                        // 
                        if (($statusperiksa == Params::STATUSPERIKSA_SUDAH_DIPERIKSA) && (($oabayar == true || $tindbayar == true))) {
                            $lanjut_transaksi = true;
                            // || $tindbayar == true
                        } elseif (($statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) && (($oabayar == true || $tindbayar == true))) {
                            $lanjut_transaksi = true;
                        } else {
                            if (($statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG)) {
                                $lanjut_transaksi = true;
                            } else {
                                // || $tindbayar == true
                                if ((($oabayar == true ))) {
                                    $lanjut_transaksi = true;
                                }
                            }
                        }
                    }
                }
                if (isset($data->penjualanresep_id)) {
                    $is_dijual = true;
                    return CHtml::link("<i class='icon-form-rincianjual'></i>", Yii::app()->createUrl('farmasiApotek/informasiPenjualanResep/detailPenjualan', array(
                        'id' => $data->penjualanresep_id, 'pasien_id' => $data->pasien_id
                    )), array(
                        'target' => 'iframeDetailPenjualan',
                        'rel' => 'tooltip',
                        'title' => 'Klik untuk melihat detail penjualan resep',
                        'onclick' => '$("#dialogDetailPenjualan").dialog("open")'
                    )) . $data->getNoPenjualanResep($data->reseptur_id);
                } else {
                    $is_dijual = false;
                    if ($lanjut_transaksi) {
                        return CHtml::Link(
                            "<i class='icon-form-jualresep'></i>",
                            'javascript:;',
                            array(
                                "class" => "",
                                "rel" => "tooltip",
                                "title" => "Klik untuk menjual resep",
                                'onclick' => 'myAlert("Tagihan Pasien Sudah Dilunaskan. Anda tidak dapat melakukan Penjualan Resep pada Pasien Ini.");'
                            )
                        );
                    } else {
                        return    CHtml::Link(
                            "<i class='icon-form-jualresep'></i>",
                            Yii::app()->controller->createUrl("PenjualanDariReseptur/Index", array("reseptur_id" => $data->reseptur_id)),
                            array(
                                "class" => "",
                                // "target"=>"iframePenjualanResep",
                                "rel" => "tooltip",
                                "title" => "Klik untuk melayani resep",
                                // "onclick"=>'$("#dialogPenjualanResep").dialog("open");',
                            )
                        );
                    }
                }
            },
            'htmlOptions' => array('style' => 'text-align: center;'),
        ),
        array(
            'header' => 'Etiket',
            'type' => 'raw',
            'value' => function ($data) use (&$is_dijual, &$ada_racikan, &$ada_nonracikan) {
                if (!$is_dijual) {
                    return "-";
                }
                $str = array();
                if ($ada_racikan) {
                    $str[] = CHtml::link('<i class="icon-form-print"></i><br>Racikan', Yii::app()->createUrl('/farmasiApotek/penjualanDariReseptur/printEtiket', array(
                        'penjualanresep_id' => $data->penjualanresep_id, 
                        'racikan' => Params::RACIKAN_ID_RACIKAN
                    )), array(
                        'target' => 'frameEtiket',
                        'onclick' => "$('#dialogEtiket').dialog('open');"
                    ));
                }
                if ($ada_nonracikan) {
                    $str[] = CHtml::link('<i class="icon-form-print"></i><br>Non Racikan', Yii::app()->createUrl('/farmasiApotek/penjualanDariReseptur/printEtiket', array(
                        'penjualanresep_id' => $data->penjualanresep_id, 
                        'racikan' => Params::RACIKAN_ID_NONRACIKAN
                    )), array(
                        'target' => 'frameEtiket',
                        'onclick' => "$('#dialogEtiket').dialog('open');"
                    ));
                }
               
                $pd = PenjualanresepT::model()->findByPk($data->penjualanresep_id);
               
                
                if(!empty($pd->pasienadmisi_id)) {
                    $str[] = CHtml::link('<i class="icon-form-print"></i><br>Etiket Rawat Inap', '', array(
                        'onclick' => 'printetiketRanapNew(' . $data->penjualanresep_id . ', false); return false;'
                    ));
                }
                return implode("<br>", $str);
            }
        ),
        array(
            'header' => 'Petugas Farmasi',
            'type' => 'raw',
            'value' => function ($data) {
                $pd = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                $statusperiksa = $pd->statusperiksa;
                $oabayar = false;
                if (!empty($data->pendaftaran_id)) {
                    $cek = ObatalkespasienT::model()->find(" pendaftaran_id = '" . $data->pendaftaran_id . "' AND oasudahbayar_id IS NOT NULL ");
                    if (!empty($cek)) {
                        $oabayar = true;
                    }
                }
                $lanjut_transaksi = false;
                if ($data->instalasireseptur_id == Params::INSTALASI_ID_RD || $data->instalasireseptur_id == Params::INSTALASI_ID_RJ) {
                    if (($statusperiksa == Params::STATUSPERIKSA_SUDAH_DIPERIKSA) && ($oabayar == true)) {
                        $lanjut_transaksi = true;
                    } elseif (($statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) && ($oabayar == true)) {
                        $lanjut_transaksi = true;
                    } else {
                        if (($statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG)) {
                            $lanjut_transaksi = true;
                        } elseif (($statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO)) {
                            $lanjut_transaksi = true;
                        } else {
                            if ($oabayar == true) {
                                $lanjut_transaksi = true;
                            }
                        }
                    }
                }
                // if ($lanjut_transaksi) return "-";
                if (empty($data->penjualanresep_id)) return "-";
                $jual = PenjualanresepT::model()->findByPk($data->penjualanresep_id);
                $login = LoginpemakaiK::model()->findByPk($jual->create_loginpemakai_id);
                if (empty($login->pegawai_id)) return "-";
                $peg = PegawaiM::model()->findByPk($login->pegawai_id);
                return $peg->namaLengkap;
                return "-";
            },
        ),
        [
            'header' => 'Resep Batal',
            'type' => 'raw',
            'value' => function ($row) {
                // if ($row->isbatal) {
                //     return 'Resep Batal';
                // } else {}
                if (!empty($row->reseptur_id)) {
                     return CHtml::Link("<i class='icon-trash'></i>",
                        'javascript:;',
                        array(
                            "class" => "",
                            "rel" => "tooltip",
                            "title" => "Klik untuk menghapus resep",
                            'onclick' => 'hapusresep(' . $row->reseptur_id . ')'
                        )
                    );
                }
            },
            'htmlOptions' => ['style' => 'text-align:center;']
        ]
        /*array(
                        'header'=>'Copy Resep',
                        'type'=>'raw',
                        'value'=>'(!$data->penjualanresep_id) ? "<p style=\"margin: 0; text-align: center;\">-</p>" :
                            CHtml::Link("<i class=\"icon-form-copy\"></i>",Yii::app()->controller->createUrl("PenjualanDariReseptur/CopyResep",array("penjualanresep_id"=>$data->penjualanresep_id,"pasien_id"=>$data->pasien_id)),
                            array("class"=>"",
                                "target"=>"iframeCopyResep",
                                "onclick"=>"$(\"#dialogCopyResep\").dialog(\"open\");",
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk Copy Resep ",
                            ))',
                        'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
                    ),*/
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));